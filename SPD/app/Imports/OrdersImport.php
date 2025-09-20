<?php
namespace App\Imports;

use App\Models\Order;
use App\Models\Part;
use App\Models\InnerPart;
use App\Models\OuterPart;
use App\Models\Customer;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OrdersImport implements ToModel, WithHeadingRow
{
    public $errorRows = []; // Inisialisasi default
    public $successfulRows = []; // Inisialisasi default
    public $rows = []; // Inisialisasi default

    public function model(array $row)
    {
        // Simpan setiap baris untuk referensi
        $this->rows[] = $row;
    
        // Cari part berdasarkan 'P_No'
        $part = Part::where('P_No', $row['part_no'])->first();
    
        if (!$part) {
            $this->errorRows[] = [
                'row' => $row,
                'error' => 'Part not found for Part No Customer: ' . $row['part_no']
            ];
            return null;
        }
    
        // Pastikan status part aktif
        if (!$part->status) {
            $this->errorRows[] = [
                'row' => $row,
                'error' => 'Part is inactive for Part No: ' . $row['part_no']
            ];
            return null;
        }
         // Cari inner part berdasarkan ID dari tabel `tbl_inner_part`
         $innerPart = InnerPart::find($part->inner_id);
         if (!$innerPart) {
             $this->errorRows[] = [
                 'row' => $row,
                 'error' => 'Inner Part not found for Part: ' . $part->P_No
             ];
             return null;
         }
 
         // Cari outer part berdasarkan ID dari tabel `tbl_outer_part`
         $outerPart = OuterPart::find($part->outer_id);
         if (!$outerPart) {
             $this->errorRows[] = [
                 'row' => $row,
                 'error' => 'Outer Part not found for Part: ' . $part->P_No
             ];
             return null;
         }
    
        // Validasi customer
        $customer = Customer::where('username', $row['customer_name'])->first();
        if (!$customer) {
            $this->errorRows[] = [
                'row' => $row,
                'error' => 'Customer not found for Name: ' . $row['customer_name']
            ];
            return null;
        }
    
        // Konversi tanggal
        $deliveryDate = $this->convertExcelDate($row['delivery_date']);
    
        // Validasi duplikasi berdasarkan kombinasi P_order dan cust_part_no
        $existingOrder = Order::where('P_order', $row['po'])
            ->where('P_no_cus', $part->cust_part_no)
            ->first();
    
        if ($existingOrder) {
            $this->errorRows[] = [
                'row' => $row,
                'error' => 'Duplicate order found for PO: ' . $row['po'] . ' and Customer Part No: ' . $part->cust_part_no
            ];
            return null;
        }
    
        // Simpan order baru
        $order = new Order([
            'id_part' => $part->id,
            'customer_id' => $customer->id,
            'id_inner_part' => $innerPart->id,
            'id_outer_part' => $outerPart->id,
            'P_order' => $row['po'],
            'Qty' => $row['qty'],
            'delivery_date' => $deliveryDate,
            'P_no_cus' => $part->cust_part_no,
            'catatan' => $row['catatan'] ?? 'Tidak ada',
        ]);
    
        $this->successfulRows[] = $order;
    
        return $order;
    }
    
    private function convertExcelDate($excelDateValue)
    {
        if (is_numeric($excelDateValue)) {
            $date = Date::excelToDateTimeObject($excelDateValue);
            return $date->format('d-m-Y');
        }
        return $excelDateValue;
    }

    public function getErrorRows(): array
    {
        return $this->errorRows;
    }

    public function getSuccessfulRows(): array
    {
        return $this->successfulRows;
    }
}

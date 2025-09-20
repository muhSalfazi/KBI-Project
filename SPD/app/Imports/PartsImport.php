<?php

namespace App\Imports;

use App\Models\Part;
use App\Models\InnerPart;
use App\Models\OuterPart;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PartsImport implements ToModel, WithHeadingRow
{
    public $errorRows = [];
    public $successfulRows = [];

    public function model(array $row)
    {
        // Validasi data
        $validator = Validator::make($row, [
            'part_name' => 'required|string|max:50',
            'part_no' => 'required|string|max:50',
            'cust_part_number' => 'required|string|max:50',
        ]);
    
        if ($validator->fails()) {
            $this->errorRows[] = [
                'row' => $row,
                'errors' => $validator->errors()->all(),
            ];
            return null;
        }
    
        // Cek apakah data sudah ada berdasarkan kunci unik
        $existingPart = Part::where('P_No', $row['part_no'])
            ->where('cust_part_no', $row['cust_part_number'])
            ->first();
    
        // Mulai transaksi untuk memastikan integritas data
        DB::beginTransaction();
    
        try {
            $innerPart = null;
            $outerPart = null;
    
            if ($existingPart) {
                // Jika part sudah ada, update inner dan outer part jika ada input
                if ($existingPart->inner_id && ($row['size_inner_part'] || $row['logo_inner_part'] || $row['label_inner_part'] || $row['qty_inner_part'])) {
                    $innerPart = InnerPart::find($existingPart->inner_id);
                    $innerPart->update([
                        'size_ip' => $row['size_inner_part'] ?? $innerPart->size_ip,
                        'logo_ip' => $row['logo_inner_part'] ?? $innerPart->logo_ip,
                        'label_ip' => $row['label_inner_part'] ?? $innerPart->label_ip,
                        'Qty_ip' => $row['qty_inner_part'] ?? $innerPart->Qty_ip,
                    ]);
                }
    
                if ($existingPart->outer_id && ($row['size_outer_part'] || $row['logo_outer_part'] || $row['label_outer_part'] || $row['qty_outer_part'])) {
                    $outerPart = OuterPart::find($existingPart->outer_id);
                    $outerPart->update([
                        'size_op' => $row['size_outer_part'] ?? $outerPart->size_op,
                        'logo_op' => $row['logo_outer_part'] ?? $outerPart->logo_op,
                        'label_op' => $row['label_outer_part'] ?? $outerPart->label_op,
                        'Qty_op' => $row['qty_outer_part'] ?? $outerPart->Qty_op,
                    ]);
                }
    
                $this->successfulRows[] = $existingPart;
            } else {
                // Jika part belum ada, buat inner, outer, dan part
                $innerPart = InnerPart::create([
                    'size_ip' => $row['size_inner_part'] ?? 'N/A',
                    'logo_ip' => $row['logo_inner_part'] ?? 'N/A',
                    'label_ip' => $row['label_inner_part'] ?? 'N/A',
                    'Qty_ip' => $row['qty_inner_part'] ?? 0,
                ]);
    
                $outerPart = OuterPart::create([
                    'size_op' => $row['size_outer_part'] ?? 'N/A',
                    'logo_op' => $row['logo_outer_part'] ?? 'N/A',
                    'label_op' => $row['label_outer_part'] ?? 'N/A',
                    'Qty_op' => $row['qty_outer_part'] ?? 0,
                ]);
    
                $part = Part::create([
                    'P_No' => $row['part_no'],
                    'P_Name' => $row['part_name'],
                    'cust_part_no' => $row['cust_part_number'],
                    'inner_id' => $innerPart->id,
                    'outer_id' => $outerPart->id,
                ]);
    
                $this->successfulRows[] = $part;
            }
    
            DB::commit(); // Commit jika semua proses berhasil
    
            return $existingPart ?? $part;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada kesalahan
    
            $this->errorRows[] = [
                'row' => $row,
                'errors' => ['Error saving data: ' . $e->getMessage()],
            ];
    
            return null;
        }
    }
    

    public function getErrorRows()
    {
        return $this->errorRows;
    }

    public function getSuccessfulRows()
    {
        return $this->successfulRows;
    }
}
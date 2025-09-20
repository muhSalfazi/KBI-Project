<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PartsImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Part;
use App\Models\InnerPart;
use App\Models\OuterPart;

use Illuminate\Validation\Rule;

class PartController extends Controller
{
    // Display the list of parts
    public function index(Request $request)
    {
        $status = $request->get('status', null); // Ambil status dari query string
        $query = Part::with(['customer', 'innerPart', 'outerPart'])->orderBy('P_Name', 'asc');

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        $parts = $query->get();

        return view('Part.index', compact('parts'));
    }

    // Show the form for creating a new part
    public function create()
    {
        return view('Part.created');
    }

    // Show form to edit an existing part
    public function updateshow(Request $request, $id)
    {
        // Temukan part dengan relasi yang relevan
        $part = Part::with(['innerPart', 'outerPart'])->findOrFail($id);

        // Pisahkan ukuran menjadi panjang, lebar, dan tinggi
        $part = $this->processSizes($part);

        return view('Part.edit', compact('part'));
    }

    /**
     * Fungsi utilitas untuk memproses ukuran menjadi panjang, lebar, dan tinggi.
     */
    private function processSizes($part)
    {
        // Proses ukuran utama (dari tabel parts)
        if ($part->size) {
            $sizeParts = array_map('trim', explode('x', str_replace('mm', '', $part->size)));
            $part->size_length = $sizeParts[0] ?? null;
            $part->size_width = $sizeParts[1] ?? null;
            $part->size_height = $sizeParts[2] ?? null;
        }

        // Proses ukuran inner package (dari tabel innerPart)
        if ($part->innerPart && $part->innerPart->size_ip) {
            $sizeIpParts = array_map('trim', explode('x', str_replace('mm', '', $part->innerPart->size_ip)));
            $part->size_ip_length = $sizeIpParts[0] ?? null;
            $part->size_ip_width = $sizeIpParts[1] ?? null;
            $part->size_ip_height = $sizeIpParts[2] ?? null;
        }

        // Proses ukuran outer package (dari tabel outerPart)
        if ($part->outerPart && $part->outerPart->size_op) {
            $sizeOpParts = array_map('trim', explode('x', str_replace('mm', '', $part->outerPart->size_op)));
            $part->size_op_length = $sizeOpParts[0] ?? null;
            $part->size_op_width = $sizeOpParts[1] ?? null;
            $part->size_op_height = $sizeOpParts[2] ?? null;
        }

        return $part;
    }
    // Store a new part in the database
    public function store(Request $request)
{
    // Validasi untuk field wajib
    $validator = Validator::make($request->all(), [
        'P_Name' => 'required|string|max:50',
        'P_No' => 'required|string|max:50',
        'cust_part_no' => 'required|string|unique:tbl_parts,cust_part_no|max:50',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    DB::beginTransaction();

    try {
        // Simpan data inner part (gunakan default jika tidak diisi)
        $innerPart = InnerPart::create([
            'size_ip' => $request->filled(['size_ip_length', 'size_ip_width', 'size_ip_height'])
                ? "{$request->size_ip_length}x{$request->size_ip_width}x{$request->size_ip_height}"
                : 'N/A',
            'type_ip' => $request->type_ip ?? 'pcs',
            'Qty_ip' => $request->Qty_ip ?? 1,
            'logo_ip' => $request->logo_ip ?? 'N/A',
            'label_ip' => $request->label_ip ?? 'N/A',
        ]);

        // Simpan data outer part (gunakan default jika tidak diisi)
        $outerPart = OuterPart::create([
            'size_op' => $request->filled(['size_op_length', 'size_op_width', 'size_op_height'])
                ? "{$request->size_op_length}x{$request->size_op_width}x{$request->size_op_height}"
                : 'N/A',
            'type_op' => $request->type_op ?? 'pcs',
            'Qty_op' => $request->Qty_op ?? 1,
            'logo_op' => $request->logo_op ?? 'N/A',
            'label_op' => $request->label_op ?? 'N/A',
        ]);

        // Simpan data part utama
        $part = Part::create([
            'P_Name' => $request->P_Name,
            'P_No' => $request->P_No,
            'cust_part_no' => $request->cust_part_no,
            'size' => $request->filled(['size_length', 'size_width', 'size_height'])
                ? "{$request->size_length}x{$request->size_width}x{$request->size_height}"
                : null,
            'inner_id' => $innerPart->id,
            'outer_id' => $outerPart->id,
        ]);

        DB::commit();

        return redirect()->route('parts.index')->with('success', 'Part berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal menyimpan part: ' . $e->getMessage());
    }
}

    
    public function update(Request $request, $id)
    {
        $part = Part::with('innerPart', 'outerPart')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'P_Name' => 'sometimes|string|max:50',
            'P_No' => 'sometimes|string|max:50',
            'cust_part_no' => 'nullable|string|unique:tbl_parts,cust_part_no,' . $part->id . '|max:50',
            'size_length' => 'nullable|string',
            'size_width' => 'nullable|string',
            'size_height' => 'nullable|string',
            'size_ip_length' => 'nullable|string',
            'size_ip_width' => 'nullable|string',
            'size_ip_height' => 'nullable|string',
            'type_ip' => 'nullable|in:pcs,pack',
            'Qty_ip' => 'nullable|integer',
            'size_op_length' => 'nullable|string',
            'size_op_width' => 'nullable|string',
            'size_op_height' => 'nullable|string',
            'type_op' => 'nullable|in:pcs,pack,box',
            'Qty_op' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $part->update([
                'P_Name' => $request->P_Name ?? $part->P_Name,
                'P_No' => $request->P_No ?? $part->P_No,
                'cust_part_no' => $request->cust_part_no ?? $part->cust_part_no,
                'size' => "{$request->size_length}x{$request->size_width}x{$request->size_height}",
            ]);

            if ($part->innerPart) {
                $part->innerPart->update([
                    'size_ip' => "{$request->size_ip_length}x{$request->size_ip_width}x{$request->size_ip_height}",
                    'type_ip' => $request->type_ip,
                    'Qty_ip' => $request->Qty_ip,
                    'logo_ip' => $request->logo_ip,
                    'label_ip' => $request->label_ip,
                ]);
            } else {
                return redirect()->back()->with('error', 'InnerPart tidak ditemukan.');
            }

            if ($part->outerPart) {
                $part->outerPart->update([
                    'size_op' => "{$request->size_op_length}x{$request->size_op_width}x{$request->size_op_height}",
                    'type_op' => $request->type_op,
                    'Qty_op' => $request->Qty_op,
                    'logo_op' => $request->logo_op,
                    'label_op' => $request->label_op,
                ]);
            } else {
                return redirect()->back()->with('error', 'OuterPart tidak ditemukan.');
            }



            DB::commit();
            return redirect()->route('parts.index')->with('success', 'Part berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui part: ' . $e->getMessage());
        }
    }

    // public function destroy($id)
    // {
    //     $part = Part::with(['innerPart', 'outerPart'])->findOrFail($id); // Temukan Part dengan relasi terkait

    //     DB::beginTransaction(); // Mulai transaksi
    //     try {
    //         // Hapus file gambar utama Part jika ada
    //         if ($part->img_p && file_exists(public_path($part->img_p))) {
    //             unlink(public_path($part->img_p));
    //         }

    //         // Hapus file gambar label Part jika ada
    //         if ($part->lbl_img && file_exists(public_path($part->lbl_img))) {
    //             unlink(public_path($part->lbl_img));
    //         }
    //         if ($part->lbl_img && file_exists(public_path($part->pos_label))) {
    //             unlink(public_path($part->pos_label));
    //         }

    //         // Hapus file gambar InnerPart jika ada
    //         if ($part->innerPart) {
    //             if ($part->innerPart->Image_ip && file_exists(public_path($part->innerPart->Image_ip))) {
    //                 unlink(public_path($part->innerPart->Image_ip));
    //             }
    //             $part->innerPart->delete(); // Hapus InnerPart
    //         }

    //         // Hapus file gambar OuterPart jika ada
    //         if ($part->outerPart) {
    //             if ($part->outerPart->Image_op && file_exists(public_path($part->outerPart->Image_op))) {
    //                 unlink(public_path($part->outerPart->Image_op));
    //             }
    //             $part->outerPart->delete(); // Hapus OuterPart
    //         }

    //         // Hapus Part utama
    //         $part->delete();

    //         DB::commit(); // Selesaikan transaksi
    //         return redirect()->route('parts.index')->with('success', 'Part berhasil dihapus!');
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Batalkan transaksi jika terjadi error
    //         return redirect()->back()->with('error', 'Gagal menghapus part: ' . $e->getMessage());
    //     }
    // }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new PartsImport();
        Excel::import($import, $request->file('file'));

        $errorRows = $import->getErrorRows();
        $successfulRows = $import->getSuccessfulRows();

        $messages = [];
        if (count($successfulRows) > 0) {
            $messages[] = count($successfulRows) . ' parts berhasil diimpor.';
        }

        if (count($errorRows) > 0) {
            $messages[] = count($errorRows) . ' baris gagal diimpor.';
        }

        return redirect()->route('parts.index')->with('success', implode(' | ', $messages));
    }
    // edit gambar 
    public function updateImages(Request $request, $id)
    {
        $request->validate([
            'img_p' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lbl_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pos_label' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Image_ip' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Image_op' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $part = Part::with(['innerPart', 'outerPart'])->findOrFail($id);
    
        $fieldsToUpdatePart = [];
        $fieldsToUpdateInner = [];
        $fieldsToUpdateOuter = [];
    
        DB::beginTransaction();
        try {
            // Handle Part Images
            if ($request->hasFile('img_p')) {
                if ($part->img_p && file_exists(public_path($part->img_p))) {
                    unlink(public_path($part->img_p));
                }
    
                $filename = $part->P_No . '-img_p.' . $request->file('img_p')->getClientOriginalExtension();
                $request->file('img_p')->move(public_path('parts'), $filename);
                $fieldsToUpdatePart['img_p'] = 'parts/' . $filename;
            }
    
            if ($request->hasFile('lbl_img')) {
                if ($part->lbl_img && file_exists(public_path($part->lbl_img))) {
                    unlink(public_path($part->lbl_img));
                }
    
                $filename = $part->P_No . '-lbl_img.' . $request->file('lbl_img')->getClientOriginalExtension();
                $request->file('lbl_img')->move(public_path('parts'), $filename);
                $fieldsToUpdatePart['lbl_img'] = 'parts/' . $filename;
            }
    
            if ($request->hasFile('pos_label')) {
                if ($part->pos_label && file_exists(public_path($part->pos_label))) {
                    unlink(public_path($part->pos_label));
                }
    
                $filename = $part->P_No . '-pos_label.' . $request->file('pos_label')->getClientOriginalExtension();
                $request->file('pos_label')->move(public_path('parts'), $filename);
                $fieldsToUpdatePart['pos_label'] = 'parts/' . $filename;
            }
    
            // Handle Inner Package Images
            if ($request->hasFile('Image_ip') && $part->innerPart) {
                if ($part->innerPart->Image_ip && file_exists(public_path($part->innerPart->Image_ip))) {
                    unlink(public_path($part->innerPart->Image_ip));
                }
    
                $filename = $part->P_No . '-Image_ip.' . $request->file('Image_ip')->getClientOriginalExtension();
                $request->file('Image_ip')->move(public_path('parts'), $filename);
                $fieldsToUpdateInner['Image_ip'] = 'parts/' . $filename;
            }
    
            // Handle Outer Package Images
            if ($request->hasFile('Image_op') && $part->outerPart) {
                if ($part->outerPart->Image_op && file_exists(public_path($part->outerPart->Image_op))) {
                    unlink(public_path($part->outerPart->Image_op));
                }
    
                $filename = $part->P_No . '-Image_op.' . $request->file('Image_op')->getClientOriginalExtension();
                $request->file('Image_op')->move(public_path('parts'), $filename);
                $fieldsToUpdateOuter['Image_op'] = 'parts/' . $filename;
            }
    
            // Update Part
            if (!empty($fieldsToUpdatePart)) {
                $part->update($fieldsToUpdatePart);
            }
    
            // Update Inner Part
            if (!empty($fieldsToUpdateInner)) {
                $part->innerPart->update($fieldsToUpdateInner);
            }
    
            // Update Outer Part
            if (!empty($fieldsToUpdateOuter)) {
                $part->outerPart->update($fieldsToUpdateOuter);
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'Gambar berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui gambar: ' . $e->getMessage());
        }
    }
    
    // ubah status part
    public function changeStatus(Request $request, $id)
    {
        $part = Part::findOrFail($id);

        DB::beginTransaction();
        try {
            $part->update(['status' => $request->status]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Status berhasil diubah.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal mengubah status: ' . $e->getMessage()]);
        }
    }
}
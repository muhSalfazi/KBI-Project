<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class ImportControler extends Controller
{
    public function index() {
        return view('import.HPM');
    }

    public function importExcel(Request $request){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('excel_file');

        try{
            Excel::import(new UsersImport('hpm'), $file);
            return redirect()->back()->with('success', 'Data berhasil diimport ke tabel HPM!');
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengimpor file: ' . $e->getMessage());
        }

    }

    public function indexADM(){
        return view('import.adm');
    }

    public function importADM(Request $request){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('excel_file');

        try{
            Excel::import(new UsersImport('adm'), $file);
            return redirect()->back()->with('success', 'Data berhasil diimport ke tabel ADM!');
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengimpor file: ' . $e->getMessage());
        }
    }
}

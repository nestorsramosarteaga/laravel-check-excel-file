<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function showForm()
    {
        return view('upload.form');
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv'
        ]);

        $import = new ExcelImport();
        Excel::import($import, $request->file('excel_file'));

        if (!empty($import->errors)) {
            //dd($import->errors);
            return back()->withErrors(['errors' => collect($import->errors)->flatten()->toArray()]);
        }

        // Si no hay errores, guardar el archivo en storage
        $path = $request->file('file')->store('files/checked');

        return response()->json([
            'success' => true,
            'message' => 'File uploaded and validated successfully.',
            'path' => $path
        ]);
    }

}

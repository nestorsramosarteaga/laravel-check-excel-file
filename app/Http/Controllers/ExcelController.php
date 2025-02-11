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
            return back()->withErrors(['errors' => collect($import->errors)->flatten()->toArray()]);
        }

        // If there are no errors, store the file in storage
        $path = $request->file('excel_file')->store('files/checked');

        return redirect()->back()->with('success', 'File uploaded and validated successfully.');
    }

}

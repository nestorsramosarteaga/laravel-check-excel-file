<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ExcelImport implements ToCollection, WithHeadingRow
{
    public array $errors = [];

    private array $expectedHeaders = ['id', 'first_name', 'last_name', 'email', 'phone'];

    public function collection(Collection $rows)
    {
        // Verificar si las cabeceras son correctas
        if (!$this->validateHeaders($rows)) {
            return;
        }

        // Validar cada fila
        foreach ($rows as $index => $row) {
            $validator = Validator::make($row->toArray(), [
                'id' => 'required|integer',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|digits_between:7,15'
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $column => $messages) {
                    foreach ($messages as $message) {
                        $this->errors[] = [
                            'error' => $message . ' Row ' . ($index + 2)
                        ];
                    }
                }
            }
        }
    }

    private function validateHeaders(Collection $rows): bool
    {
        if ($rows->isEmpty()) {
            $this->errors[] = ['error' => 'The file is empty.'];
            return false;
        }

        $fileHeaders = array_keys($rows->first()->toArray());
        
        if ($fileHeaders !== $this->expectedHeaders) {
            $this->errors[] = ['error' => 'Invalid headers. Expected: ' . implode(', ', $this->expectedHeaders)];
            return false;
        }

        return true;
    }
}
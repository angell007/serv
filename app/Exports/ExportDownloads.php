<?php

namespace App\Exports;

use App\Company;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDownloads implements FromCollection, WithHeadings
{
    // protected $data;

    public function __construct()
    {
    }

    public function collection()
    {
        if (request()->get('model') == 'users')
            return DB::table('participants')
                ->select('name', 'phone', 'email', 'identifier', 'semester', 'status')
                ->where('trainings_id', request()->get('id'))->get();

        return DB::table('participants')
            ->select('name', 'phone', 'email', 'identifier', 'cargo', 'status')

            ->where('trainings_id', request()->get('id'))->get();
    }

    public function headings(): array
    {
        if (request()->get('model') == 'users')
            return [
                'Nombre',
                'Contacto',
                'Email',
                'Documento',
                'Semestre',
                'Estado'
            ];
        return [
            'Nombre',
            'Contacto',
            'Email',
            'Documento',
            'Cargo',
            'Estado'
        ];
    }
}

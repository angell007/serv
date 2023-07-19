<?php

namespace App\Http\Controllers;

use App\Exports\ExportDownloads;
use Maatwebsite\Excel\Facades\Excel;

class DownloadsController extends Controller
{
    public function download_capacitaciones()
    {
        if (request()->get('model') == 'users')
            return Excel::download(new ExportDownloads(), 'capacitaciones_usuarios.xlsx');
        return Excel::download(new ExportDownloads(), 'capacitaciones_companies.xlsx');
    }
}

<?php





namespace App\Exports;





use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\AfterSheet;



class JobsExport implements FromView, WithEvents, ShouldAutoSize

{

    protected $data;

    public function __construct($data)

    {

        $this->data = $data;
    }



    public function view(): View

    {



        return view('export.jobs', ['data' => $this->data]);
    }



    public function registerEvents(): array

    {

        return [

            AfterSheet::class    => function (AfterSheet $event) {

                $cellRange = 'A1:W1'; // All headers

                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },

        ];
    }
}

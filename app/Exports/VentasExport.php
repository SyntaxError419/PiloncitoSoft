<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class VentasExport implements FromView
{

    public function view(): View
    {
        return view('venta.reporte', [
            'ventas' => Venta::where('pago', '=',1)->where('cancelado', '=',0)->get()
        ], ['totalventas' => Venta::SUM('total')->where('pago', '=',1)->where('cancelado', '=',0)->get()->sum("total")]);
    }
}
class InvoicesExport implements WithStyles
{
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('B2')->getFont()->setBold(true);
    }
}

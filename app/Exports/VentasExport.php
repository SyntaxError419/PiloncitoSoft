<?php

namespace App\Exports;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Detalleventa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VentasExport implements FromView
{

    public function view(): View
    {
        $date = Carbon::now();
        $date = $date->subMonth(); 
        $date = $date->format('Y-m-d');

        $ventas = Venta::where('pago', '=',1)
        ->where('cancelado', '=',0)
        ->where('fecha', '>',$date)
        ->get();

        $totalventas = Venta::SUM('total')
        ->where('pago', '=',1)
        ->where('cancelado', '=',0)
        ->where('fecha', '>',$date)
        ->get()
        ->sum("total");

        $proMasVenNu = DB::table('ventas as v')
        ->join('detalleventas as dv', 'v.id' ,'=', 'dv.id_venta')
        ->join('productos as p', 'p.id' ,'=', 'dv.id_producto')
        ->select(DB::raw('sum(dv.id_producto) as coun', 'p.nombre'))
        ->where('v.cancelado',0)->groupBy('dv.id_producto', 'p.nombre')
        ->get();

        $proMasVenNo = DB::table('ventas as v')
        ->join('detalleventas as dv', 'v.id' ,'=', 'dv.id_venta')
        ->join('productos as p', 'p.id' ,'=', 'dv.id_producto')
        ->selectRaw('p.nombre, sum(dv.cantidad) as coun')
        ->where('v.cancelado',0)
        ->groupBy('dv.id_producto', 'p.nombre')
        ->get();
        
        $proMasVenNuU = array_column($proMasVenNu->toArray(), 'coun');
        $proMasVenNoO = array_column($proMasVenNo->toArray(), 'nombre');
        return view('venta.reporte', compact('ventas', 'totalventas', 'proMasVenNuU', 'proMasVenNoO'))
        ->with('ventas', $ventas, 'totalventas', $totalventas, 'proMasVenNuU', $proMasVenNuU, 'proMasVenNoO', $proMasVenNoO);
    }
}
class InvoicesExport implements WithStyles
{
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('B2')->getFont()->setBold(true);
    }
}

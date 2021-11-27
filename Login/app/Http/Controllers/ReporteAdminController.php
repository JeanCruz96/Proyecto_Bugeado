<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Egresado;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
namespace Barryvdh\DomPDF;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\App;
use App\Models\Egresado;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class ReporteAdminController extends Controller
{
    //
    public function showReporteView( Request $request )
    {


        $pdf = App::make( 'dompdf.wrapper' );
        $pdf->loadHTML( $this->get_data_to_html());

        return $pdf->stream();
    }
    function get_data_to_html()
    {
        $egresados = Egresado::all()
            ->where( 'habilitado','=', 1 )
            ->orderBy( 'ap_paterno', 'DESC' )
            ->get();

        $output = '<style>
                    table{
                        width: 97%;
                        border-collapse: collapse;
                        border: #ACABAB 1px solid;
                        font-size: 13px;
                        margin: auto;
                        }
                        table thead {
                            color: white;
                            background-color: #6B6B6B;
                        }
                        tr, td {
                        height: 48px;
                        border: #ACABAB 1px solid;
                        text-align:center;
                        }
                        tr:nth-child(even){
                        color: #6B6B6B;
                        background-color: #D8D8D8;
                        }
                        tbody tr:nth-child(odd){
                        color: #6B6B6B;
                        background-color: #FFFFFF;
                        }
                </style>
        <h3 align = "center">Reporte egresados</h3>
        <table>
            <thead>
				<tr>
                    <td width="50px">Número</td>
                    <td width = "100px">Matricula</td>
                    <td>Nombre</td>
                </tr>
			</thead>';

        $output.='<tbody>';

        $i = 1;
        foreach( $egresados as $egresado )
        {
            $output.='
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$egresado->matricula.'</td>
                    <td>'.$egresado->nombres.' '.$egresado->ap_paterno.' '.$egresado->ap_materno.'</td>
                </tr>';
            ++$i;
        }
        $output.='</tbody>';

        return $output;
    }
}

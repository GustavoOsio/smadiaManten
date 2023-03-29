@extends('pdf.layout')
@section('title', 'EGRESO')
@section('content')
    <style>
        p{
            margin: 0% !important;
        }
        .mtp{
            margin-top: 35px !important;
            font-size: 9pt !important;
        }
        .description{
            font-size: 10pt !important;
            padding: 0rem 0rem !important;
            margin-top: 0.2% !important;
        }
        .logo .img {
           
            width: 250px;
            height: 40px;
            background-size: contain;
            
            margin-top: 25px;
        }
        table {
            margin: .2rem 0 1rem !important;
        }
        table th {
            padding: .0rem .7rem !important;
        }
        table td {
            padding: .1rem .7rem !important;
        }
        .height_long{
            height: 20px;
        }
        .height_long_2{
            height: 50px;
        }
        .table_1{
            padding: 0% !important;
            margin: 0% !important;
        }
        .fz13{
             margin: 0.5% !important;
             font-size: 13pt;
         }
        .observations{
            margin: 0% !important;
            padding: 0% !important;
            font-size: 10pt !important;
        }
    </style>
    
<img src="https://smadiasoft.com/img/logo-smadia-02.png" style="margin-top: 25px !important;" />
    <h3 class="fz13 mtp" style="font-size:13pt !important;">Egreso #{{$data->id}}</h3>
    <p class="fz9">Fecha: {{ date("Y-m-d h:i a", strtotime($data->created_at)) }}</p>
    <table class="table_1">
        <tr>
            <td>
                <p class="fz11"><strong>Realizado por: </strong>{{ ucwords(mb_strtolower($data->users->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->users->lastname, "UTF-8")) }}</p>
            </td>
            <td>
                <p class="fz10"><strong>Centro de Costo: </strong>
                    @if(!empty($data->center->name))
                        {{$data->center->name}}
                    @endif
                </p>
            </td>
        </tr>
    </table>
    <!--
    <div class="height_long">

    </div>
    -->
    <div class="description fz10"><strong>Información de egreso</strong></div>
    <table>
        <tr>
            <th>Provedor.</th>
            <th>NIT Provedor</th>
            <th>Valor Egreso.</th>
            <th>Total Desc.</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>
                {{$data->provider->company}}
            </td>
            <td>
                {{$data->provider->nit}}
            </td>
            <td>
                ${{number_format($data->value, 0,',','.')}}
            </td>
            <td>
                $ {{number_format($data->desc_total, 0)}}
            </td>
            <td>
                $ {{number_format($data->total_expense, 0,',','.')}}
            </td>
        </tr>
    </table>
    <p class="fz10 observations"><strong>Observaciones: </strong>{{ ($data->observations != "") ? $data->observations : "Ninguna" }}</p>
    <div class="height_long_2">

    </div>
    <p class="w250 fz11 btg left lh22">
        Firma de recibido
        <br>C.C / NIT
    </p>
    <p class="w250 fz11 btg right lh22">
        Autorizado por
    </p>
    <!--
    <table>
        <tr>
            <td>
                <p class="fz11"><strong>Provedor: </strong> <br>{{$data->provider->company}}</p>
            </td>
            <td>
                <p class="fz11"><strong>NIT Provedor: </strong> <br> {{$data->provider->nit}}</p>
            </td>
            <td>
                <p class="fz11"><strong>Dirreccion Provedor: </strong> <br> {{$data->provider->address}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="fz11"><strong>Teléfono Provedor:</strong> <br> {{ $data->provider->phone }}</p>
            </td>
            <td>
                <p class="fz11"><strong>Ciudad Provedor: </strong> <br>{{$data->provider->city->name}}</p>
            </td>
            <td>
                <p class="fz11"><strong>Valor Egreso: </strong> <br> ${{number_format($data->value, 2)}}</p>
            </td>
            <td>
                <p class="fz11"><strong>Total Descuento: </strong> <br> {{number_format($data->desc_total, 2)}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="fz11"><strong>IVA Valor:</strong> <br> ${{ number_format($data->iva, 2) }}</p>
            </td>
            <td>
                <p class="fz11"><strong>Porcentaje de IVA: </strong> <br>{{ $data->porcent_iva }}</p>
            </td>
            <td>
                <p class="fz11"><strong>Centro de Costo: </strong> <br>
                    @if(!empty($data->center->name))
                        {{$data->center->name}}
                    @endif
                </p>
            </td>
            <td>
                <p class="fz11"><strong>Total de Egreso: </strong> <br> ${{number_format($data->total_expense, 2)}}</p>
            </td>
        </tr>
    </table>
    <div class="line-form"></div>
    <table>
        <tr>
            <td>
                <p class="fz11">
                    <strong>Aplica Factura:</strong> <br>
                    {{ $data->apli_fact  }}
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Factura:</strong> <br>
                    @if(!empty($data->purchase->comment))
                        {{$data->purchase->comment}}
                    @endif
                </p>
            </td>
        </tr>
    </table>
    <div class="line-form"></div>
    <table>
        <tr>
            <td>
                <p class="fz11">
                    <strong>Forma de Pago:</strong> <br>
                    {{$data->form_pay}}
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Desc. por Pronto Pago:</strong> <br>
                    {{$data->desc_pront_pay}}
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Tipo de Desc:</strong> <br>
                    @if($data->desc_pront_pay == 'si')
                        {{$data->desc_type}}
                    @else
                        No seleccionada
                    @endif
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Valor de Desc:</strong> <br>
                    @if($data->desc_pront_pay == 'si')
                        @if($data->desc_type == '%')
                            {{$data->desc_value}}
                        @else
                            $ {{ number_format($data->desc_value, 2)  }}
                        @endif
                    @else
                        No seleccionada
                    @endif
                </p>
            </td>
        </tr>
    </table>
    <div class="line-form"></div>
    <table>
        <tr>
            <td>
                <p class="fz11">
                    <strong>Rte. Aplica:</strong> <br>
                    {{$data->rte_aplica}}
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Retencion:</strong> <br>
                    @if($data->rte_aplica == 'si')
                        {{$data->retention->name}}
                    @else
                        No seleccionada
                    @endif
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>A Retener:</strong> <br>
                    @if($data->rte_aplica == 'si')
                        $ {{ number_format($data->rte_value, 2)  }}
                    @else
                        No seleccionada
                    @endif
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Rte. Base:</strong> <br>
                    @if($data->rte_aplica == 'si')
                        {{$data->rte_base}}
                    @else
                        No seleccionada
                    @endif
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Rte. Porcentaje:</strong> <br>
                    @if($data->rte_aplica == 'si')
                        {{$data->rte_porcent}}
                    @else
                        No seleccionada
                    @endif
                </p>
            </td>
        </tr>
    </table>
    <div class="line-form"></div>
    <table>
        <tr>
            <td>
                <p class="fz11">
                    <strong>Rte. Iva:</strong> <br>
                    {{$data->rte_iva}}
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Rte. Iva Porcentaje:</strong> <br>
                    @if($data->rte_iva == 'si')
                        {{$data->rte_iva_porcent}}
                    @else
                        0
                    @endif
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Rte. Iva Valor:</strong> <br>
                    @if($data->rte_iva == 'si')
                        $ {{ number_format($data->rte_iva_value, 2)  }}
                    @else
                        $0
                    @endif
                </p>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div class="line-form"></div>
    <table>
        <tr>
            <td>
                <p class="fz11">
                    <strong>Rte. Ica:</strong> <br>
                    {{$data->rte_ica}}
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Rte. Ica Porcentaje:</strong> <br>
                    @if($data->rte_ica == 'si')
                        {{$data->rte_ica_porcent}}
                    @else
                        0
                    @endif
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Rte. Ica Valor:</strong> <br>
                    @if($data->rte_ica == 'si')
                        $ {{ number_format($data->rte_ica_value, 2)  }}
                    @else
                        $0
                    @endif
                </p>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div class="line-form"></div>
    <table>
        <tr>
            <td>
                <p class="fz11">
                    <strong>Rte. Cree:</strong> <br>
                    {{$data->rte_cree}}
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Rte. Cree Porcentaje:</strong> <br>
                    @if($data->rte_cree == 'si')
                        {{$data->rte_cree_porcent}}
                    @else
                        0
                    @endif
                </p>
            </td>
            <td>
                <p class="fz11">
                    <strong>Rte. Cree Valor:</strong> <br>
                    @if($data->rte_cree == 'si')
                        $ {{ number_format($data->rte_cree_value, 2)  }}
                    @else
                        $0
                    @endif
                </p>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div class="line-form"></div>
    <br>
    <p class="fz11">
        <strong>Observaciones:</strong> <br>
        {{$data->observations}}
    </p>
    -->
@endsection

<style>
    .line-form{
        width: 100%;
        margin: 0% !important;
        border: 1px solid #E1E3E1;
    }
    table{
        margin: 0% !important;
    }
    table td{
        padding: 0% !important;
    }
    .content{
        padding: 0% 3.2rem !important;
    }
</style>

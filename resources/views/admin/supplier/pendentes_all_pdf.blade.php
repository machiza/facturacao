@php
    ini_set('max_execution_time', 300);
    ini_set("memory_limit","512M");
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>{{ trans('message.invoice_pdf.cust_report') }}</title>
    </head>

    <style>

        body{ font-family: 'monospace', sans-serif; color:#121212; line-height:22px; }
        table,tr,td{ border-bottom: 1px solid #000000;padding: 3px 0px; }
        tr{ height:10px; }
        .footer1 { position: absolute; bottom: 1px; width: 100%; height: 100px; }
        .footer { position: absolute; bottom: 1px; width: 100%; height: 120px; }
        .tablefooter{
            table { border-collapse: collapse; width: 100%; }
            th,td { padding: 2px; text-align: left; border-bottom: 1px solid #ddd; }
        }

    </style>

    <body>

        <img src="{{asset('img/logo.png')}}" width="160">
        <div style="width:300px; float:right; margin-top:10px;height:40px;">
            <div style="font-size:20px; font-weight:bold; color:#383838;">{{ trans('message.invoice_pdf.supp_invoice') }}</div>
        </div>
        <div>

            <br>
            <br>

            <table style="width:100%; border-radius:2px;">
                <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
                    <th style="padding-right:1px;text-align:justify; color: #000000">
                        Data
                    </th>
                    <th style="padding-right:1px;text-align:justify; color: #000000">
                        Documento
                    </th>
                    <th style="padding-right:1px;text-align:justify; color: #000000">
                        Preco Total
                    </th>
                    <th style="padding-right:1px;text-align:justify; color: #000000">
                        valor Pago 
                    </th>
                    <th style="padding-right:1px;text-align:justify; color: #000000">
                        Saldo
                    </th>
                </tr>
                @php
                    $total=0;
                    $saldo_doc = 0;
                    $i = 0;
                @endphp

                @foreach ($contas as $conta)
                    @php
                        $sub_total= 0;
                        $total += $saldo_doc;
                        $saldo_doc = 0;
                        $i = 0;
                    @endphp

                    @foreach($Pendentes as $dado)
                        @if ($dado->supp_name == $conta->supp_name)
                            @if ($saldo_doc == 0)
                                <tr style="background-color:#5d98de; text-align:center; font-size:13px; font-weight:normal;">
                                    <th style="padding-right:1px;text-align:justify; color: #000000">{{ $dado->supp_name }}</th>
                                    <th style="padding-right:1px;text-align:justify; color: #000000"></th>
                                    <th style="padding-right:1px;text-align:justify; color: #000000"></th>
                                    <th style="padding-right:1px;text-align:justify; color: #000000"></th>
                                    <th style="padding-right:1px;text-align:justify; color: #000000"></th>
                                </tr>
                            @endif

                            @php
                                $linha=explode('-',$dado->reference_doc);
                                
                                $pago = 0;

                                if ($dado->saldo_doc != null) {
                                    $pago = $dado->amount_doc - $dado->saldo_doc;
                                } 

                                $sub_total= $sub_total+$dado->saldo_doc;

                                $saldo_doc += $dado->amount_doc;
                                
                            @endphp
                            <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
                                <td style="padding-right:1px;text-align:justify; color: #000000">{{ $dado->ord_date_doc }}</td>
                                <td style="padding-right:1px;text-align:justify; color: #000000">{{ $dado->reference_doc }}</td>
                                <td style="padding-right:1px;text-align:right; color: #000000">{{ Session::get('currency_symbol').number_format($dado->amount_doc,2) }}</td>
                                <td style="padding-right:1px;text-align:right; color: #000000">{{ $pago }}</td>
                                <td style="padding-right:1px;text-align:right; color: #000000">{{ Session::get('currency_symbol').number_format($saldo_doc,2) }}</td>
                            </tr>

                        @endif
                    @endforeach

                    <tr>
                        <td style="padding-right:1px;text-align:center; color: #000000"></td>
                        <td style="padding-right:1px;text-align:center; color: #000000"></td>
                        <td style="padding-right:1px;text-align:center; color: #000000"></td>
                        <td style="padding-right:1px;text-align:right; color: #000000"><strong>Sub Total:</strong></td>
                        <td style="padding-right:1px;text-align:right; color: #000000"><strong>{{ Session::get('currency_symbol').number_format($saldo_doc,2) }}</strong></td>
                    </tr>

                @endforeach

                @php
                    $total += $saldo_doc;
                @endphp
                <tr>
                    <td style="padding-right:1px;text-align:center; color: #000000"></td>
                    <td style="padding-right:1px;text-align:center; color: #000000"></td>
                    <td style="padding-right:1px;text-align:center; color: #000000"></td>
                    <td style="padding-right:1px;text-align:right; color: #000000"><strong>Total:</strong></td>
                    <td style="padding-right:1px;text-align:right; color: #000000"><strong>{{ Session::get('currency_symbol').number_format($total,2) }}</strong></td>
                </tr>

            </table>

        </div>

    </body>

</html>
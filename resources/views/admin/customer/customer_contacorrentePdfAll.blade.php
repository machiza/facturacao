<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>{{ trans('message.extra_text.current_account') }}</title>
</head>

    
     <style>

         body{ font-family: 'monospace', sans-serif; color:#121212; line-height:22px;}
         table, tr, td{
            border-bottom: 1px solid #000000;
            padding: 3px 0px;
        }
        tr{ height:10px;}


 .footer1 {
            position: absolute;
            bottom: 1px;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 100px;
            /*background-color: #f5f5f5*/;
          }

.footer {
            position: absolute;
            bottom: 1px;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 120px;
            /*background-color: #f5f5f5*/;
          }

 .tablefooter{
     table {
            border-collapse: collapse;
            width: 100%;
            }

      th, td {
          padding: 2px;
          text-align: left;
          border-bottom: 1px solid #ddd;
    }
  }
 

 
</style>
    
        
<body>
    <img src="{{asset('img/logo.png')}}" width="160">

    <div style="width:330px; float:right; margin-top:10px;height:40px;">
        <div style="font-size:20px; font-weight:bold; color:#383838;">
            Extracto dos Clientes
        </div>
    </div>
<div>
      
       <br>
       <br>


   

    <table style="width:100%; border-radius:2px;  ">
       
        <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
        <th>{{ trans('message.accounting.data') }}</th>
        <th>{{ trans('message.accounting.docs') }}</th>
        <th>{{ trans('message.accounting.debits') }}</th>
        <th>{{ trans('message.accounting.credits') }}</th>
        <th>{{ trans('message.table.balance_amount') }}</th>
        </tr>
        @php
            $total_saldo = 0;
            $total_debito = 0;
            $total_credito = 0;
        @endphp
        @foreach ($clientes as $cliente)
            @php
            $saldo = 0;
            $DebitoTotal = 0;
            $CreditoTotal = 0;
            @endphp
            <tr>
                <td style="background-color: #5d98de;">{{ $cliente->name }}</td>
                <td style="background-color: #5d98de;"></td>
                <!--amount doc-->
                <td style="background-color: #5d98de;"></td>
                <!--credito-->
                <td style="background-color: #5d98de;"></td>
                <td style="background-color: #5d98de;"></td>
            </tr> 
            @foreach($correntes as $dados)
                @if ($cliente->name == $dados->name)
                    @if ($dados->amount_doc != $dados->amount_credito_doc)
                        <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
                            <td>{{ formatDate($dados->ord_date_doc)}}</td>
                            <td style="padding-right:1px;text-align:justify; color: #000000">
                            {{ $dados->reference_doc }}
                            </td>
                            <td style="padding-right:1px;text-align:right; color: #000000">
                            {{-- @if($dados->debito_credito!=0 and $dados->amount_doc>0) --}}
                                @if($dados->amount_doc>0)
                                    @php
                                    $saldo = $saldo + $dados->amount_doc;
                                    $DebitoTotal = $DebitoTotal + $dados->amount_doc;  
                                    @endphp
                                    {{number_format($dados->amount_doc,2).''.Session::get('currency_symbol')}}
                                @endif
                            </td>
                            <td style="padding-right:1px;text-align:right; color: #000000">
                                @if($dados->amount_credito_doc !=0)
                                    @php
                                    $saldo=$saldo-$dados->amount_credito_doc;
                                    $CreditoTotal=$CreditoTotal+$dados->amount_credito_doc;
                                    @endphp
                                    {{number_format($dados->amount_credito_doc,2).' '.Session::get('currency_symbol')}}
                                @endif
                            </td>
                            <td style="text-align:right">{{ number_format($saldo,2).' '.Session::get('currency_symbol') }}</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
                <td></td>
                <td style="text-align:right"><strong>Sub Totais:</strong> </td>
                <td style="text-align:right"><strong>{{Session::get('currency_symbol').number_format($DebitoTotal,2)}}</strong></td>

                <td style="text-align:right">
                    <strong>
                        @if($CreditoTotal > 0)
                        {{Session::get('currency_symbol').number_format($CreditoTotal,2)}}
                        @else
                        {{$CreditoTotal}}
                        @endif
                    </strong>
                </td>

                <td style="text-align:right">
                    <strong>
                        {{Session::get('currency_symbol').number_format($saldo,2)}}
                    </strong>
                </td>
            </tr>
            @php
                $total_saldo += $saldo;
                $total_debito += $DebitoTotal;
                $total_credito += $CreditoTotal;
            @endphp
        @endforeach
        <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
            <td></td>
            <td style="text-align:right"><strong>Totais:</strong> </td>
            <td style="text-align:right"><strong>{{Session::get('currency_symbol').number_format($total_debito,2)}}</strong></td>

            <td style="text-align:right">
                <strong>
                    @if($total_credito > 0)
                        {{Session::get('currency_symbol').number_format($total_credito,2)}}
                    @else
                        {{$total_credito}}
                    @endif
                </strong>
            </td>

            <td style="text-align:right">
                <strong>
                    {{Session::get('currency_symbol').number_format($total_saldo,2)}}
                </strong>
            </td>
        </tr>
    </table> 
    </div>   
      
      
  <script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>
      
      
        <footer class="footer1">
      
         
 


      <table class="tablefooter">
          
          <tr style="background-color:#f0f0f0; border-bottom:2px solid #006DEF; text-align:center; font-size:12px; font-weight:bold;">
            <th style="border-bottom:1px solid #000000"></th>
         
          </tr>

          <tr style="font-size:10px;">
            <td></td>
       
          </tr>
          <tr style="font-size:10px">
            <td></td>
          
          </tr>
          
          
      </table>


       
        <div>
           <div style="width:400px; float:left; font-size:10px; color:#383838; font-weight:bold;">
          
                <div>Documento processado por Computador</div>
        
          </div>

        <div style="width:270px;font-weight:bold; float:right; font-size:10px; color:#383838;">
                   
           <div>Software N3 Licenciado a:{{ Session::get('company_name') }}</div>    
       
         </div>


        </div>    
         

    </footer>


</body>
</html>

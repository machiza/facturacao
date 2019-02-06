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
    <div style="width:300px; float:right; margin-top:10px;height:40px;">
      <div style="font-size:20px; font-weight:bold; color:#383838;">{{ trans('message.invoice_pdf.cust_report') }}</div>
    </div>
<div>
      
       <br>
       <br>

    
  
   <table style="width:100%; border-radius:2px;  ">
       
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
          <th style="padding-right:1px;text-align:justify; color: #000000">
            Data
          </th>
          {{-- <th style="padding-right:1px;text-align:justify; color: #000000">
          Nome do Cliente
          </th> --}}
          <th style="padding-right:1px;text-align:justify; color: #000000">
            Documento
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
            Data vencimento
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
            Dias vencidos
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
    @endphp
  @foreach ($contas as $conta)
    @php
      $sub_total = 0;
      $total += $saldo_doc;
      $saldo_doc = 0;
    @endphp
    @foreach($Pendentes as $data)
      @if ($data->name == $conta->name)
        @if ($saldo_doc == 0)
          <tr style="background-color:#5d98de; text-align:center; font-size:13px; font-weight:normal;">
            <th style="padding-right:1px;text-align:justify; color: #000000">{{ $data->name }}</th>
            <th style="padding-right:1px;text-align:justify; color: #000000"></th>
            <th style="padding-right:1px;text-align:justify; color: #000000"></th>
            <th style="padding-right:1px;text-align:justify; color: #000000"></th>
            <th style="padding-right:1px;text-align:justify; color: #000000"></th>
            <th style="padding-right:1px;text-align:justify; color: #000000"></th>
            <th style="padding-right:1px;text-align:justify; color: #000000"></th>
          </tr>
        @endif
        <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
          
            <td style="padding-right:1px;text-align:justify; color: #000000">
              {{ $data->ord_date_doc }}
            </td>
            @php
              $linha=explode('-',$data->reference_doc);
              $pago=$data->amount_doc-$data->saldo_doc;
              if ($linha[0]=='NC') {
                $saldo_doc -= $data->amount_credito_doc;
              } else {
                $saldo_doc += $data->saldo_doc;
              }

              $data_due = (date('Y-m-d', strtotime("+".$data->days_before_due."days", strtotime($data->ord_date_doc))));
              $data_h = date('y-m-d');

              $datetime1 = new DateTime($data_due);
              $datetime2 = new DateTime();
              $interval = $datetime1->diff($datetime2);
              $intervalo = (int)$interval->format('%R%a');
              if($intervalo > 0) {
                $intervalo = $interval->format('%a');
              } else {
                $intervalo = 0;
              }
            @endphp
            {{-- <td style="padding-right:1px;text-align:justify; color: #000000">
              {{ $data->name }}
            </td> --}}
            <td style="padding-right:1px;text-align:justify; color: #000000">
              {{ $data->reference_doc }}
            </td>
            <td style="padding-right:1px;text-align:justify; color: #000000">
              {{ $data_due }}
            </td>
            <td style="padding-right:1px;text-align:justify; color: #000000">
              {{ $intervalo }}
            </td>
            <td style="padding-right:1px;text-align:center; color: #000000">
                {{ Session::get('currency_symbol').number_format( $data->amount_doc,2) }}
            </td>
            <td style="padding-right:1px;text-align:right; color: #000000">
                {{ Session::get('currency_symbol').number_format($pago,2) }}
            </td>
            <td style="padding-right:1px;text-align:right; color: #000000">
                {{ Session::get('currency_symbol').number_format($saldo_doc,2) }}
            </td>
          
        </tr>
      @endif
    @endforeach
    <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
          
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      {{-- <td style="padding-right:1px;text-align:justify; color: #000000">
      </td> --}}
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        <strong>Sub Total:</strong>
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        <strong>{{Session::get('currency_symbol').number_format($saldo_doc,2)}}</strong>
      </td>
    
    </tr>
  @endforeach
    @php
      $total += $saldo_doc;
    @endphp
    <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
            
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      {{-- <td style="padding-right:1px;text-align:justify; color: #000000">
      </td> --}}
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        <strong>Total:</strong>
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        <strong>{{Session::get('currency_symbol').number_format($total,2)}}</strong>
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

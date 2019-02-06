<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>{{ trans('message.extra_text.purchases') }}</title>
    
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
  <div style="width:400px; float:right; margin-top:10px;height:40px;">
    <div style="font-size:20px; font-weight:bold; color:#383838;">
      <span>Compras</span>
      <span style="font-size:15px;">{{ formatDate($from) }} - {{ formatDate($to) }}</span>
    </div>
  </div>
<div>
      
       <br>
       <br>

    
  
   <table style="width:100%; border-radius:2px;  ">
       
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
        <th style="padding-right:1px;text-align:justify; color: #000000">
          {{ trans('message.table.date') }}
        </th>
        <th style="padding-right:1px;text-align:justify; color: #000000">
          {{ trans('message.table.invoice') }}
        </th>
          <th style="padding-right:1px;text-align:justify; color: #000000" width="12%">
          {{ trans('message.form.supplier') }}
        </th>
        <th style="padding-right:1px;text-align:justify; color: #000000">
          Nuit
        </th>
        <th style="padding-right:1px;text-align:center; color: #000000">
          {{ trans('message.invoice.total') }}
        </th>
        <th style="padding-right:1px;text-align:center; color: #000000">
          {{ trans('message.table.paid_amount') }}
        </th>
        <th style="padding-right:1px;text-align:center; color: #000000">
          {{ trans('message.table.balance_amount') }}
        </th>
        {{-- <th style="padding-right:1px;text-align:justify; color: #000000">
          {{ trans('message.form.status') }}
        </th> --}}
    </tr>
    @php
        $total = 0;
        $valor_pago = 0;
        $saldo = 0;
    @endphp
   @foreach($purchData as $data)
    <tr style="background-color:#fff;font-size:13px; font-weight:normal;">
      <td style="padding-right:1px;text-align:justify; color: #000000">
        {{ formatDate($data->ord_date)}}
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
        {{ $data->reference }}
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
        {{ $data->supp_name }}
      </td>
      <td style="padding-right:1px;text-align:justify; color: #000000">
        {{ $data->nuit }}
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        {{ Session::get('currency_symbol').number_format($data->total,2,'.',',') }}
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        {{ Session::get('currency_symbol').number_format($data->valor_pago,2,'.',',') }}
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        {{ Session::get('currency_symbol').number_format($data->total - $data->valor_pago,2,'.',',') }}
      </td>
      @php
          $total += $data->total;
          $valor_pago += $data->valor_pago; 
      @endphp
      {{-- <td style="padding-right:1px;text-align:justify; color: #000000">
        @if($data->valor_pago == 0)
            {{ trans('message.invoice.unpaid')}}
          @elseif($data->valor_pago > 0 && $data->total > $data->valor_pago )
            {{ trans('message.invoice.partially_paid')}}
          @elseif($data->valor_pago<=$data->valor_pago)
            {{ trans('message.invoice.paid')}}
        @endif

      </td> --}}
    </tr>
    @endforeach
    <tr style="background-color:#fff;font-size:13px; font-weight:normal;">
      <td style="padding-right:1px;text-align:justify; color: #000000"></td>
      <td style="padding-right:1px;text-align:justify; color: #000000"></td>
      <td style="padding-right:1px;text-align:justify; color: #000000"></td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        <strong>Total:</strong>
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        <strong>{{ Session::get('currency_symbol').number_format($total,2,'.',',') }}</strong>
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        <strong>{{ Session::get('currency_symbol').number_format($valor_pago,2,'.',',') }}</strong>
      </td>
      <td style="padding-right:1px;text-align:right; color: #000000">
        <strong>{{ Session::get('currency_symbol').number_format($total - $valor_pago,2,'.',',') }}</strong>
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

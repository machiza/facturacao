<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>{{ trans('message.invoice_pdf.credit_report') }}</title>
    
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
      <div style="font-size:20px; font-weight:bold; color:#383838;">{{ trans('message.invoice_pdf.credit_report') }}</div>
           
      </div>
<div>
      
       <br>
       <br>




   <table style="width:100%; border-radius:2px;  ">
       
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
          <th style="padding-right:1px;text-align:left; color: #000000">
            {{ trans('message.invoice.invoice_date_debit') }}
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
           {{ trans('message.table.invoice_debit_no') }}
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
           {{ trans('message.table.invoice_no') }}
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
           {{ trans('message.table.customer_name') }}
          </th>
          <th style="padding-right:1px;text-align:justify; color: #000000">
          {{ trans('message.table.amount') }}
          </th>
         <th style="padding-right:1px;text-align:justify; color: #000000">
           {{ trans('message.table.paid_status') }}
          </th>  
          
      </tr>


   @foreach($creditos as $data)
 
    <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
        <td>{{formatDate($data->credit_date)}}</td>
        <td style="padding-right:1px;text-align:justify; color: #000000">
         {{$data->reference_credit}}
        </td>
        <td style="padding-right:1px;text-align:justify; color: #000000">
         {{$data->reference}}
        </td>
         <td style="padding-right:1px;text-align:justify; color: #000000">
           {{$data->name}}
        </td>
        {{--@php
        $valorPorPagar=$data->debito;
        $saldo=$data->debito-$data->paid_amount_debit;
        @endphp--}}

        <td style="padding-right:1px;text-align:justify; color: #000000">
           {{$data->credito}}
        </td>
        
          @if($data->paid_amount == 0 and $data->status=='cancelado')
          <td><span class="label label-danger">{{ trans('message.invoice.anuled')}}</span>
          </td>
          @elseif($data->paid_amount == 0)
          <td><span class="label label-danger">{{ trans('message.invoice.unpaid')}}</span>
          </td>
          @elseif($data->paid_amount > 0 && $data->total > $data->paid_amount )
          <td><span class="label label-warning">{{ trans('message.invoice.partially_paid')}}</span></td>
          @elseif($data->paid_amount<=$data->paid_amount)
          <td><span class="label label-success">{{ trans('message.invoice.paid')}}</span></td>
          @endif
          
    </tr>
    @endforeach
  
  
          
         
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

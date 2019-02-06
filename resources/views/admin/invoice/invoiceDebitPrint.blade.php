@foreach($produtos as $result)
@php
$d = 11
@endphp
@endforeach

@php
$id = $customerInfo->debtor_no;
@endphp

<?php
require_once './conexao.php';

//pega id d debit
$sql_debito_no = "Select * from sales_debito
                inner join sales_order_details on sales_debito.debit_no=sales_order_details.order_no
                where invoice_type_debit = 'directInvoice' AND order_no_id = $d";
$comando_debito_no = $pdo->prepare($sql_debito_no);
$comando_debito_no->execute();
$rs_debt_no = $comando_debito_no->fetch();
$d_no =  $rs_debt_no["debit_no"];
$d_ref =  $rs_debt_no["reference_debit"];
$data_debito =  $rs_debt_no["debit_date"];

/*
$sql_debito = "Select * from sales_debito
                inner join sales_order_details on sales_debito.debit_no=sales_order_details.order_no
                where invoice_type_debit = 'directInvoice' AND debit_no = $d_no";
$comando_debito = $pdo->prepare($sql_debito);
$comando_debito->execute();


$sql_debito2 = "Select * from sales_debito
                inner join sales_order_details on sales_debito.debit_no=sales_order_details.order_no
                where invoice_type_debit = 'directInvoice' AND debit_no = $d_no";
$comando_debito2 = $pdo->prepare($sql_debito2);
$comando_debito2->execute();
$result = $comando_debito2->fetch();
$paid_amount = $result["paid_amount_debit"];
$total_debito = $result["debito"];
$rs_total_debito = 0;
$rs_total_debito = $total_debito - $paid_amount;
*/

//numero de linhas:
$sql = "Select * from cust_branch where debtor_no = '$id'";
$comando = $pdo->prepare($sql);
$comando->execute();
$resultado = $comando->fetch();
$nuit = $resultado ["nuit"];

$sql_company = "Select * from preference where id=20";
$comando_company = $pdo->prepare($sql_company);
$comando_company->execute();
$rs_company = $comando_company->fetch();
$nuit_company = $rs_company ["value"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>{{ trans('message.transaction.debit') }}</title>
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
            height: 210px;
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
    
    
   <img src="{{asset('img/logo.png')}}" width="280">
    
 
      
        <div style="width:300px; float:right; margin-top:10px;height:40px;">
        
            <div style="font-size:30px; font-weight:bold; color:#383838;">{{ trans('message.transaction.debit') }}</div>
           
             @if($saleDataOrder!=null)
                  <strong># {{($saleDataOrder->reference_debit)}}</strong>
                  <div>{{ trans('message.table.date')}} : {{formatDate($SaleDebito->debit_date)}}</div>
                  <h5>{{trans('message.table.invoice_reference')}}:(#{{$saleDataOrder->reference}})</h5>
              @endif
            
        </div>
      

  

   <div style="margin-top:20px;height:125px;">

    <div style="width:400px; float:left; font-size:15px; color:#383838; font-weight:400; padding-left: 15px">
      <div><strong>{{ Session::get('company_name') }}</strong></div>
      <div>{{ Session::get('company_street') }}</div>
      <div>{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
      <div>{{ Session::get('company_country_id') }}</div>
      <div>Contacto: {{ Session::get('company_phone') }}</div>
       <div>Contacto:+258 873539600</div>
      <div>Email: {{ Session::get('company_email') }}</div>
      <div>Nuit: <?php echo $nuit_company;?></div>
    </div>
      
      
    <div style="width:300px; float:right;font-size:15px; color:#383838; font-weight:400;">
      <div><strong>{{ trans('message.quotation.bill_debit_to') }}</strong></div>
      <div><strong>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</strong></div>
      <div>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}}</div>
      <div>{{ !empty($customerInfo->billing_city) ? $customerInfo->billing_city : ''}}{{ !empty($customerInfo->billing_state) ? ', '.$customerInfo->billing_state : ''}}</div>
      <div>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}}{{ !empty($customerInfo->billing_zip_code) ? ' ,'.$customerInfo->billing_zip_code : ''}}</div>

      <!--NUIT-->
      <div>Nuit: <?php echo $nuit;?></div>
    </div>
    </div>

  <!--TBL:-->
  <div style="clear:both"></div>
  <div style="margin-top:30px;">
      
      <br>

      
    <table style="width:100%; border-radius:2px;  ">
        
    <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
       <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.article') }}</th>
      <th style="padding-right:1px;text-align:justify; color: #000000">{{ trans('message.quotation.item_description') }}</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.quantity') }}</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.price') }}({{ Session::get('currency_symbol')}})</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.tax') }}(%)</th>
      <th width="10%" class="text-center">{{ trans('message.table.discount') }}(%)</th>
      <th style="padding-right:10px;text-align:right">{{ trans('message.quotation.amount') }}({{ Session::get('currency_symbol')}})</th>
    </tr>


  @php
    $itemsInformation = '';
    $taxAmount = 0;
    $taxTotal = 0;
    $discountTotal=0;
    $subTotal = 0;$units = 0; $discountTotal=0;
    $quantity=0;
    
  @endphp
  @if(count($produtos )>0)
    @foreach ($produtos  as $produto)
      {{$quantity=$produto->quantity}}
 
    <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
      <td>
      @if($produto->stock_id=="zero")
            
      @else
          {{$produto->stock_id}}
      @endif
      <td>{{$produto->description}}</td>
      </td>
      <td style="text-align:center; color: #000000">{{$produto->quantity}}</td>
      <td style="text-align:center; color: #000000">{{number_format($produto->unit_price,2)}}</td>
      <td style="text-align:center; color: #000000">{{number_format($produto->tax_rate,2,'.',',')}}</td>
      <td style="text-align:center; color: #000000">{{number_format($produto->discount_percent,2)}}</td>
      @php
        $priceAmount = ($produto->quantity*$produto->unit_price);
        $discount = ($priceAmount*$produto->discount_percent)/100;
        $discountTotal+=$discount;
        $newPrice = ($priceAmount-$discount);
        $taxAmount = ($newPrice*($produto->tax_rate)/100);
        $taxTotal += $taxAmount;
        $subTotal += $newPrice;
        $units += $produto->quantity;
                                
        $itemsInformation .= '<div>'.$produto->quantity.'x'.' '.$produto->description.'</div>'; 
      @endphp
      <td style="padding-right:10px;text-align:right">{{number_format($newPrice,2,'.',',') }}</td>
    </tr>
  
  @endforeach  

    <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">   
         
          <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
              {{ trans('message.table.total_qty') }}
          </td>   

          <td style="text-align:right; padding-right:10px;border-bottom:none">
              {{$units}}
          </td>
         
    </tr>

    <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">   
         
          <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
              {{ trans('message.table.before_discount') }}({{Session::get('currency_symbol')}})
          </td>   

          <td style="text-align:right; padding-right:10px;border-bottom:none">
             {{ number_format($discountTotal+$subTotal,2,'.',',') }}
          </td>
         
    </tr>

     <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">   
         
          <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
              {{ trans('message.table.discount') }}({{Session::get('currency_symbol')}})
          </td>   

          <td style="text-align:right; padding-right:10px;border-bottom:none">
             {{ number_format($discountTotal,2,'.',',') }}
          </td>
         
    </tr>

      <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">   
         
      <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
       <strong>{{ trans('message.quotation.subtotal') }}</strong>
          <strong>({{Session::get('currency_symbol')}})</strong><br/>
        </td>   

      <td style="text-align:right; padding-right:10px;border-bottom:none">
        <strong>{{number_format($subTotal,2)}}</strong>
      </td>
         
    </tr>
  
    <tr style="background-color:#cdcdcd; text-align:right; font-size:13px; font-weight:normal; height:100px;">
      <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
          {{ trans('message.quotation.tax') }}
        </td>
      <td style="text-align:right; padding-right:10px; border-bottom:none">
         {{number_format("$taxTotal",2)}}
      </td>
    </tr>    

     <!--Total-->
    <tr style="background-color:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">
      <td colspan="6" style="text-align:right;border-bottom:none; color: #000000;background:#ffffff;">
        <strong>{{ trans('message.table.price') }}</strong>
        <strong> ({{Session::get('currency_symbol')}})</strong>
      </td>
      <td style="text-align:right; padding-right:10px;border-bottom:none">
        <strong>

        {{number_format(($subTotal+$taxTotal),2,'.',',')}}
      </strong>
      </td>
    </tr>
    <!--FIM-->
   @endif
   </table> 
    </div>
    
  </div>
      
      
      
       <footer class="footer1">
        <table class="tablefooter">
          <tr style="background-color:#f0f0f0; border-bottom:2px solid #006DEF; text-align:center; font-size:12px; font-weight:bold;">
            <th>Nossos Servicos</th>
          </tr>
          <tr style="font-size:10px">
            <td width="100%">Prestamos serviços de montagem e configuração de redes, servidores,VOIP, cameras IP ou Analógicas, assistência técnica a diversos equipamentos informáticos. </td>
          </tr>
        </table>
          <table class="tablefooter">
          <tr style="background-color:#f0f0f0; border-bottom:2px solid #006DEF; text-align:center; font-size:12px; font-weight:bold;">
            <th>Somos parceiros e certificados pelas seguintes marcas:</th>
         </tr>

          <tr style="font-size:10px">
            <td width="100%">Dell | HP | Samsung | LG | Apple | Lenovo | Microsoft | Toshiba | Epson | Verbatim | Cisco | Logitech | Pantum | Asus | Targus | Western Digital | Sandisk | Lacie | D-Link | Adata | Hisense | </td>
       
          </tr>
        </table>


       <table class="tablefooter">
          <tr style="background-color:#f0f0f0; border-bottom:2px solid #006DEF; text-align:center; font-size:12px; font-weight:bold;">
            <th style="border-bottom:1px solid #000000">Dados bancarios</th>
          </tr>

          <tr style="font-size:10px">
            <td>BCI- 18539193010001 </td>
          </tr>
          <tr style="font-size:10px">
            <td>NIB: 000800008539193010195</td>
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

@php
$supp_id = $customerInfo->debtor_no;
@endphp

<?php
require_once './conexao.php';
//numero de linhas:
$sql = "Select * from cust_branch where debtor_no = '$supp_id'";
$comando = $pdo->prepare($sql);
$comando->execute();
$resultado = $comando->fetch();
$nuit = $resultado ["nuit"];


$sql_company = "Select * from preference where id=20";
$comando_company = $pdo->prepare($sql_company);
$comando_company->execute();
$rs_company = $comando_company->fetch();
$nuit_company = $rs_company ["value"];?>









<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    

    

    

    <title>{{ trans('message.invoice_pdf.invoice') }}</title>
    
    
   



    

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
            bottom: -200px;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 260px;
            /*background-color: #f5f5f5*/;
          }

.footer {
            position: absolute;
            bottom: 1px;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 100px;
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
  
  
    
  <img src="{{asset('img/logo.png')}}" width="150">
  


  <!--div style="width:900px; margin:15px auto;"-->


  <div style="width:300px; float:right; margin-top:10px;height:50px;">
    <div style="font-size:30px; font-weight:bold; color:#383838;">Proforma</div>
       <div><strong># {{$saleDataInvoice->reference}}</strong></div>
       <!--img src="{{asset('img/code_.jpg')}}" width="100"-->
  </div>


  <!--
Chutimia - REMOVI
  div style="width:450px; float:right;height:50px;">
    <div style="text-align:right; font-size:14px; color:#383838;"><strong></strong></div>
    <div style="text-align:right; font-size:14px; color:#383838;"><strong></strong></div>
  </div-->

  <!--div style="clear:both;"></div-->

  <div style="margin-top:20px;height:230px;">

    <div style="width:400px; float:left; font-size:15px; color:#383838; font-weight:400; padding-left: 15px">
      <div><strong>{{ Session::get('company_name') }}</strong></div>
    <div>{{ Session::get('company_street') }}</div>
    <div>{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
    <div>{{ Session::get('company_country_id') }}</div>
    <div>Contacto: {{ Session::get('company_phone') }}</div>
    <div>Email: {{ Session::get('company_email') }}</div>
  
   </div>

 <div style="width:400px; float:right;font-size:15px; color:#383838; font-weight:400; border-bottom:#000000; ">
      <div><strong>{{ trans('message.quotation.bill_to') }}</strong></div>
      <div><strong>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</strong></div>
      
    </div>
  
  </div>

    <div>
      
          <div style="width:300px; float:left; font-size:15px; color:#383838; font-weight:bold; padding-left: 15px">
            <div>{{ trans('message.invoice_pdf.invoice_date') }} :{{formatDate($saleDataInvoice->ord_date)}}</div>
          </div>

          <div style="width:300px; float:right; font-size:15px; color:#383838; font-weight:bold;">
                 
          </div>      
    </div>
  
  <div style="clear:both"></div>
  <div style="margin-top:30px;">

  <table style="width:100%; border-radius:2px;  ">
       
      <tr style="background:#cdcdcd;text-align:center; font-size:13px; font-weight:bold;">
            
        <td style="padding-right:1px;text-align:center; color: #000000"></td>
       
        <td style="padding-right:140px;text-align:center; color: #000000">{{ trans('message.quotation.item_description1') }}</td>
        <td style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.quantity') }}</td>
        <td style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.price1') }}(MT)</td>
        <td style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.tax1') }}(%)</td>
        <td style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.discount') }}(%)</td>
        <td style="padding-right:10px;text-align:center;color: #000000">{{ trans('message.quotation.amount') }}(MT)</td>
          
      </tr>

         <?php
          $taxAmount      = 0;
          $taxTotal = 0;
          $subTotalAmount = 0;
          $qtyTotal       = 0;
          $priceAmount    = 0;
          $discount       = 0;
          $discountPriceAmount = 0;  
          $sum = 0;
          $i=0;
          $valueTotal=0;
          $discountTotal=0;
        ?>
        @foreach ($invoiceData as $item)
         <?php
          $price = ($item['quantity']*$item['unit_price']);
          $discount =  ($item['discount_percent']*$price)/100;
          $discountPriceAmount = ($price-$discount);
          $qtyTotal +=$item['quantity']; 
          $subTotalAmount += $discountPriceAmount; 
          $taxAmount = (($discountPriceAmount*$item['tax_rate'])/100);
          $taxTotal += $taxAmount;
          $value=$item['unit_price']*$item['quantity'];
          $valueTotal+=$value;
          $discountAmount=$item['quantity']*($item['unit_price']*$item['discount_percent'])/100;
          $discountTotal+=$discountAmount;

         ?> 

      <tr style="background-color:#fff; text-align:center; font-size:11px; font-weight:normal;">
        <td></td>
        
        <td>{{$item['description']}}</td>
        <td style="text-align:center; color: #000000">{{$item['quantity']}}</td>
        <td style="text-align:right; color: #000000">{{number_format(($item['unit_price']),2,'.',',')}}</td>
        <td style="text-align:center; color: #000000">{{number_format($item['tax_rate'],2,'.',',')}}</td>
        <td style="text-align:center; color: #000000">{{number_format($item['discount_percent'],2,'.',',')}}</td>
        <td style="padding-right:10px;text-align:right">{{number_format($discountPriceAmount,2,'.',',')}}</td>
      </tr>
    <?php
      $sum = $item['quantity']+$sum;
    ?>
    @endforeach   
       <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">
          
        <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
           {{ trans('message.quotation.total_quantity') }}
          </td>   
        <td style="text-align:right; padding-right:10px;border-bottom:none">
          {{$sum}}
        </td>
      </tr>

    <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">
        <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
          {{ trans('message.table.before_discount')}}({{Session::get('currency_symbol')}})
          </td>
        <td style="text-align:right; padding-right:10px; border-bottom:none">
         {{number_format(($valueTotal),2,'.',',')}}
        </td>
      </tr>    
      <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">
        <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
          {{ trans('message.table.discount')}}({{Session::get('currency_symbol')}})
          </td>
        <td style="text-align:right; padding-right:10px; border-bottom:none">
         {{number_format(($discountTotal),2,'.',',')}}
        </td>
      </tr>    
      <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">  
        <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">
         <strong>{{ trans('message.quotation.subtotal') }}</strong><strong> ({{Session::get('currency_symbol')}})</strong><br/>
        </td>   

        <td style="text-align:right; padding-right:10px;">
         
         {{number_format(($subTotalAmount),2,'.',',')}}<br/>
        </td>
      </tr>
   
      <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal; height:100px;">
        <td colspan="6" style="border-bottom:none;text-align:right;background:#ffffff;">{{ trans('message.quotation.tax') }}</td>
        <td style="text-align:right; padding-right:10px; border-bottom:none">{{number_format(($taxTotal),2,'.',',')}}</td>
      </tr>     
         

      <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal;">
        <td colspan="6" style="text-align:right;border-bottom:none; color: #000000;background:#ffffff;"><strong>{{ trans('message.quotation.grand_total') }}</strong><strong>({{Session::get('currency_symbol')}})</strong>
          </td>
        <td style="text-align:right; padding-right:10px;border-bottom:none; color: #000000"><strong>{{number_format(($subTotalAmount+$taxTotal),2,'.',',')}}</strong></td>
      </tr>
      </table> 
    </div>
  </div>
    
    
    
    
     <footer class="footer1">
        
    

<table class="tablefooter">
          
          <tr style="background-color:#f0f0f0; border-bottom:2px solid #006DEF; text-align:center; font-size:12px; font-weight:bold;">
            <th style="border-bottom:1px solid #000000">Dados bancarios</th>
         
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
                   
          
       
         </div>


        </div>    
         

    </footer>

</body>
</html>

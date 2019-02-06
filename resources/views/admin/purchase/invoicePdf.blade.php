<?php
require_once './conexao.php';
//numero de linhas:
$sql = "Select * from cust_branch";
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
    <title>{{ trans('message.purchase.purchase_order') }}</title>
    
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
      <div style="font-size:20px;">
        <strong>{{ trans('message.purchase.purchase_order') }}</strong><br>
      </div>
        
     <div> 
        {{ trans('message.table.invoice_no').' # '.$purchData->reference }}
    </div>
    <div>
      {{ trans('message.table.date')}} : {{formatDate($purchData->ord_date)}}
    </div>
    
    </div>
    
    
 

  <div style="margin-top:40px;height:125px;">
      
    <div style="width:400px; float:left; font-size:15px; color:#383838; font-weight:400;">
      <div><strong>{{ Session::get('company_name') }}</strong></div>
    <div>{{ Session::get('company_street') }}</div>
    <div>{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
    <div>{{ Session::get('company_country_id') }}</div>

    <div>Nuit: <?php echo $nuit_company;?></div>
    </div>
      
      
    <div style="width:300px; float:right;font-size:15px; color:#383838; font-weight:400;">
      <div><strong>{{!empty($purchData->supp_name) ? $purchData->supp_name : ''}}<strong></div>
      <div>{{!empty($purchData->address) ? $purchData->address : ''}}</div>
      <div>{{!empty($purchData->city) ? $purchData->city : ''}}{{!empty($purchData->state) ? ', '.$purchData->state : ''}}</div>
      <div>{{!empty($purchData->country) ? $purchData->country : ''}}{{!empty($purchData->zipcode) ? ', '.$purchData->zipcode : ''}}</div>

      <!--NUIT-->
      <div>Nuit: <?php echo $nuit;?></div>
    </div>

  </div>

 <br>
 <br>
 
        
        
        

 <!--<div style="width:450px; float:left; margin-top:20px;height:50px;">
     <div style="font-size:30px; font-weight:bold; color:#383838;">{{ trans('message.purchase.purchase_order') }} # {{$purchData->reference}}</div><br>
     
  </div>-->
      
        
        
  <div style="margin-top:30px;">
      
       <br>
       <br>

    
  
   <table style="width:100%; border-radius:2px;  ">
       
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
      <th style="padding-right:1px;text-align:justify; color: #000000">{{ trans('message.quotation.item_description') }}</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.quantity') }}</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.price') }}({{ Session::get('currency_symbol')}})</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.tax') }}(%)</th>
      <th width="10%" class="text-center">{{ trans('message.table.discount') }}(%)</th>
      <th style="padding-right:10px;text-align:right">{{ trans('message.quotation.amount') }}({{ Session::get('currency_symbol')}})</th>
    </tr>

  <?php
    $taxAmount      = 0;
    $subTotal = 0;
    $qtyTotal       = 0;
    $priceAmount    = 0;
    $sum = 0;
    $i=0;
    $units = 0;
    $valueTotal=0; 
    $discountTotal=0; 
    $taxValue=0; 
    $taxAmount=0;
  ?>
  @foreach ($invoiceItems as $item)
   <?php
        $priceAmount = ($item->quantity_received*$item->unit_price);
        $price_dicounted=$priceAmount-($priceAmount*$item->discount_percent)/100;
        $units += $item->quantity_received;
        $value=$item->unit_price*$item->quantity_received;
        $valueTotal+=$value;
        $discount=$item->quantity_received*($item->unit_price-(($item->unit_price*$item->discount_percent)/100));
        $subTotal+=$discount;
        $discountAmount=$item->quantity_received*($item->unit_price*$item->discount_percent)/100;
        $discountTotal+=$discountAmount;
   ?>
      
    <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
      <td>{{$item->description}}</td>
      <td style="text-align:center; color: #000000">{{$item->quantity_received}}</td>
      <td style="text-align:center; color: #000000">{{number_format(($item->unit_price),2,'.',',')}}</td>
      <td style="text-align:center; color: #000000">{{number_format($item->tax_rate,2,'.',',')}}</td>
      <td style="text-align:center; color: #000000">{{number_format($item->discount_percent,2,'.',',')}}</td>
      <td style="padding-right:10px;text-align:right">{{number_format($price_dicounted,2,'.',',')}}</td>
    </tr>
  <?php
    $sum = ($item->quantity_received+$sum);
  ?>
  @endforeach 
   <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
        
      <td colspan="5" style="border-bottom:none;text-align:right;">
         {{ trans('message.quotation.total_quantity') }}
        </td>   
      <td style="text-align:right; padding-right:10px;border-bottom:none">
        {{$sum}}
      </td>
    </tr>

  <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
      <td colspan="5" style="border-bottom:none;text-align:right;">
        {{ trans('message.table.before_discount')}}({{Session::get('currency_symbol')}})
        </td>
      <td style="text-align:right; padding-right:10px; border-bottom:none">
       {{number_format(($valueTotal),2,'.',',')}}
      </td>
    </tr>    
    <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
      <td colspan="5" style="border-bottom:none;text-align:right;">
        {{ trans('message.table.discount')}}({{Session::get('currency_symbol')}})
        </td>
      <td style="text-align:right; padding-right:10px; border-bottom:none">
       {{number_format(($discountTotal),2,'.',',')}}
      </td>
    </tr>    

   <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
        
      <td colspan="5" style="border-bottom:none;text-align:right;">
       <strong>{{ trans('message.quotation.subtotal') }}</strong><strong>({{Session::get('currency_symbol')}})</strong>
        </td>   
      <td style="text-align:right; padding-right:10px;border-bottom:none">
       {{number_format(($subTotal),2,'.',',')}}<br/>
      </td>
    </tr>
    <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
      <td colspan="5" style="border-bottom:none;text-align:right;">
        {{ trans('message.table.tax') }}({{Session::get('currency_symbol')}})
        </td>
      <td style="text-align:right; padding-right:10px; border-bottom:none">
       {{number_format(($purchData->total-$subTotal),2,'.',',')}}
      </td>
    </tr>     
    <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal;">
      <td colspan="5" style="text-align:right;"><strong>{{ trans('message.quotation.grand_total') }}</strong>
        <strong>({{Session::get('currency_symbol')}})</strong></td>
      <td style="text-align:right; padding-right:10px"><strong>{{number_format(($purchData->total),2,'.',',')}}</strong></td>
    </tr>
   </table> 
    </div>   
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
<?php
require_once './conexao.php';
//numero de linhas:
$sql = "Select * from cust_branch";
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
    <title>{{ trans('message.purchase.purchase_order') }}</title>
    
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
      <div style="font-size:20px;">
        <strong>{{ trans('message.purchase.purchase_order') }}</strong><br>
      </div>
        
     <div> 
        {{ trans('message.table.invoice_no').' # '.$purchData->reference }}
    </div>
    <div>
      {{ trans('message.table.date')}} : {{formatDate($purchData->ord_date)}}
    </div>
    
    </div>
    
    
 

  <div style="margin-top:40px;height:125px;">
      
    <div style="width:400px; float:left; font-size:15px; color:#383838; font-weight:400;">
      <div><strong>{{ Session::get('company_name') }}</strong></div>
    <div>{{ Session::get('company_street') }}</div>
    <div>{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
    <div>{{ Session::get('company_country_id') }}</div>

    <div>Nuit: <?php echo $nuit_company;?></div>
    </div>
      
      
    <div style="width:300px; float:right;font-size:15px; color:#383838; font-weight:400;">
      <div><strong>{{!empty($purchData->supp_name) ? $purchData->supp_name : ''}}<strong></div>
      <div>{{!empty($purchData->address) ? $purchData->address : ''}}</div>
      <div>{{!empty($purchData->city) ? $purchData->city : ''}}{{!empty($purchData->state) ? ', '.$purchData->state : ''}}</div>
      <div>{{!empty($purchData->country) ? $purchData->country : ''}}{{!empty($purchData->zipcode) ? ', '.$purchData->zipcode : ''}}</div>

      <!--NUIT-->
      <div>Nuit: <?php echo $nuit;?></div>
    </div>

  </div>

 <br>
 <br>
 
        
        
        

 <!--<div style="width:450px; float:left; margin-top:20px;height:50px;">
     <div style="font-size:30px; font-weight:bold; color:#383838;">{{ trans('message.purchase.purchase_order') }} # {{$purchData->reference}}</div><br>
     
  </div>-->
      
        
        
  <div style="margin-top:30px;">
      
       <br>
       <br>

    
  
   <table style="width:100%; border-radius:2px;  ">
       
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
      <th style="padding-right:1px;text-align:justify; color: #000000">{{ trans('message.quotation.item_description') }}</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.quantity') }}</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.price') }}({{ Session::get('currency_symbol')}})</th>
      <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.quotation.tax') }}(%)</th>
      <th width="10%" class="text-center">{{ trans('message.table.discount') }}(%)</th>
      <th style="padding-right:10px;text-align:right">{{ trans('message.quotation.amount') }}({{ Session::get('currency_symbol')}})</th>
    </tr>

  <?php
    $taxAmount      = 0;
    $subTotal = 0;
    $qtyTotal       = 0;
    $priceAmount    = 0;
    $sum = 0;
    $i=0;
    $units = 0;
    $valueTotal=0; 
    $discountTotal=0; 
    $taxValue=0; 
    $taxAmount=0;
  ?>
  @foreach ($invoiceItems as $item)
   <?php
        $priceAmount = ($item->quantity_received*$item->unit_price);
        $units += $item->quantity_received;
        $value=$item->unit_price*$item->quantity_received;
        $valueTotal+=$value;
        $discount=$item->quantity_received*($item->unit_price-(($item->unit_price*$item->discount_percent)/100));
        $subTotal+=$discount;
        $discountAmount=$item->quantity_received*($item->unit_price*$item->discount_percent)/100;
        $discountTotal+=$discountAmount;
   ?>
      
    <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
      <td>{{$item->description}}</td>
      <td style="text-align:center; color: #000000">{{$item->quantity_received}}</td>
      <td style="text-align:center; color: #000000">{{number_format(($item->unit_price),2,'.',',')}}</td>
      <td style="text-align:center; color: #000000">{{number_format($item->tax_rate,2,'.',',')}}</td>
      <td style="text-align:center; color: #000000">{{number_format($item->discount_percent,2,'.',',')}}</td>
      <td style="padding-right:10px;text-align:right">{{number_format($priceAmount,2,'.',',')}}</td>
    </tr>
  <?php
    $sum = ($item->quantity_received+$sum);
  ?>
  @endforeach 
   <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
        
      <td colspan="5" style="border-bottom:none;text-align:right;">
         {{ trans('message.quotation.total_quantity') }}
        </td>   
      <td style="text-align:right; padding-right:10px;border-bottom:none">
        {{$sum}}
      </td>
    </tr>

  <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
      <td colspan="5" style="border-bottom:none;text-align:right;">
        {{ trans('message.table.before_discount')}}({{Session::get('currency_symbol')}})
        </td>
      <td style="text-align:right; padding-right:10px; border-bottom:none">
       {{number_format(($valueTotal),2,'.',',')}}
      </td>
    </tr>    
    <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
      <td colspan="5" style="border-bottom:none;text-align:right;">
        {{ trans('message.table.discount')}}({{Session::get('currency_symbol')}})
        </td>
      <td style="text-align:right; padding-right:10px; border-bottom:none">
       {{number_format(($discountTotal),2,'.',',')}}
      </td>
    </tr>    

   <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
        
      <td colspan="5" style="border-bottom:none;text-align:right;">
       <strong>{{ trans('message.quotation.subtotal') }}</strong><strong>({{Session::get('currency_symbol')}})</strong>
        </td>   
      <td style="text-align:right; padding-right:10px;border-bottom:none">
       {{number_format(($subTotal),2,'.',',')}}<br/>
      </td>
    </tr>
    <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal; height:100px;">
      <td colspan="5" style="border-bottom:none;text-align:right;">
        {{ trans('message.table.tax') }}({{Session::get('currency_symbol')}})
        </td>
      <td style="text-align:right; padding-right:10px; border-bottom:none">
       {{number_format(($purchData->total-$subTotal),2,'.',',')}}
      </td>
    </tr>     
    <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal;">
      <td colspan="5" style="text-align:right;"><strong>{{ trans('message.quotation.grand_total') }}</strong>
        <strong>({{Session::get('currency_symbol')}})</strong></td>
      <td style="text-align:right; padding-right:10px"><strong>{{number_format(($purchData->total),2,'.',',')}}</strong></td>
    </tr>
   </table> 
    </div>   
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

@php
$id = $saleDataOrder->vd_no;
@endphp

<?php
//data para id:
$dt = date("Y/m/d");
$parte_ano = substr($dt,  0, 4);

require_once './conexao.php';
//numero de linhas:
$sql = "Select * from cust_branch";
$comando = $pdo->prepare($sql);
$comando->execute();
$resultado = $comando->fetch();


$sql_company = "Select * from preference where id=20";
$comando_company = $pdo->prepare($sql_company);
$comando_company->execute();
$rs_company = $comando_company->fetch();
$nuit_company = $rs_company ["value"];

$query = "Select * from purchase_vd
inner join suppliers on purchase_vd.supplier_no_vd=suppliers.supplier_id
where vd_no = '$id'";
$comando_query = $pdo->prepare($query);
$comando_query->execute();
$rs_query = $comando_query->fetch();
$name = $rs_query ["supp_name"];
$nuit = $rs_query ["nuit"];
$total = $rs_query ["total"];


$query2 = "Select * from purchase_vd
inner join suppliers on purchase_vd.supplier_no_vd=suppliers.supplier_id
inner join purchase_vd_details on purchase_vd.vd_no=purchase_vd_details.vd_no
inner join item_tax_types on purchase_vd_details.tax_type_id=item_tax_types.id where purchase_vd.vd_no = '$id'";
$comando_query2 = $pdo->prepare($query2);
$comando_query2->execute();

$query3 = "Select * from purchase_vd
inner join suppliers on purchase_vd.supplier_no_vd=suppliers.supplier_id
inner join purchase_vd_details on purchase_vd.vd_no=purchase_vd_details.vd_no
inner join item_tax_types on purchase_vd_details.tax_type_id=item_tax_types.id where purchase_vd.vd_no = '$id'";
$comando_query_imposto = $pdo->prepare($query3);
$comando_query_imposto->execute();
$rs_query_imposto = $comando_query_imposto->fetch();

$unit_price = $rs_query_imposto["unit_price"];
$imposto_percent = $rs_query_imposto ["tax_rate"];
$imposto_percent_final = "0.".$imposto_percent;
$imposto = $imposto_percent_final * $unit_price;

$priceAmount = ($rs_query_imposto['quantity']*$unit_price);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{{ trans('message.sidebar.vd') }}</title>
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
            height: 120px;
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

   <div style="width:350px; float:right; margin-top:10px;height=40px;">
     
        <div style="font-size:30px; font-weight:bold; color:#383838;">{{ trans('message.sidebar.cd') }}</div>
        <div><strong>{{ trans('message.table.cd_no') }}<?php echo ' # '.$rs_query["reference_vd"];?></strong></div>
      <div>{{ trans('message.table.vd_date') }}<?php echo ': '.$rs_query["vd_date"];?></div>    
    </div>

  <div style="width:900px; margin:15px auto;">


  <div style="width:450px; float:right;height:50px;">
    <div style="text-align:right; font-size:14px; color:#383838;"><strong></strong></div>
    <div style="text-align:right; font-size:14px; color:#383838;"><strong></strong></div>
  </div>

  <div style="clear:both;"></div>

  <div style="margin-top:40px;height:125px;">
    <div style="width:400px; float:left; font-size:15px; color:#383838; font-weight:400;">
      <div><strong>{{ Session::get('company_name') }}</strong></div>
    <div>{{ Session::get('company_street') }}</div>
    <div>{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
    <div>{{ Session::get('company_country_id') }}</div>

    <div>Nuit: <?php echo $nuit_company;?></div>
    </div>

    <div style="width:300px; float:left;font-size:15px; color:#383838; font-weight:400;">
      <div><strong>{{ trans('message.extra_text.cd_to') }}</strong></div>
      <div><?php echo $name;?></div>
      <div><?php echo $rs_query["address"].", ".$rs_query["city"]."<br>". $rs_query["country"];?></div>

      <!--NUIT-->
      <div>Nuit: <?php echo $nuit;?></div>
    </div>
  </div>

  <div style="clear:both"></div>
  <div style="margin-top:30px;">
   <table style="width:100%; border-radius:2px;  ">
        
   <tr style="background:#cdcdcd;text-align:center; font-size:13px; font-weight:bold;">
       
       
                        <th style="padding-right:140px;text-align:center; color: #000000">{{ trans('message.table.description') }}</th>
                        <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.table.quantity') }}</th>
                        <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.table.rate') }}({{Session::get('currency_symbol')}})</th>
                        <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.table.tax') }}(%)</th>
                         <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.table.discount') }}(%)</th>
                        <th style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
    
    </tr>

    <?php
                       $itemsInformation = '';
                       $taxAmount = 0;
                       $taxTotal = 0;
                       $subTotal = 0;
                       $units = 0;
                       $discountTotal=0;
                      ?>
 
      <?php 
                       while ($rs_query2 = $comando_query2->fetch(PDO::FETCH_ASSOC)) {
                           $unit_price = $rs_query2["unit_price"];
                           $tax_rate = $rs_query2["tax_rate"];
                           $discount_percent = $rs_query2["discount_percent"];
                          if($rs_query2['quantity']>0){?>
        
                            <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
                                
                              <td ><?php echo $rs_query2["description"];?></td>
                              <td style="padding-right:1px;text-align:center; color: #000000"><?php echo $rs_query2["quantity"];?></td>
                              <td style="padding-right:1px;text-align:center; color: #000000"><?php echo number_format($unit_price,2,'.',',');?></td>
                              <td style="padding-right:1px;text-align:center; color: #000000"><?php echo number_format($tax_rate,2,'.',',');?></td>
                              <td style="padding-right:1px;text-align:center; color: #000000"><?php echo number_format($discount_percent,2,'.',',');?></td>
                              <?php
                                $priceAmount = ($rs_query2['quantity']*$unit_price);
                                $discount = ($priceAmount*$discount_percent)/100;
                                $discountTotal+=$discount;
                                $newPrice = ($priceAmount-$discount);
                                $taxAmount = (($newPrice*$tax_rate)/100);
                                $taxTotal += $taxAmount;
                                $subTotal += $newPrice;
                                $units += $rs_query2['quantity'];
                                $itemsInformation .= '<div>'.$rs_query2['quantity'].'x'.' '.$rs_query2["description"].'</div>';
                              ?>
                              <td align="right">{{number_format($newPrice,2,'.',',') }}</td>
                            </tr>
        
                            <?php }
                       }?>

                       <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal; height:100px;">
                            <td colspan="5" style="border-bottom:none;text-align:right;background:#ffffff;">
                                {{ trans('message.table.total_qty') }}
                            </td>
                        <td style="text-align: right;">{{$units}}</td>
                       </tr>

                        <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal; height:100px;">
                          <td colspan="5" style="border-bottom:none;text-align:right;background:#ffffff;">
                              {{ trans('message.table.before_discount') }}
                              ({{ Session::get('currency_symbol')}})
                          </td>
                        <td style="text-align: right;">{{number_format($discountTotal+$subTotal,2,'.',',') }}</td>
                       </tr>

                       <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal; height:100px;">
                        <td colspan="5" style="border-bottom:none;text-align:right;background:#ffffff;">
                            {{ trans('message.table.discount') }}({{ Session::get('currency_symbol')}})</td>
                        <td style="text-align: right;">{{number_format($discountTotal,2,'.',',') }}</td>
                       </tr>

                        <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal; height:100px;">
                        <td colspan="5" style="border-bottom:none;text-align:right;background:#ffffff;"><strong>{{ trans('message.invoice.sub_total') }}<strong>({{Session::get('currency_symbol')}})</strong></td>
                        <td style="text-align: right;">{{number_format($subTotal,2,'.',',') }}</td>
                       </tr>
                        
                        <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal; height:100px;">
                        <td colspan="5" style="border-bottom:none;text-align:right;background:#ffffff;"><strong>{{ trans('message.table.tax') }}({{ Session::get('currency_symbol')}})</strong></td>
                        <td style="text-align: right;">{{number_format($total-$subTotal,2,'.',',')}}</td>
                       </tr>

                        <tr style="background:#cdcdcd; text-align:right; font-size:13px; font-weight:normal; height:100px;">
                        <td colspan="5" style="border-bottom:none;text-align:right;background:#ffffff;"><strong>{{ trans('message.table.amount')}}({{Session::get('currency_symbol')}})</strong></td>
                        <td style="text-align: right;">{{ number_format($total,2,'.',',')}}</td>
                       </tr>

                      </tbody>
  
   </table> 
    </div>
  </div>
   <footer class="footer1">
      
         
 


      <table class="tablefooter">
          
          <tr style="background-color:#f0f0f0; border-bottom:2px solid #006DEF; text-align:center; font-size:12px; font-weight:bold;">
            <th style="border-bottom:1px solid #000000">Dados bancarios - Banco Unico</th>
         
          </tr>

          <tr style="font-size:10px;">
            <td>00002206200</td>
       
          </tr>
          <tr style="font-size:10px">
            <td>NIB 004300000000220620017</td>
          
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

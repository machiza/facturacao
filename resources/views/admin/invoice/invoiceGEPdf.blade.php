@php
$id = $invoiceData->ge_no;
@endphp

@php
$id = $customerInfo->debtor_no;
@endphp

<?php
//data para id:
$dt = date("Y/m/d");
$parte_ano = substr($dt,  0, 4);
  
require_once './conexao.php';
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

$query = "Select * from sales_ge
inner join sales_ge_details on sales_ge.ge_no=sales_ge_details.ge_no_id
inner join debtors_master on sales_ge.debtor_no_ge=debtors_master.debtor_no where ge_no = '$id'";
$comando_query = $pdo->prepare($query);
$comando_query->execute();
$rs = $comando_query->fetch();
$ge = $rs["ge_no"];
$ref_ge = $rs["reference_ge"];
$local_entrega = $rs["local_entrega"];
$ge_date = $rs["ge_date"];
$motorista = $rs["motorista"];
$carta = $rs["carta"];
$matricula = $rs["matricula"];
$comments = $rs["comments"];


$query2 = "Select * from sales_ge
inner join sales_ge_details on sales_ge.ge_no=sales_ge_details.ge_no_id
inner join debtors_master on sales_ge.debtor_no_ge=debtors_master.debtor_no where ge_no = '$id'";
$comando_query2 = $pdo->prepare($query2);
$comando_query2->execute();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{{ trans('message.extra_text.del_guide') }}</title>
</head>
<style>
 body{ font-family:"DeJaVu Sans",Helvetica, sans-serif; color:#121212; line-height:22px;}
 table, tr, td{
    border-bottom: 1px solid #d1d1d1;
    padding: 6px 0px;
}
tr{ height:40px;}
</style>
<body>
  <div style="width:900px; margin:15px auto;">
    <div style="width:450px; float:left; margin-top:20px;height:50px;">
   <div style="font-size:30px; font-weight:bold; color:#383838;">{{ trans('message.extra_text.del_guide') }}</div>
  </div>
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
      <div><strong>{{ trans('message.extra_text.ge_to') }}</strong></div>
      <div>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</div>
      <div>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}},
      {{ !empty($customerInfo->billing_city) ? $customerInfo->billing_city : ''}}{{ !empty($customerInfo->billing_state) ? ', '.$customerInfo->billing_state : ''}}</div>
      <div>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}}{{ !empty($customerInfo->billing_zip_code) ? ' ,'.$customerInfo->billing_zip_code : ''}}</div>

      <!--NUIT-->
      <div>Nuit: <?php echo $nuit;?></div>
    </div>

    <!--Desc da fact:-->
    <div style="width:200px; float:left; text-align:right; font-size:15px; color:#383838; font-weight:400;">
      <div><strong>{{ trans('message.table.ge_no') }} # <?php echo $ref_ge;?></strong></div>
      <div>{{ trans('message.transaction.del_gui_local')}} : <?php echo $local_entrega;?></div>
      <div>{{ trans('message.form.data_entrega')}} : <?php echo $ge_date;?></div>    
    </div>
  </div><!--END CABECLHO-->

  <div style="clear:both"></div>
  <div style="margin-top:30px;">
   <table style="width:100%; border-radius:2px; border:2px solid #d1d1d1; border-collapse: collapse;">
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
      
      <td>Item</td>
      <td>{{ trans('message.table.price') }}({{Session::get('currency_symbol')}})</td>
      <td>{{ trans('message.table.quantity') }}</td>
      <td>{{ trans('message.table.total_price') }}({{Session::get('currency_symbol')}})</td>   
    </tr>
    <?php while($rs2 = $comando_query2->fetch(PDO::FETCH_ASSOC)){?>
    <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
        <td><?php echo $rs2["description"];?></td>
        <td><?php echo $rs2["unit_price"];?></td>
        <td><?php echo $rs2["quantity"];?></td>
        <td><?php echo $rs2["unit_price"] * $rs2["quantity"];?></td>
    </tr>
    <?php } ?>
   </table>
</div>

   <br/><br/><br/>

   	<div style="width: 100%;">
   		<span style="margin-left: 250px; margin-right: 250px">{{ trans('message.extra_text.emp') }}</span>
   		<span>{{ trans('message.extra_text.cli') }}
   			<br><span style="margin-left: 180px; margin-right: 100px">_____________________________</span>
   			<span>_____________________________<br>
   				<span style="margin-left: 180px; margin-right: 300px">{{ Session::get('company_name') }}</span>
   			<span>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</span></span>
   	</div>
   </div>
  
</body>
</html>

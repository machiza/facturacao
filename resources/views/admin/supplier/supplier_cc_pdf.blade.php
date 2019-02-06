@php
$id = $supplierData->supplier_id;
@endphp

<?php
require_once './conexao.php';

$sql_docs = "SELECT idcc, ord_date_doc, reference_doc, amount_doc, amount_credito_doc, saldo as saldo
FROM (
    SELECT
        idcc,
        ord_date_doc,
        reference_doc,
        amount_doc,
        amount_credito_doc,

    @debito_credito := debito_credito AS tipo,
        @saldo := IF(@debito_credito = 0, @saldo + amount_doc, @saldo - amount_credito_doc) AS saldo
    FROM purch_cc, (SELECT @debito_credito := 0, @saldo := 0) as vars
    where supp_id_doc = '$id' ORDER BY idcc
) AS extrato";
$comando_docs = $pdo->prepare($sql_docs);
$comando_docs->execute();

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
<title>{{ trans('message.extra_text.current_account') }}</title>
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
   <div style="font-size:30px; font-weight:bold; color:#383838;">{{ trans('message.extra_text.current_account') }}</div>
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
      <div><strong>{{ trans('message.form.supplier') }}</strong></div>
      <div>{{$supplierData->supp_name}}</div>
      <div>{{$supplierData->address}}, {{$supplierData->city}}</div>
      <div>{{$supplierData->country}}</div>

      <!--NUIT--> 
      <div>Nuit: {{$supplierData->nuit}}</div>
    </div>

    <!--Desc da fact:-->

  </div>
  <div style="clear:both"></div>
  <div style="margin-top:30px;">
   <table style="width:100%; border-radius:2px; border:2px solid #d1d1d1; border-collapse: collapse;">
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
      
      <td>{{ trans('message.accounting.data') }}</td>
      <td>{{ trans('message.accounting.docs') }}</td>
      <td>{{ trans('message.accounting.debits') }}</td>
      <td>{{ trans('message.accounting.credits') }}</td>
      <td>{{ trans('message.table.balance_amount') }}</td>
  </td>
    
    </tr>

                <?php while($rs_docs = $comando_docs->fetch(PDO::FETCH_ASSOC)){
                  //$order_no = $rs_docs ['order_no_doc']; ?>                 
                  <tr>
                    <!--data-->
                    <td><?php echo $rs_docs ['ord_date_doc']?></td>

                    <!--documento-->
                    <td>
                          <?php echo $rs_docs ['reference_doc']?>
                    </td>

                    <!--amount doc-->
                    <td><?php if($rs_docs["amount_doc"] > 0){
                      echo Session::get('currency_symbol').number_format($rs_docs["amount_doc"],2);
                    }else{
                      echo $rs_docs["amount_doc"];
                    }?>
                    </td>

                    <!--credito-->
                    <td><?php if($rs_docs["amount_credito_doc"] > 0){
                      echo Session::get('currency_symbol').number_format($rs_docs["amount_credito_doc"],2);
                    }else{
                      echo $rs_docs["amount_credito_doc"];
                    }?>
                    </td>

                    <td><?php echo Session::get('currency_symbol').number_format($rs_docs["saldo"],2);?></td>
                  </tr>               
                <?php }?>

                
</table>
</div>
    
  </div>
</body>
</html>


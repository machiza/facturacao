@php
$id = $customerData->debtor_no;
@endphp

<?php
require_once './conexao.php';

$sql_docs = "select * from sales_pending where debtor_no_pending = '$id'";
$comando_docs = $pdo->prepare($sql_docs);
$comando_docs->execute();


//soma debito:
$sql_sum = "select *, sum(amount_doc), sum(amount_credito_doc),sum(saldo_doc) from sales_cc
where debtor_no_doc = '$id'";
$comando_sum = $pdo->prepare($sql_sum);
$comando_sum->execute();
$rs_sum = $comando_sum->fetch();
$amount_doc = $rs_sum ['sum(amount_doc)'];
$amount_cred = $rs_sum ['sum(amount_credito_doc)'];
$amount_saldo = $rs_sum ['sum(saldo_doc)'];

$sql_rows = "select *, sum(amount_total_pending) from sales_pending where debtor_no_pending = '$id'";
$comando_rows = $pdo->prepare($sql_rows);
$comando_rows->execute();
$rs_rows = $comando_rows->rowCount();
$rs_row_data = $comando_rows->fetch();



//SALDO TOTAL:
$sql_saldo = "select *, sales_orders.debtor_no,sum(total), sum(paid_amount) from debtors_master
              inner join sales_orders on debtors_master.debtor_no=sales_orders.debtor_no
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo = $pdo->prepare($sql_saldo);
$comando_saldo->execute();
$resultado_saldo = $comando_saldo->fetch();
$total_facturas = $resultado_saldo ["sum(total)"];
$saldo_paid= $resultado_saldo ["sum(paid_amount)"];
$total_saldos = 0;
$saldo  = $total_facturas - $saldo_paid;
$ordem = $resultado_saldo["debtor_no"];

$sql_saldo_debit = "select *, sales_debito.debtor_no_debit, sum(debito),sum(paid_amount_debit)
              from debtors_master
              inner join sales_debito on debtors_master.debtor_no=sales_debito.debtor_no_debit
              where sales_debito.debtor_no_debit = '$id' AND invoice_type_debit='directInvoice'";
$comando_saldo_debit = $pdo->prepare($sql_saldo_debit);
$comando_saldo_debit->execute();

$resultado_saldo_debit = $comando_saldo_debit->fetch();
$counted_debito = $resultado_saldo_debit ["sum(debito)"];
$saldo_debit_paid = $resultado_saldo_debit ["sum(paid_amount_debit)"];
//total_saldos:
$saldo_debit = $counted_debito - $saldo_debit_paid;


$sql_saldo_credit = "select *, sum(credito), sum(paid_amount_credit) from sales_orders
              inner join sales_credito on sales_orders.order_no=sales_credito.order_no_id
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo_credit = $pdo->prepare($sql_saldo_credit);
$comando_saldo_credit->execute();
$resultado_saldo_credit = $comando_saldo_credit->fetch();
$saldo_credit = $resultado_saldo_credit ["sum(credito)"] - $resultado_saldo_credit ["paid_amount_credit"] ;
$saldo_credit_paid = $resultado_saldo_credit ["sum(paid_amount_credit)"];//pago

//Saldo total (fact e debts):
$saldo_total = number_format(($saldo + $saldo_debit) - $saldo_credit,2);

$paid_total = number_format($saldo_paid + $saldo_debit_paid + $saldo_credit_paid,2);
?>

<?php
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
<title>{{ trans('message.extra_text.current_account_pending') }}</title>
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
   <div style="font-size:30px; font-weight:bold; color:#383838;">{{ trans('message.extra_text.current_account_pending') }}</div>
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
      <div><strong>{{ trans('message.quotation.conta_customer') }}</strong></div>
      <div>{{ !empty($customerData->name) ? $customerData->name : ''}}</div>
      <div>{{ !empty($customerBranchData->billing_street) ? $customerBranchData->billing_street : ''}},
      {{ !empty($customerBranchData->billing_city) ? $customerBranchData->billing_city : ''}}{{ !empty($customerBranchData->billing_state) ? ', '.$customerBranchData->billing_state : ''}}</div>
      <div>{{ !empty($customerBranchData->billing_country_id) ? $customerBranchData->billing_country_id : ''}}{{ !empty($customerBranchData->billing_zip_code) ? ' ,'.$customerBranchData->billing_zip_code : ''}}</div>

      <!--NUIT-->
      <div>Nuit: <?php echo $nuit;?></div>
    </div>

    <!--Desc da fact:-->

  </div>
  <div style="clear:both"></div>
  <div style="margin-top:30px;">
   <table style="width:100%; border-radius:2px; border:2px solid #d1d1d1; border-collapse: collapse;">
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
      
      <th>{{ trans('message.accounting.data') }}</th>
      <th>{{ trans('message.accounting.docs') }}</th>
      <th>{{ trans('message.table.total_price') }}</th>
      <th>{{ trans('message.table.paid_amount') }}</th>
      <th>{{ trans('message.table.balance_amount') }}</th>
  </td>
    
    </tr>

 <?php while($rs_docs = $comando_docs->fetch(PDO::FETCH_ASSOC)){

                  $saldo_pending = $rs_docs["amount_total_pending"] - $rs_docs["amount_paid_pending"];

                  $ord_date = $rs_docs["ord_date_pending"];
                  $data1 = substr($ord_date, 0, 4);
                  $data2 = substr($ord_date, 5, 2);
                  $data3 = substr($ord_date, 8, 2);
                  if($data1 > 10){
                    $data_final = $data3."-". + $data2."-". + $data1; 
                  }else{
                    $data_final = $data3."-". + $data2."-0". + $data1;
                  }
                  $href = $rs_docs["reference_pending"];
                  $href_final = substr($href, 0, 2);
                  ?>
                  <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal; height:100px;">
                    <!--data-->
                    <td><?php echo $data_final;?></td>

                    <!--documento-->
                    <td><?php echo $rs_docs["reference_pending"];?></td>

                    <!--amount doc-->
                    <td><?php if($rs_docs["amount_total_pending"] > 0){
                      echo Session::get('currency_symbol').number_format($rs_docs["amount_total_pending"],2);
                    }else{
                      echo $rs_docs["amount_total_pending"];
                    }?>
                    </td>

                    <td><?php echo Session::get('currency_symbol').number_format($rs_docs["amount_paid_pending"],2);?></td>

                    <td><?php echo Session::get('currency_symbol').number_format($saldo_pending,2);?></td>
                  </tr>               
                <?php }?>

                 <?php if($rs_rows >= 1){?>
                  <tr style="font-size:13px; font-weight:normal; text-align:center;">
                    <td></td>
                    <td><strong>Totais:</strong> </td>
                    <td><strong><?php echo Session::get('currency_symbol').number_format($rs_row_data["sum(amount_total_pending)"],2);?></strong></td>

                    <td>
                      <strong>
                           <?php echo $paid_total;?>
                      </strong>
                    </td>

                    <td>
                      <strong>
                        <?php echo $saldo_total; ?>
                      </strong>
                  </td>
                  </tr>
                 <?php } ?>
</table>
</div>
    
  </div>
</body>
</html>


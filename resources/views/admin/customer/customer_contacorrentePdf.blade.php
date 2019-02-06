@php
$id = $customerData->debtor_no;
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
    FROM sales_cc, (SELECT @debito_credito := 0, @saldo := 0) as vars
    where debtor_no_doc = '$id' ORDER BY idcc ASC
) AS extrato";
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

$sql_rows = "select * from sales_cc where debtor_no_doc = '$id'";
$comando_rows = $pdo->prepare($sql_rows);
$comando_rows->execute();
$rs_rows = $comando_rows->rowCount();



//SALDO TOTAL:
$sql_saldo = "select *, sales_orders.debtor_no,sum(total), sum(paid_amount) from debtors_master
              inner join sales_orders on debtors_master.debtor_no=sales_orders.debtor_no
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo = $pdo->prepare($sql_saldo);
$comando_saldo->execute();
$resultado_saldo = $comando_saldo->fetch();
$total_facturas = $resultado_saldo ["sum(total)"];
$total_paid_amount= $resultado_saldo ["sum(paid_amount)"];
$total_saldos = 0;
$total_saldos = $total_facturas - $total_paid_amount;
$ordem = $resultado_saldo["debtor_no"];

/*debitos:*/
$sql_saldo_debit = "select *, sales_debito.debtor_no_debit, sum(debito),sum(paid_amount_debit)
              from debtors_master
              inner join sales_debito on debtors_master.debtor_no=sales_debito.debtor_no_debit
              where sales_debito.debtor_no_debit = '$id' AND invoice_type_debit='directInvoice'";
$comando_saldo_debit = $pdo->prepare($sql_saldo_debit);
$comando_saldo_debit->execute();

$resultado_saldo_debit = $comando_saldo_debit->fetch();
$counted_debito = $resultado_saldo_debit ["sum(debito)"];
$total_paid_amount = $resultado_saldo_debit ["sum(paid_amount_debit)"];
//total_saldos:
$saldo_debit = $counted_debito - $total_paid_amount;


/*creditos*/
$sql_saldo_credit = "select *, sum(credito) from sales_orders
              inner join sales_credito on sales_orders.order_no=sales_credito.order_no_id
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo_credit = $pdo->prepare($sql_saldo_credit);
$comando_saldo_credit->execute();
$resultado_saldo_credit = $comando_saldo_credit->fetch();
$saldo_credit = $resultado_saldo_credit ["sum(credito)"] - $resultado_saldo_credit ["paid_amount_credit"] ;

//Saldo total (fact e debts):
$saldo_total = number_format(($total_saldos + $saldo_debit) - $saldo_credit,2);
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
    <title>{{ trans('message.extra_text.current_account') }}</title>
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

     <div style="width:330px; float:right; margin-top:10px;height:40px;">
        
          <div style="font-size:20px; font-weight:bold; color:#383838;">
            {{ trans('message.extra_text.current_account') }}
            <span style="font-size:15px; text-align:center">({{ formatDate($from) }} - {{ formatDate($to) }})</span>
          </div>
          <div>{{ !empty($customerData->name) ? $customerData->name : ''}}</div>
          <div>
            {{ !empty($customerBranchData->billing_street) ? $customerBranchData->billing_street : ''}},
            {{ !empty($customerBranchData->billing_city) ? $customerBranchData->billing_city : ''}}
            {{ !empty($customerBranchData->billing_state) ? ', '.$customerBranchData->billing_state : ''}}
          </div>
      </div>
<div>
      
       <br>
       <br>


   

   <table style="width:100%; border-radius:2px;  ">
       
    <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
      <th>{{ trans('message.accounting.data') }}</th>
      <th>{{ trans('message.accounting.docs') }}</th>
      <th>{{ trans('message.accounting.debits') }}</th>
      <th>{{ trans('message.accounting.credits') }}</th>
      <th>{{ trans('message.table.balance_amount') }}</th>
    </tr>
    @php
      $saldo = 0;
      $DebitoTotal = 0;
      $CreditoTotal = 0;
    @endphp
    @foreach($correntes as $dados)
      <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
        <td>{{ formatDate($dados->ord_date_doc)}}</td>
        <td style="padding-right:1px;text-align:justify; color: #000000">
          {{ $dados->reference_doc }}
        </td>
        <td style="padding-right:1px;text-align:justify; color: #000000">
          @if($dados->debito_credito!=0 and $dados->amount_doc>0)
            @php
              $saldo = $saldo + $dados->amount_doc;
              $DebitoTotal = $DebitoTotal + $dados->amount_doc;  
            @endphp
            {{number_format($dados->amount_doc,2).''.Session::get('currency_symbol')}}
          @endif
        </td>
        <td style="padding-right:1px;text-align:justify; color: #000000">
          @if($dados->amount_credito_doc !=0)
            @php
              $saldo=$saldo-$dados->amount_credito_doc;
              $CreditoTotal=$CreditoTotal+$dados->amount_credito_doc;
            @endphp
            {{number_format($dados->amount_credito_doc,2).' '.Session::get('currency_symbol')}}
          @endif
        </td>
        <td>{{ number_format($saldo,2).' '.Session::get('currency_symbol') }}</td>
      </tr>
      @endforeach
       <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
        <td></td>
        <td><strong>Totais:</strong> </td>
        <td><strong>{{Session::get('currency_symbol').number_format($DebitoTotal,2)}}</strong></td>

        <td>
          <strong>
             @if($CreditoTotal > 0)
               {{Session::get('currency_symbol').number_format($CreditoTotal,2)}}
            @else
               {{$CreditoTotal}}
            @endif
          </strong>
        </td>

        <td>
          <strong>
            {{Session::get('currency_symbol').number_format($saldo,2)}}
          </strong>
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

@php
$id = $paymentInfo->id;
@endphp

<!--nuit-->
@php
$supp_id = $paymentInfo->debtor_no;
@endphp
<!--end nuit-->

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
$nuit_company = $rs_company ["value"];


//recibo
$comando_rec = $pdo->prepare("Select * from payment_history where id = '$id'");
$comando_rec->execute();
$resultado_rec = $comando_rec->fetch();
$rec = $resultado_rec ["reference"];

$sql_cc = "Select * from sales_cc
inner join payment_history on sales_cc.reference_doc=payment_history.reference where reference = '$rec'";
$comando_cc = $pdo->prepare($sql_cc);
$comando_cc->execute();
/*while($resultado_cc = $comando_cc->fetch(PDO::FETCH_ASSOC)){
  $ref_cc = $resultado_cc ["reference"];
  echo $ref_cc;
}*/

$sql_cc_ttl = "Select * from sales_cc
inner join payment_history on sales_cc.reference_doc=payment_history.reference where reference = '$rec'";
$comando_cc_ttl = $pdo->prepare($sql_cc_ttl);
$comando_cc_ttl->execute();
$resultado_cc_ttl = $comando_cc_ttl->fetch();
$rs_ttl_cc1 = $resultado_cc_ttl["amount_credito_doc"];
$rs_ttl_cc = $resultado_cc_ttl["amount_credito_doc"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>{{ trans('message.payment.payment') }}</title>
  </head>

<style>
      body{ font-family:'Nova Mono', monospace; color:#121212; line-height:22px;}
       table, tr, td{
          border-bottom: 1px solid #d1d1d1;
          padding: 6px 0px;
      }
      tr{ height:40px;}

      .footer {
            position: absolute;   
            bottom: 1px;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 20px;
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


<div style="width:200px; float:right; margin-top:10px;height:50px;">

      <div style="margin-top:10px;">
        
       <div style="font-weight:bold;font-size:30px;">{{ trans('message.extra_text.payment_receipt_id') }}</div>

       <h5 class="">{{ trans('message.extra_text.payment_receipt_no')}} # {{ $paymentInfo->reference }}</h5>
          
       <div>{{ trans('message.invoice.payment_date2') }} : {{ formatDate($paymentInfo->payment_date) }}</div>
      </div>  
      <br/>
    </div>

 
  <div style="width:900px; margin:15px auto; padding-bottom:40px;">

    

    <div style="width:300px; float:left;">

      <div style="margin-top:20px;">
        <div style="font-size:16px; color:#000000; font-weight:bold;">{{ Session::get('company_name') }}</div>
        <div style="font-size:16px;">{{ Session::get('company_street') }}</div>
        <div style="font-size:16px;">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
        <div style="font-size:16px;">{{ Session::get('company_country_id') }}</div>

        <div>Nuit: <?php echo $nuit_company;?></div>
      </div>
    </div>

    <div style="width:300px; float:right;">
      <div style="margin-top:20px;">
        <div style="font-size:16px;"><strong>{{ !empty($paymentInfo->name) ? $paymentInfo->name : '' }}</strong></div>
        <div style="font-size:16px;">{{ !empty($paymentInfo->billing_street) ? $paymentInfo->billing_street : '' }}</div>
        <div style="font-size:16px;">{{ !empty($paymentInfo->billing_city) ? $paymentInfo->billing_city : '' }}{{ !empty($paymentInfo->billing_state) ? ', '.$paymentInfo->billing_state : '' }}</div>
        <div style="font-size:16px;">{{ !empty($paymentInfo->billing_country_id) ? $paymentInfo->billing_country_id : '' }}{{ !empty($paymentInfo->billing_zip_code) ? ', '.$paymentInfo->billing_zip_code: '' }}</div>

        <!--NUIT-->
      <div>Nuit: <?php echo $nuit;?></div>
      </div>
      <br/>
    </div>
  
    
      
   

  <div style="clear:both"></div>
  <br>
  <br>
  <br>
    <h3 style="text-align:center;margin:20px 0px;">{{ trans('message.extra_text.payment_receipt_cli') }}</h3>
    
    
    <br>
    
    <div style="clear:both"></div>
    <br>
    
      <table style="width:100%; border-radius:2px;  ">
      <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
      
      <td style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.invoice_pdf.invoice_no') }}</td>
      <td style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.invoice_pdf.invoice_date') }}</td>
      <td style="padding-right:1px;text-align:center; color: #000000">{{ trans('message.invoice_pdf.paid_amount') }}</td>
    </tr>

    <?php while($resultado_cc = $comando_cc->fetch(PDO::FETCH_ASSOC)){
            $ref_cc = $resultado_cc ["invoice_reference"];
            $amount_doc_cc = $resultado_cc ["amount_credito_doc"];
            $amount_cc = $resultado_cc ["amount"];
            $rec_cc = $resultado_cc ["reference"];
          ?>
    <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
      
      <td style="padding-right:1px;text-align:center; color: #000000"><?php echo $ref_cc;?></td>
      <td style="padding-right:1px;text-align:center; color: #000000">{{formatDate($paymentInfo->invoice_date)}}</td>
      <td style="padding-right:1px;text-align:center; color: #000000">{{ Session::get('currency_symbol').number_format($amount_cc,2,'.',',') }}</td>
    </tr>
    <?php } ?>
  </table>

  <br>
  <br>
  <br>

  
  
  
  <div style="height:80px;width:300px;background-color:#f0f0f0;color:#000;text-align:center;padding-top:30px; float:right;border:1px solid #000000;">

      <strong>{{ trans('message.payment.total_amount') }}</strong><br>

      <strong>({{Session::get('currency_symbol')}})</strong>
      <strong>{{number_format($rs_ttl_cc,2,'.',',') }}</strong>
  </div>

  <br>
  <div style="font-weight:bold">{{ trans('message.payment.payment_method') }} : {{ $paymentInfo->payment_method }}</div>




  <footer class="footer">
      <table class="tablefooter">  
               <td></td> 
                
     </table>
      
     <div>
           <div style="width:500px; float:left; font-size:10px; color:#383838; font-weight:bold;">
          
                <div>Documento processado por Computador</div>
        
           </div>

        <div style="width:270px;font-weight:bold; float:right; font-size:10px; color:#383838;">
                   
           <div>Software N3 Licenciado a:{{ Session::get('company_name') }}</div>    
       
         </div>

        


    </div> 

  </footer>

  <!--script type="text/javascript">
      window.onload = function() { window.print(); }
 </script-->
  
</body>
</html>
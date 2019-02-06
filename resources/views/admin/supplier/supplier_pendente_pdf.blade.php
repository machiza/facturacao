@php
$id = $supplierData->supplier_id;
@endphp

<?php
require_once './conexao.php';

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
   <div style="font-size:30px; font-weight:bold; color:#383838;">{{ trans('message.extra_text.pendentes') }}</div>
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
      
      <th>{{ trans('message.accounting.data') }}</th>
                    <th>{{ trans('message.accounting.docs') }}</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
  </td>
    
    </tr>

                @foreach($purchData as $data)                  
                  <tr>
                    <!--data-->
                    <td>{{$data->ord_date}}</td>

                    <!--documento-->
                    <td>
                        {{$data->reference}}
                    </td>

                    <!--amount doc-->
                    <td>{{Session::get('currency_symbol').number_format($data->total,2)}}</td>
                    <td>{{Session::get('currency_symbol').number_format($data->valor_pago,2)}}</td>
                    <td>{{Session::get('currency_symbol').number_format($data->total - $data->valor_pago,2)}}</td>
                  </tr>               
                 @endforeach

                 @if(count($purchData) >= 1)
                  <tr>
                    <td></td>
                    <td><strong>Totais:</strong> </td>

                    <td>
                      <strong>
                        {{Session::get('currency_symbol').number_format($total->total_price,2)}}
                      </strong>
                    </td>

                    <td>
                      <strong>
                          {{Session::get('currency_symbol').number_format($saldo->total_saldo,2)}}
                      </strong>
                    </td>

                    <td>
                      <strong>
                          {{Session::get('currency_symbol').number_format($total->total_price - $saldo->total_saldo,2)}}
                      </strong>
                  </td>
                  </tr>
                 @endif
                
</table>
</div>
    
  </div>
</body>
</html>


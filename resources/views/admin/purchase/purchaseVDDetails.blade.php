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
$total = $rs_query ["total"];
$nuit = $rs_query ["nuit"];


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

@extends('layouts.app')
@section('content')
  <section class="content">

      <!---Top Section Start-->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title">{{ trans('message.sidebar.cd') }}</div>
            </div>
            <div class="col-md-2">
             
                <a href="{{ url("purchase/add_vd") }}" class="btn btn-block btn-default btn-flat btn-border-orange">{{ trans('message.extra_text.new_purchases_cd') }}</a>
              
            </div>
          </div>
        </div>
      </div>
      <!---Top Section End-->

    <div class="row">
      <div class="col-md-8 right-padding-col8">
          <div class="box box-default">
              <div class="box-body">

                    <div class="btn-group pull-right">
                       <!--btn chamar print-->
                      <a target="_blank" href="{{URL::to('/')}}/purchase/pdf-vd-print/{{$id}}" title="PRINT" class="btn btn-default btn-flat">{{ trans('message.extra_text.print')  }}</a>

                      <!--btn chamar pfd-->
                      <a target="_blank" href="{{URL::to('/')}}/purchase/pdf-vd/{{$id}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                    </div>
              </div>

            <div class="box-body">
              <div class="row">
                
                  <div class="col-md-4">
                    <strong>{{ Session::get('company_name') }}</strong>
                    <h5 class="">{{ Session::get('company_street') }}</h5>
                    <h5 class="">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</h5>
                    <h5 class="">{{ Session::get('company_country_id') }}</h5>

                    <h5> Nuit: <?php echo $nuit_company;?></h5>
                  </div>

                  <div class="col-md-4">
                  <strong>{{ trans('message.extra_text.cd_to') }}</strong>
                  <h5><?php echo $name.", ";?> </h5>

                  <h5><?php echo $rs_query["address"].", ".$rs_query["city"]."<br>". $rs_query["country"];?></h5>
                  

                  <!--Nuit-->
                  <h5>Nuit: <?php echo $nuit;?></h5>
                  </div>

                <div class="col-md-4">
                  <strong>{{ trans('message.table.cd_no') }}<?php echo ' # '.$rs_query["reference_vd"];?></strong>
                  <h5>{{ trans('message.table.vd_date') }}<?php echo ': '.$rs_query["vd_date"];?></h5>
                </div>

              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="box-body no-padding">
                    <div class="table-responsive">
                    <table class="table table-bordered" id="salesInvoice">
                      <tbody>
                      <tr class="tbl_header_color dynamicRows">
                        <th width="30%" class="text-center">{{ trans('message.table.description') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.rate') }}({{Session::get('currency_symbol')}})</th>
                        <th width="10%" class="text-center">{{ trans('message.table.tax') }}(%)</th>
                        <th class="text-center" width="10%">{{ trans('message.table.discount') }}(%)</th>
                        <th width="10%" class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                      </tr>
                      <?php
                       $itemsInformation = '';
                       $taxAmount = 0;
                       $taxTotal = 0;
                       $discountTotal=0;
                       $subTotal=0;
                      ?>
                      
                       <?php $subTotal = 0;$units = 0;
                       while ($rs_query2 = $comando_query2->fetch(PDO::FETCH_ASSOC)) {
                       	   $unit_price = $rs_query2["unit_price"];
                           $tax_rate = $rs_query2["tax_rate"];
                           $discount_percent = $rs_query2["discount_percent"];
                       	   
                          if($rs_query2['quantity']>0){?>
                            <tr>
                              <td class="text-center"><?php echo $rs_query2["description"];?></td>
                              <td class="text-center"><?php echo $rs_query2["quantity"];?></td>
                              <td class="text-center"><?php echo number_format($unit_price,2,'.',',');?></td>
                              <td class="text-center"><?php echo number_format($tax_rate,2,'.',',');?></td>
                              <td class="text-center"><?php echo number_format($discount_percent,2,'.',',');?></td>
                              
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
                       <tr class="tableInfos">
                          <td colspan="5" align="right">{{ trans('message.table.total_qty') }}</td>
                          <td align="right" colspan="2">{{$units}}</td>
                        </tr>
                          <tr class="tableInfos">
                          <td colspan="5" align="right">{{ trans('message.table.before_discount')}}</td>
                          <td align="right" colspan="2">  {{ Session::get('currency_symbol').number_format($discountTotal+$subTotal,2,'.',',') }}</td>
                          </tr>

                          <tr class="tableInfos">
                            <td colspan="5" align="right">{{ trans('message.table.discount')}}</td>
                            <td align="right" colspan="2">{{ Session::get('currency_symbol').number_format($discountTotal,2,'.',',') }}</td>
                          </tr>
                       <tr class="tableInfos">
                        <td colspan="5" align="right"><strong>{{ trans('message.invoice.sub_total') }}:</strong></td>
                        <td colspan="2">{{ Session::get('currency_symbol').number_format($subTotal,2,'.',',') }}</td>
                       </tr>

                       <tr class="tableInfos">
                        <td colspan="5" align="right"><strong>{{ trans('message.table.tax') }}:</strong></td>
                        <td colspan="2"><?php echo number_format($imposto,2,'.',',');?></td>
                       </tr>

                       <tr class="tableInfos">
                       	<td colspan="5" align="right"><strong>{{ trans('message.table.amount')}}:</strong></td>
                       	<td colspan="2" ><?php echo number_format($total,2,'.',',');?></td>
                       </tr>

                      </tbody>
                    </table>
                    </div>
                    <br><br>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      
      </div>
  </section>


@include('layouts.includes.message_boxes') 
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
      $(".select2").select2();
      $('#payment_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });  

    $('#payment_date').datepicker('update', new Date());

      $(function () {
        $(".editor").wysihtml5();
      });

    $('#sendVoiceInfo').validate({
        rules: {
            email: {
                required: true
            },
            subject:{
               required: true,
            },
            message:{
               required: true,
            }                   
        }
    }); 


$('.delete_data').bootstrap_confirm_delete({
  heading: "{{ trans('message.invoice.delete_invoice') }}",
  message: "{{ trans('message.invoice.delete_invoice_confirm') }}",
  data_type: null,
});       

});

</script>
@endsection
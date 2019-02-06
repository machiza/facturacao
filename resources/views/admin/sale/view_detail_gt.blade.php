@php
$id = $invoiceData->gt_no;
@endphp

@php
$supp_id = $customerInfo->debtor_no;
@endphp

<?php
//data para id:
$dt = date("Y/m/d");
$parte_ano = substr($dt,  0, 4);

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

$query = "Select * from sales_gt
inner join sales_gt_details on sales_gt.gt_no=sales_gt_details.gt_no_id
inner join debtors_master on sales_gt.debtor_no_gt=debtors_master.debtor_no where gt_no = '$id'";
$comando_query = $pdo->prepare($query);
$comando_query->execute();
$rs = $comando_query->fetch();
$ge = $rs["gt_no"];
$ref_gt = $rs["reference_gt"];
$local_entrega = $rs["local_entrega"];
$gt_date = $rs["gt_date"];

$query2 = "Select * from sales_gt
inner join sales_gt_details on sales_gt.gt_no=sales_gt_details.gt_no_id
inner join debtors_master on sales_gt.debtor_no_gt=debtors_master.debtor_no where gt_no = '$id'";
$comando_query2 = $pdo->prepare($query2);
$comando_query2->execute();
?>


@extends('layouts.app')
@section('content')
  <section class="content">

      <!---Top Section Start-->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title">{{ trans('message.sidebar.transportation_guide') }}</div>
            </div>
            <div class="col-md-2">
             @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
                    <a href="{{ url('sales/add_guiatransporte') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_trans_guide') }}</a>
                    @endif
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
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-gt-print/{{$ge}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.print')  }}</a>

                      <!--btn chamar pfd-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-gt/{{$ge}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                      
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
                  <strong>{{ trans('message.extra_text.gt_to') }}</strong>
                  <h5>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</h5>

                  <h5>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}} 
                  {{ !empty($customerInfo->billing_state) ? $customerInfo->billing_state : ''}}{{ !empty($customerInfo->billing_city) ? ', '.$customerInfo->billing_city : ''}}</h5>
                  <h5>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}} {{ !empty($customerInfo->billing_zip_code) ? ', '.$customerInfo->billing_zip_code : ''}}</h5>

                  <!--Nuit-->
                  <h5>Nuit: <?php echo $nuit;?></h5>
                  </div>

                <div class="col-md-4">
                  <strong>{{ trans('message.table.gt_no') }} # <?php echo $ref_gt;?></strong>
                  <h5>{{ trans('message.transaction.del_gui_local')}} : <?php echo $local_entrega;?></h5>
                  <h5>{{ trans('message.form.data_trans')}} : <?php echo $gt_date;?></h5>
                </div>

              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="box-body no-padding">
                    <div class="table-responsive">
                    <table class="table table-bordered" id="salesInvoice">
                      <tbody>
                      <tr class="tbl_header_color dynamicRows">
                        <th width="30%" class="text-center">Item</th>
                        <th width="10%" class="text-center">{{ trans('message.table.price') }}({{Session::get('currency_symbol')}})</th>
                        <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.total_price') }}({{Session::get('currency_symbol')}})</th>
                      </tr>
                      <?php while($rs2 = $comando_query2->fetch(PDO::FETCH_ASSOC)){?>
                        <tr style="text-align: center">
                          <td><?php echo $rs2["description"];?></td>
                          <td><?php echo $rs2["unit_price"];?></td>
                          <td><?php echo $rs2["quantity"];?></td>
                          <td><?php echo $rs2["unit_price"] * $rs2["quantity"];?></td>
                        </tr>
                      <?php } ?>
                      
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
      <!--include-->
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

// Item form validation
    $('#payForm').validate({
        rules: {
            account_no:{
              required: true
            },
            payment_type_id: {
                required: true
            },
            amount: {
                required: true
            },
            payment_date:{
               required: true
            },
            category_id:{
            required: true
           },
          description:{
            required: true
          }                   
        }
    });

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
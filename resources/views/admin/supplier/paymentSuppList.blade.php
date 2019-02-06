<?php
require_once './conexao.php';

$sql_id = "Select DISTINCT  *, payment_history.id, payment_terms.name as pay_type from sales_cc
inner join payment_history on sales_cc.reference_doc=payment_history.reference
inner join debtors_master on sales_cc.debtor_no_doc=debtors_master.debtor_no
inner join payment_terms on sales_cc.payment_type_id_doc=payment_terms.id";
$comando_id = $pdo->prepare($sql_id);
$comando_id ->execute();
?>
@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

     <!-- Default box -->
        <div class="box">
           <div class="panel-body">
                <ul class="nav nav-tabs cus" role="tablist">
                	<li>
                      <a href="{{url("edit-supplier/$supplierData->supplier_id")}}" >{{ trans('message.sidebar.profile') }}</a>
                    </li>
                    <li>
                      <a href="{{url("supplier/orders/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.purchase_orders') }}</a>
                    </li>

                    <li>
                      <a href="{{url("supplier/current_account/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.current_account') }}</a>
                    </li>

                    <li>
                      <a href="{{url("supplier/pendentes/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.pendentes') }}</a>
                    </li>

                    <li class="active">
                      <a href="{{url("supplier/payment_list/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>
               </ul>
              <div class="clearfix"></div>
           </div>
        </div>
        <h3>{{$supplierData->supp_name}}</h3> 
      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="paymentList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.invoice.payment_no') }}</th>
                    <th>{{ trans('message.extra_text.payment_method') }}</th>
                    <th>{{ trans('message.invoice.amount') }}</th>
                    <th>{{ trans('message.invoice.payment_date') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($recibos as $data)
                  <tr>
                    <td>
                      <a href="{{ url("payment/view-supp-receipt/$data->pay_history_id") }}">
                         {{$data->reference}}
                      </a>
                    </td>

                    <td>{{$data->pay_type}}</td>

                    <td>{{Session::get('currency_symbol').number_format($data->total_amount,2)}}</td>

                    <td>{{$data->payment_date}}</td>
                  </tr>
                 @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->
    </section>
  

@include('layouts.includes.message_boxes')

@endsection

@section('js')
    <script type="text/javascript">
    $(".select2").select2();
  $(function () {
    $("#paymentList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 3,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });


    </script>
@endsection
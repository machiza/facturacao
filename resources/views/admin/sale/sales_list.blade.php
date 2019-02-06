<?php
require_once './conexao.php';

$sql_t = "Select *, sum(total) from sales_orders where invoice_type ='directInvoice'";
$comando_t = $pdo->prepare($sql_t);
$comando_t->execute();
$ttl = $comando_t->fetch();
$row_t = $comando_t->rowCount();
$total_facturas = $ttl ["sum(total)"];

$sql = "Select *, sum(total), sum(paid_amount) from sales_orders";
$comando = $pdo->prepare($sql);
$comando->execute();
$row = $comando->rowCount();
$t = $comando->fetch(PDO::FETCH_ASSOC);
$total_paid_amount = 0;
$total_paid_amount = $t ["sum(paid_amount)"];

$total_saldos = 0;
$total_saldos = $total_facturas - $total_paid_amount;
?>

@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.invoices') }}</div>
          </div> 
          <div class="col-md-2">
           @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
              <a style="margin-left:-50px; width:200px" href="{{ url('sales/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_invoice') }}</a>
           @endif
          </div>
        </div>
      </div>
    </div>

      <div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("sales/list")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>
                    
                    <li>
                      <a href="{{url("sales/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
                    </li>
                      
               </ul>
        </div>
       
      </div><!--Filtering Box End-->
      
      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <a href="{{ url('sales-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
           </div>


            <div class="box-body">
              <div class="table-responsive"> 
                <table id="example1" class="table table-hover">
                  <thead>
                  <tr>
                    <th>{{ trans('message.invoice.invoice_date') }}</th>
                    <th>{{ trans('message.table.invoice_no') }}</th>
                    <th>{{ trans('message.table.customer_name') }}</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                    <th>{{ trans('message.table.paid_status') }}</th>
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                         <th width="5%">{{ trans('message.table.action') }}</th>
                    @endif      
                    <!--<th width="5%">{{ trans('message.table.action') }}</th>-->
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($salesData as $data)
                  <!--hugo calcula saldo:-->
                  @php
                      $saldo = $data->total - $data->paid_amount;
                  @endphp
                  <!-- end hugo calcula saldo:-->

                  @if($data->status=='cancelado')
                      <tr  bgcolor="#FF0000">
                  @else
                     <tr>
                  @endif 
                      <td>{{formatDate($data->ord_date)}}</td>

                    <td><a href="{{URL::to('/')}}/invoice/view-detail-invoice/{{$data->order_reference_id.'/'.$data->order_no}}">{{$data->reference }}</a></td>
                    <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{url("customer/edit/$data->debtor_no")}}">{{ $data->cus_name }}</a>
                    @else
                    {{ $data->cus_name }}
                    @endif
                    </td>

                    <td>{{ Session::get('currency_symbol').number_format($data->total,2,'.',',') }}</td>
                    <td>{{ Session::get('currency_symbol').number_format($data->paid_amount,2,'.',',') }}</td>
                    
                    <!--resultado calculo do saldo-->
                    <td>
                      {{ Session::get('currency_symbol').number_format($saldo,2,'.',',') }}
                    </td>
                  
                    @if($data->paid_amount == 0 and $data->status=='cancelado')
                      <td><span class="label label-danger">{{ trans('message.invoice.anuled')}}</span></td>
                     
                    @elseif($data->paid_amount == 0)
                    <td><span class="label label-danger">{{ trans('message.invoice.unpaid')}}</span></td>
                       
                    @elseif($data->paid_amount > 0 && $data->total > $data->paid_amount )
                      <td><span class="label label-warning">{{ trans('message.invoice.partially_paid')}}</span></td>
                    @elseif($data->paid_amount<=$data->paid_amount)
                      <td><span class="label label-success">{{ trans('message.invoice.paid')}}</span></td>
                    @endif
                  
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                    <td>
                            <form method="POST" action="{{ url("invoice/delete/$data->order_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_invoice') }}" data-message="{{ trans('message.invoice.delete_invoice_confirm') }}">
                            <i class="fa fa-remove" aria-hidden="true"></i>
                            </button>
                            </form> 
                    </td>
                    @endif

                  </tr>
                 
                 @endforeach

                 <?php if($total_facturas >= 1){?>
                  <tr>
                    <td ></td>
                      <td></td>
                      <td></td>
                      <td><strong>Total: <?php echo Session::get('currency_symbol').number_format($PrecoTotal,2); ?></strong></td>
                      <td><strong>Total: <?php echo Session::get('currency_symbol').number_format($PrecoPago,2); ?></strong></td>
                      <td><strong>Total: <?php echo Session::get('currency_symbol').number_format($PrecoTotal-$PrecoPago,2); ?></strong></td>
                      <td ></td>
                      <td ></td>
                      
                  </tr>
                 <?php } ?>
                 
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

  $(function () {
    $("#example1").DataTable({
      "order": [],
      "columnDefs": [ {
       // "targets": 6,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });



/*
PrecoTotal
$total_facturas
total_paid_amount
$total_saldos
PrecoPago
*/
    </script>
@endsection


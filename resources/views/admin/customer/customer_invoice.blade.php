@php
$id = $customerData->debtor_no;
@endphp

<?php
require_once './conexao.php';

$sql_t = "Select *, sum(total) from sales_orders where invoice_type ='directInvoice'  and debtor_no = '$id'";
$comando_t = $pdo->prepare($sql_t);
$comando_t->execute();
$ttl = $comando_t->fetch();
$row_t = $comando_t->rowCount();
$total_facturas = $ttl ["sum(total)"];

$sql = "Select *, sum(total), sum(paid_amount) from sales_orders  where debtor_no = '$id'";
$comando = $pdo->prepare($sql);
$comando->execute();
$row = $comando->rowCount();
$t = $comando->fetch(PDO::FETCH_ASSOC);
$total_paid_amount = 0;
$total_paid_amount = $t ["sum(paid_amount)"];
$saldo = $total_facturas - $total_paid_amount;

//total_saldos:
$total_saldos = 0;
$total_saldos = $total_facturas - $total_paid_amount;
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
                      <a href='{{url("customer/edit/$customerData->debtor_no")}}' >{{ trans('message.sidebar.profile') }}</a>
                    </li>
                    
                    <li>
                      <a href="{{url("customer/order/$customerData->debtor_no")}}" >{{ trans('message.accounting.quotations') }}</a>
                    </li>
                    <li class="active">
                      <a href="{{url("customer/invoice/$customerData->debtor_no")}}" >{{ trans('message.extra_text.invoices') }}</a>
                    </li>
                    
                    <li>
                      <a href="{{url("customer/debit/$customerData->debtor_no")}}" >{{ trans('message.accounting.debitsss') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/credit/$customerData->debtor_no")}}" >{{ trans('message.accounting.creditsss') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/payment/$customerData->debtor_no")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/current_account/$customerData->debtor_no")}}" >{{ trans('message.extra_text.current_account') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/pendentes/$customerData->debtor_no")}}" >{{ trans('message.extra_text.pendentes') }}</a>
                    </li>
               </ul>
              <div class="clearfix"></div>
           </div>
        </div>
        <h3>{{$customerData->name}}</h3>  
        
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>

                  <tr>
                    <th>{{ trans('message.table.invoice') }}</th>
                    <th>{{ trans('message.accounting.quotation') }}</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                    <th>{{ trans('message.table.paid_status') }}</th>
                    <th>{{ trans('message.invoice.invoice_date') }}</th>
                    <!--REMOVED by Hugo
                      <th width="10%">{{ trans('message.table.action') }}</th>-->
                  </tr>

                </thead>
                <tbody>
                @foreach ($salesOrderData as $data)
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

                    <td><a href="{{URL::to('/')}}/invoice/view-detail-invoice/{{$data->order_reference_id.'/'.$data->order_no}}">{{$data->reference }}</a></td>
                    <td><a href="{{URL::to('/')}}/order/view-order-details/{{$data->order_reference_id}}">{{ $data->order_reference }}</a></td>
                    <td>{{ Session::get('currency_symbol').number_format($data->total,2,'.',',') }}</td>
                    <td>{{ Session::get('currency_symbol').number_format($data->paid_amount,2,'.',',') }}</td>
                    <td>{{ Session::get('currency_symbol').number_format($saldo,2,'.',',') }}</td>
  
                    @if($data->paid_amount == 0 and $data->status=='cancelado')
                      <td><span class="label label-danger">{{ trans('message.invoice.anuled')}}</span></td>
                    @elseif($data->paid_amount > 0 && $data->total > $data->paid_amount )
                      <td><span class="label label-warning">{{ trans('message.invoice.partially_paid')}}</span></td>
                    @elseif($data->paid_amount==$data->total)
                      <td><span class="label label-success">{{ trans('message.invoice.paid')}}</span></td>
                    @else
                      
                      <td><span class="label label-danger">{{ trans('message.invoice.unpaid')}}</span></td>
                    @endif

                    <td>{{formatDate($data->ord_date)}}</td>
                 
                  </tr>               
                @endforeach

                <?php if($total_facturas >= 1){?>
                  <tr>
                    <td><strong>Totais:</strong></td>
                      <td></td>
                     <td><strong> $<?php echo number_format("$total_facturas",2); ?></strong></td>
                    <td><strong>$<?php echo number_format("$total_paid_amount",2);?></strong></td>
                    <td><strong>$<?php echo number_format("$total_saldos",2);?></strong></td>
                    <td></td>
                      <td ></td>
                      <td ></td>
                      
                  </tr>
                 <?php } ?>

                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        
        <!-- /.box-footer-->
    

    @include('layouts.includes.message_boxes')
    </section>
@endsection


@section('js')
    <script type="text/javascript">

    $(function () {
      
      
      $("#example1").DataTable({
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
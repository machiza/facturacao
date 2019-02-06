@php
$id = $customerData->debtor_no;
@endphp

<?php
require_once './conexao.php';

$sql_credito = "Select * from sales_credito
                inner join sales_orders on sales_credito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where invoice_type = 'directInvoice' and debtor_no_credit = '$id' order by credit_no desc";
$comando_credito = $pdo->prepare($sql_credito);
$comando_credito->execute();

$comando_credito_count = $pdo->prepare("Select sum(credito), sum(paid_amount_credit) from sales_credito
  inner join sales_orders on sales_credito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where invoice_type = 'directInvoice' and debtor_no_credit = '$id'");
$comando_credito_count->execute();
$rows = $comando_credito_count->rowCount();
$count_credito = $comando_credito_count->fetch();
$counted_total_paid = $count_credito ["sum(paid_amount_credit)"];
$counted_credito = $count_credito ["sum(credito)"];
$counted_saldo = $counted_credito - $counted_total_paid;

/*$sql_credito_indirect = "Select * from sales_credito
                inner join sales_orders on sales_credito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where invoice_type_credit = 'indirectOrder'";
$comando_credito_indirect = $pdo->prepare($sql_credito_indirect);
$comando_credito_indirect->execute();
$rs = $comando_credito_indirect->fetch();
$order_reference_id_credit = $rs["order_reference_id_credit"];*/
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
                    <li>
                      <a href="{{url("customer/invoice/$customerData->debtor_no")}}" >{{ trans('message.extra_text.invoices') }}</a>
                    </li>

                    <li >
                      <a href="{{url("customer/debit/$customerData->debtor_no")}}" >{{ trans('message.accounting.debitsss') }}</a>
                    </li>

                    <li class="active">
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
                    <th>{{ trans('message.transaction.credits') }}</th>
                    <th>{{ trans('message.table.invoice_no') }}</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                    <th>{{ trans('message.table.paid_status') }}</th>
                    <th>{{ trans('message.table.invoice_date_credit') }}</th>
                    <!--REMOVED by Hugo<th width="10%">{{ trans('message.table.action') }}</th>-->
                  </tr>

                </thead>
                <tbody>

                   @foreach ($creditos as $cotacao)
                       <tr>
                      <td>
                        <a href="{{URL::to('/')}}/invoice/view-detail-invoice-credito/{{$cotacao->credit_no}}">
                        {{$cotacao->reference_credit}}</a>
                      </td>
                      <td>
                        <a href="{{URL::to('/')}}/invoice/view-detail-invoice/{{$cotacao->order_reference_id.'/'.$cotacao->order_no_id}}">{{$cotacao->reference}}</a>
                      </td>

                     <td><?php echo Session::get('currency_symbol').number_format($cotacao->credito,2); ?></td>
                     <td><?php echo Session::get('currency_symbol').number_format($cotacao->paid_amount_credit,2); ?></td>
                      
                      @php
                        $valorPorPagar=$cotacao->credito;
                        $valor=$cotacao->credito-$cotacao->paid_amount_credit;
                      @endphp
                      <td><?php echo Session::get('currency_symbol').number_format($valor,2); ?></td>
                      
                      @if($cotacao->paid_amount_credit==0)
                         <td><span class="label label-danger">{{ trans('message.invoice.unpaid')}}</span></td>
                      @elseif($cotacao->paid_amount_credit > 0 and $cotacao->paid_amount_credit<$cotacao->credito)
                          <td><span class="label label-warning">{{ trans('message.invoice.partially_paid')}}</span></td>
                      @elseif($cotacao->paid_amount_credit= $cotacao->paid_amount_credit)
                             <td><span class="label label-success">{{ trans('message.invoice.paid')}}</span></td>
                      @endif

                      <td>{{$cotacao->credit_date}}</td>

    <!--removi link editar-->

                    </tr>

                    @endforeach

                 @if($counted_credito >= 1)
                  <tr>
                    <td ></td>
                      <td></td>
                       <td>Total: <?php echo Session::get('currency_symbol').number_format("$Total_por_pagar",2); ?></td>
                       <td >Total: <?php echo Session::get('currency_symbol').number_format("$pago",2); ?></td>
                       <td>Total: <?php echo Session::get('currency_symbol').number_format("$saldo",2); ?></td>
                      <td ></td>
                      <td ></td>
                  </tr>
                  @endif
                 </tbody>


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
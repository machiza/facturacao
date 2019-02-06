@php
$id = $customerData->debtor_no;
@endphp

<?php
require_once './conexao.php';

$sql_debito = "Select * from sales_debito
                inner join sales_orders on sales_debito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where invoice_type_debit = 'directInvoice' and debtor_no_debit = '$id' order by debit_no desc";
$comando_debito = $pdo->prepare($sql_debito);
$comando_debito->execute();

$comando_debito_count = $pdo->prepare("Select sum(debito), sum(paid_amount_debit) from sales_debito where invoice_type_debit = 'directInvoice' and debtor_no_debit = '$id'");
$comando_debito_count->execute();
$rows = $comando_debito_count->rowCount();
$count_debito = $comando_debito_count->fetch();
$counted_debito = $count_debito ["sum(debito)"];


$total_paid_amount = $count_debito ["sum(paid_amount_debit)"];

//total_saldos:
$total_saldos = $counted_debito - $total_paid_amount;

$sql_debito_indirect = "Select * from sales_debito
                inner join sales_orders on sales_debito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where invoice_type_debit = 'indirectOrder' and debtor_no_debit = '$id'";
$comando_debito_indirect = $pdo->prepare($sql_debito_indirect);
$comando_debito_indirect->execute();
$rs = $comando_debito_indirect->fetch();
$order_reference_id_debit = $rs["order_reference_id_debit"];
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

                    <li class="active">
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
                    <th>{{ trans('message.transaction.debit') }}</th>
                    <th>{{ trans('message.table.invoice_no') }}</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                    <th>{{ trans('message.table.paid_status') }}</th>
                    <th>{{ trans('message.table.invoice_date_debit') }}</th>
                    <!--REMOVED by Hugo<th width="10%">{{ trans('message.table.action') }}</th>-->
                  </tr>

                </thead>
                <tbody>
                
               

                 @foreach($debitos as $debito) 
                  <tr>
                    <td>
                      <a href="{{URL::to('/')}}/invoice/view-detail-invoice-debito/{{$debito->debit_no}}">
                        {{$debito->reference_debit}}
                      </a>
                    </td>
                    <td>
                      <a href="{{URL::to('/')}}/invoice/view-detail-invoice/{{$debito->order_reference_id.'/'.$debito->order_no_id}}">
                        {{$debito->reference}}
                      </a>
                    </td>
                  
                    @php
                     $valorPorPagar=$debito->debito;
                      $saldo=$debito->debito-$debito->paid_amount_debit;
                    @endphp
                    <td><?php echo Session::get('currency_symbol').number_format($debito->debito,2); ?></td>
                    <td><?php echo Session::get('currency_symbol').number_format($debito->paid_amount_debit,2); ?></td>
                     <td><?php echo Session::get('currency_symbol').number_format($saldo,2); ?></td>

                    @if($debito->paid_amount_debit == 0)
                       <td><span class="label label-danger">{{trans('message.invoice.unpaid')}}</span></td>
                    @elseif($debito->paid_amount_debit > 0 and $debito->paid_amount_debit < $debito->debito)
                        <td><span class="label label-warning">{{ trans('message.invoice.partially_paid')}}</span></td>
                    @elseif ($debito->paid_amount_debit = $debito->debito)
                           <td><span class="label label-success">{{ trans('message.invoice.paid')}}</span></td>
                    @endif
                    <td>{{$debito->debit_date}}</td>
                  </tr> 
                @endforeach
                


                 @if($counted_debito >= 1)
                  <tr>
                    <td ></td>
                      <td></td>
                       <td>Total: <?php echo Session::get('currency_symbol').number_format("$counted_debito",2); ?></td>

                                          
                    <td >Total: <?php echo Session::get('currency_symbol').number_format("$total_paid_amount",2);?></td>
                    <td >Total: <?php echo Session::get('currency_symbol').number_format("$total_saldos",2);?></td>
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
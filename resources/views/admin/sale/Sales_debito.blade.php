<?php
require_once './conexao.php';

$sql_debito = "Select * from sales_debito
                inner join sales_orders on sales_debito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where invoice_type_debit = 'directInvoice' order by debit_no desc";
$comando_debito = $pdo->prepare($sql_debito);
$comando_debito->execute();

$comando_debito_count = $pdo->prepare("Select sum(debito), sum(paid_amount_debit) from sales_debito where invoice_type_debit = 'directInvoice'");
$comando_debito_count->execute();
$rows = $comando_debito_count->rowCount();
$count_debito = $comando_debito_count->fetch();
$counted_debito = $count_debito ["sum(debito)"];


$total_paid_amount = $count_debito ["sum(paid_amount_debit)"];

//total_saldos:
$total_saldos = $counted_debito - $total_paid_amount;

$sql_debito_indirect = "Select * from sales_debito
                inner join sales_orders on sales_debito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where invoice_type_debit = 'indirectOrder'";
$comando_debito_indirect = $pdo->prepare($sql_debito_indirect);
$comando_debito_indirect->execute();
$rs = $comando_debito_indirect->fetch();
$order_reference_id_debit = $rs["order_reference_id_debit"];
?>

@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">

   <!--cabecalho:-->
    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
           <div class="top-bar-title padding-bottom">{{ trans('message.transaction.debit') }}</div>
          </div> 
          <div class="col-md-2">
            @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
              <a href="{{ url('sales/add_debit') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.transaction.invoice_new_debit') }}</a>
           @endif
          </div>
        </div>
      </div>
    </div>

      <div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("sales/debito")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>
                    
                    <!--<li>
                      <a href="{{url("sales/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
                    </li>-->

               </ul>
        </div>
       
      </div><!--Filtering Box End-->
      
      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <a href="{{ url('debito-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
           </div>

           

            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                     <th>{{ trans('message.table.invoice_dateS') }}</th> 
                    <th>{{ trans('message.table.invoice_debit_no') }}</th>
                    <th>{{ trans('message.table.invoice_no') }}</th>
                    <th>{{ trans('message.table.customer_name') }}</th>
                   <!-- <th>{{ trans('message.table.price') }}</th>-->
                    <th>{{ trans('message.transaction.debit') }}</th>

                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                    <th>{{ trans('message.table.paid_status') }}</th>
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                    <th>{{ trans('message.table.action') }}</th>
                     @endif 
                   <!--REMOVI acao actualizar-->
                  </tr>
                  </thead>
                  <tbody>

                   @foreach($debitos as $debito) 
                  <tr>
                    <td>{{$debito->debit_date}}</td>
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
                  <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{url("customer/edit/$debito->debtor_no_debit")}}">{{$debito->name}}</a>
                    @else
                    {{$debito->name}}
                    @endif
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

                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                        <td>
                            <form method="POST" action="{{ url("sales/debit-delete/$debito->debit_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                                <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.transaction.debit') }}" data-message="{{ trans('message.table.debit_info') }}">
                                <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>
                            </form> 
                            <a title="edit" class="btn btn-xs btn-primary"  href="{{url("sales/debit/$debito->debit_no/edit")}}"><span class="fa fa-edit"></span></a>

                          </td> 
                    @endif
                    
                  </tr> 
                @endforeach
                


                 @if($counted_debito >= 1)
                  <tr>
                    <td ></td>
                      <td></td>
                       
                       <td><strong>Total: <?php echo Session::get('currency_symbol').number_format("$counted_debito",2); ?></strong></td>

                                          
                    <td><strong>Total: <?php echo Session::get('currency_symbol').number_format("$total_paid_amount",2);?></strong></td>

                    <td ><strong>Total:<?php echo Session::get('currency_symbol').number_format("$total_saldos",2);?></strong></td>
                      <td ></td>
                      <td></td>
                      <td ></td>
                      <td ></td>
                  </tr>
                  @endif
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
        "targets": 6,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection
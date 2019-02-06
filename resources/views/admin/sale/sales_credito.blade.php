<?php
require_once './conexao.php';


  $sql_credito = "Select * from sales_credito
               LEFT OUTER join sales_orders on sales_credito.order_no_id=sales_orders.order_no
                LEFT OUTER join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no order by credit_no desc";      

$comando_credito = $pdo->prepare($sql_credito);
$comando_credito->execute();


$comando_credito_count = $pdo->prepare("Select sum(credito), sum(paid_amount_credit) from sales_credito
  inner join sales_orders on sales_credito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where invoice_type = 'directInvoice'");
 $comando_credito_count->execute();
$rows = $comando_credito_count->rowCount();
 $count_credito = $comando_credito_count->fetch();
$counted_total_paid = $count_credito ["sum(paid_amount_credit)"];
$counted_credito = $count_credito ["sum(credito)"];
$counted_saldo = $counted_credito - $counted_total_paid;


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
           <div class="top-bar-title padding-bottom">{{ trans('message.transaction.credit') }}</div>
          </div> 
          <div class="col-md-2">
            @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
              <a href="{{ url('sales/add_credit') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.transaction.invoice_new_credit') }}</a>
           @endif
          </div>
        </div>
      </div>
    </div>

      <div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("sales/credito")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>
               

               </ul>
        </div>
       
      </div><!--Filtering Box End-->
      
      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->

             <div class="box-header">
              <a href="{{ url('credito-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
           </div>


            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.invoice.invoice_date_credit') }}</th>
                    <th>{{ trans('message.table.invoice_credit_no') }}</th>
                    <th>{{ trans('message.table.invoice_no') }}</th>
                    <th>{{ trans('message.table.customer_name') }}</th>
                   <!-- <th>{{ trans('message.table.price') }}</th>-->
                    <th>{{ trans('message.table.credit') }}</th>

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
                    @foreach ($cotacoes as $cotacao)
                       <tr>
                       <td>{{$cotacao->credit_date}}</td>
                      <td>
                        <a href="{{URL::to('/')}}/invoice/view-detail-invoice-credito/{{$cotacao->credit_no}}">
                        {{$cotacao->reference_credit}}</a>
                      </td>
                      <td>
                        <a href="{{URL::to('/')}}/invoice/view-detail-invoice/{{$cotacao->order_reference_id.'/'.$cotacao->order_no_id}}">{{$cotacao->reference}}</a>
                      </td>

                    <td>
                      @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                      <a href="{{url("customer/edit/$cotacao->debtor_no_credit")}}">{{$cotacao->name}}</a>
                      @else
                      {{$cotacao->name}}
                      @endif
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

                       @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                        <td>
                            <form method="POST" action="{{ url("sales/credit-delete/$cotacao->credit_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                                <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.transaction.credit') }}" data-message="{{ trans('message.table.credit_info') }}">
                                <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>
                            </form> 
                              <a title="edit" class="btn btn-xs btn-primary"  href="{{url("sales/credit/$cotacao->credit_no")}}"><span class="fa fa-edit"></span></a>
                        </td> 
                      @endif

    <!--removi link editar-->

                    </tr>

                    @endforeach

                 @if($counted_credito >= 1)
                  <tr>
                    <td ></td>
                      <td></td>
                       <td></td>
                       <td><strong>Total: <?php echo Session::get('currency_symbol').number_format("$Total_por_pagar",2); ?></strong></td>
                       <td ><strong>Total: <?php echo Session::get('currency_symbol').number_format("$pago",2); ?></strong></td>
                       <td><strong>Total: : <?php echo Session::get('currency_symbol').number_format("$saldo",2); ?></td>
                      <td ><strong>
                      </td>
                      <td ></td>
                      @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                        <td></td>
                      @endif  
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
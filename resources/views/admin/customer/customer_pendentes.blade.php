@php
$id = $customerData->debtor_no;
@endphp

<?php
require_once './conexao.php';

$sql_docs = "select * from sales_pending where debtor_no_pending = '$id'" ;
$comando_docs = $pdo->prepare($sql_docs);
$comando_docs->execute();

$sql_sum = "select *, sum(amount_doc), sum(amount_credito_doc),sum(saldo_doc) from sales_cc
where debtor_no_doc = '$id'";
$comando_sum = $pdo->prepare($sql_sum);
$comando_sum->execute();
$rs_sum = $comando_sum->fetch();
$amount_doc = $rs_sum ['sum(amount_doc)'];
$amount_cred = $rs_sum ['sum(amount_credito_doc)'];
$amount_saldo = $rs_sum ['sum(saldo_doc)'];

$sql_rows = "select *, sum(amount_total_pending) from sales_pending where debtor_no_pending = '$id'";

$comando_rows = $pdo->prepare($sql_rows);
$comando_rows->execute();
$rs_rows = $comando_rows->rowCount();
$rs_row_data = $comando_rows->fetch();



//SALDO TOTAL:
$sql_saldo = "select *, sales_orders.debtor_no,sum(total), sum(paid_amount) from debtors_master
              inner join sales_orders on debtors_master.debtor_no=sales_orders.debtor_no
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo = $pdo->prepare($sql_saldo);
$comando_saldo->execute();
$resultado_saldo = $comando_saldo->fetch();
$total_facturas = $resultado_saldo ["sum(total)"];
$saldo_paid= $resultado_saldo ["sum(paid_amount)"];
$total_saldos = 0;
$saldo  = $total_facturas - $saldo_paid;
$ordem = $resultado_saldo["debtor_no"];

$sql_saldo_debit = "select *, sales_debito.debtor_no_debit, sum(debito),sum(paid_amount_debit)
              from debtors_master
              inner join sales_debito on debtors_master.debtor_no=sales_debito.debtor_no_debit
              where sales_debito.debtor_no_debit = '$id' AND invoice_type_debit='directInvoice'";
$comando_saldo_debit = $pdo->prepare($sql_saldo_debit);
$comando_saldo_debit->execute();

$resultado_saldo_debit = $comando_saldo_debit->fetch();
$counted_debito = $resultado_saldo_debit ["sum(debito)"];
$saldo_debit_paid = $resultado_saldo_debit ["sum(paid_amount_debit)"];
//total_saldos:
$saldo_debit = $counted_debito - $saldo_debit_paid;


$sql_saldo_credit = "select *, sum(credito), sum(paid_amount_credit) from sales_orders
              inner join sales_credito on sales_orders.order_no=sales_credito.order_no_id
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo_credit = $pdo->prepare($sql_saldo_credit);
$comando_saldo_credit->execute();
$resultado_saldo_credit = $comando_saldo_credit->fetch();
$saldo_credit = $resultado_saldo_credit ["sum(credito)"] - $resultado_saldo_credit ["paid_amount_credit"] ;
$saldo_credit_paid = $resultado_saldo_credit ["sum(paid_amount_credit)"];//pago


$paid_total = number_format($saldo_paid + $saldo_debit_paid + $saldo_credit_paid,2);
//Saldo total (fact e debts):
$saldo_total = $rs_row_data["sum(amount_total_pending)"] - $saldo_paid;
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

                    <li class="active">
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

          <div class="btn-group pull-right">
            <!--btn chamar pfd-->
            <?php if($rs_rows >= 1){?>
              <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-contacorrente-pendente/{{$ordem}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
            <?php }?>
          </div><br><br>

              <table id="example1" class="table table-bordered table-striped">
                <thead>

                  <tr>
                    <th>{{ trans('message.accounting.data') }}</th>
                    <th>{{ trans('message.accounting.docs') }}</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                  </tr>

                </thead>
                <tbody>

               
                 

                  @foreach($Pendentes as $dado)

                    @if($dado->status!='cancelado')
                    <tr>
                         @php
                        $pago=$dado->amount_doc-$dado->saldo_doc;
                        @endphp
                        <td>{{$dado->ord_date_doc}}</td>                  
                        <td>{{$dado->reference_doc}}</td>                  
                        <td>{{$dado->amount_doc}}</td>  
                        <td>{{$pago}}</td>                  
                        <td>{{$dado->saldo_doc}}</td>                  
                    </tr> 
                    @endif
                @endforeach
                  <tr>
                        <td></td>                  
                        <td></td>                  
                        <td></td>                   
                        <td><strong>Total:</strong></td>                  
                       <td>
                          <strong>{{Session::get('currency_symbol').number_format("$saldoCustomer",2)}}</strong>
                        </td>                  
                    </tr> 
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
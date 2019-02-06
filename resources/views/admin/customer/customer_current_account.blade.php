@php
$id = $customerData->debtor_no;
@endphp
<?php
require_once './conexao.php';

$sql_docs = "SELECT idcc, ord_date_doc, reference_doc, amount_doc, amount_credito_doc, saldo as saldo
FROM (
    SELECT
        idcc,
        ord_date_doc,
        reference_doc,
        amount_doc,
        amount_credito_doc,

    @debito_credito := debito_credito AS tipo,
        @saldo := IF(@debito_credito = 0, @saldo + amount_doc, @saldo - amount_credito_doc) AS saldo
    FROM sales_cc, (SELECT @debito_credito := 0, @saldo := 0) as vars
    where debtor_no_doc = '$id' ORDER BY idcc
) AS extrato";
$comando_docs = $pdo->prepare($sql_docs);
$comando_docs->execute();

//soma debito:
$sql_sum = "select *, sum(amount_doc), sum(amount_credito_doc),sum(saldo_doc) from sales_cc
where debtor_no_doc = '$id'";
$comando_sum = $pdo->prepare($sql_sum);
$comando_sum->execute();
$rs_sum = $comando_sum->fetch();
$amount_doc = $rs_sum ['sum(amount_doc)'];
$amount_cred = $rs_sum ['sum(amount_credito_doc)'];

$sql_rows = "select * from sales_cc where debtor_no_doc = '$id'";
$comando_rows = $pdo->prepare($sql_rows);
$comando_rows->execute();
$rs_rows = $comando_rows->rowCount();



//SALDO TOTAL:
/*facturas*/
$sql_saldo = "select *, sales_orders.debtor_no,sum(total), sum(paid_amount) from debtors_master
              inner join sales_orders on debtors_master.debtor_no=sales_orders.debtor_no
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo = $pdo->prepare($sql_saldo);
$comando_saldo->execute();
$resultado_saldo = $comando_saldo->fetch();
$total_facturas = $resultado_saldo ["sum(total)"];
$total_paid_amount= $resultado_saldo ["sum(paid_amount)"];
$total_saldos = 0;
$total_saldos = $total_facturas - $total_paid_amount;
$ordem = $resultado_saldo["debtor_no"];

$saldo_total = number_format($amount_doc - $amount_cred,2);
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

                    <li class="active">
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

          <div class="btn-group pull-right">
            <!--btn chamar pfd-->
            <?php if($rs_rows >= 1){?>
              <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-contacorrente/{{$ordem}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
            <?php }?>
          </div><br><br>

              {{--<table id="example1" class="table table-bordered table-striped">--}}
              <table id="example1" class="table table-hover">
                <thead>

                  <tr>
                    <th>{{ trans('message.accounting.data') }}</th>
                    <th>{{ trans('message.accounting.docs') }}</th>
                    <!--<th>{{ trans('message.accounting.invoice_price') }}</th>-->
                    <th>{{ trans('message.accounting.debits') }}</th>
                    <!--<th>{{ trans('message.table.sub_total') }}</th>-->
                    <th>{{ trans('message.accounting.credits') }}</th>
                    <!--<th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>-->
                    <th>{{ trans('message.table.balance_amount') }}</th>
                  </tr>

                </thead>
                <tbody>
                @php
                $saldo=0;
                $DebitoTotal=0;
                $CreditoTotal=0;

                @endphp

                 @foreach($correntes as $dados)
                  @php
                    $linha=explode('-',$dados->reference_doc);

                  @endphp
                
                @if($linha[0]=='NC')
                <tr >
                @else      
                <tr>
                @endif  

                   @if($linha[0]=='NC') 
                    <td  style="color:red" >
                      {{$dados->ord_date_doc}}
                    </td>
                    @else      
                  <td> {{$dados->ord_date_doc}}</td>
                  @endif
                    
                    <!--documento-->
                    @if($linha[0]=='NC') 
                    <td style="color:red" >
                      {{$dados->reference_doc}}
                    </td>
                    @else  
                    <td> {{$dados->reference_doc}}</td>

                    @endif

                    <!--amount doc-->
                    <td>
                          
                          
                          @if($dados->debito_credito!=0 and $dados->amount_doc>0)

                          @php
                          $saldo=$saldo+$dados->amount_doc;
                          $DebitoTotal=$DebitoTotal+$dados->amount_doc;  
                          @endphp

                         {{Session::get('currency_symbol').number_format($dados->amount_doc,2)}}
                          @endif
                          
                         

                    </td>

                    <!--credito-->
                    <td>
                      
                      @if($dados->amount_credito_doc !=0)

                        @php
                          $saldo=$saldo-$dados->amount_credito_doc;
                          $CreditoTotal=$CreditoTotal+$dados->amount_credito_doc;
                        @endphp
                            @if($linha[0]=='NC')
                           <div style="color:red">  
                          {{Session::get('currency_symbol').number_format($dados->amount_credito_doc,2)}}
                           </div> 
                           @else  
                            {{Session::get('currency_symbol').number_format($dados->amount_credito_doc,2)}}
                            @endif
                      @endif

                    </td>

                    <td>{{Session::get('currency_symbol').number_format($saldo,2)}}</td>
                  </tr>      
            @endforeach

                  <tr>
                    <td></td>
                    <td><strong>Totais:</strong> </td>
                    <td><strong>{{Session::get('currency_symbol').number_format($DebitoTotal,2)}}</strong></td>

                    <td>
                      <strong>
                         @if($CreditoTotal > 0)
                           {{Session::get('currency_symbol').number_format($CreditoTotal,2)}}
                        @else
                           {{$CreditoTotal}}
                        @endif
                      </strong>
                    </td>

                    <td>
                      <strong>
                        {{Session::get('currency_symbol').number_format($saldo,2)}}
                    </strong>
                  </td>
                  </tr>
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
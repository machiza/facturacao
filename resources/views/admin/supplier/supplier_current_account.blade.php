@php
$id = $supplierData->supplier_id;
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
    FROM purch_cc, (SELECT @debito_credito := 0, @saldo := 0) as vars
    where supp_id_doc = '$id' ORDER BY idcc
) AS extrato";
$comando_docs = $pdo->prepare($sql_docs);
$comando_docs->execute();


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

                    <li class="active">
                      <a href="{{url("supplier/current_account/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.current_account') }}</a>
                    </li>

                    <li>
                      <a href="{{url("supplier/pendentes/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.pendentes') }}</a>
                    </li>

                    <li>
                      <a href="{{url("supplier/payment_list/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>
               </ul>
              <div class="clearfix"></div>
           </div>
        </div>
        <h3>{{$supplierData->supp_name}}</h3>  

    <div class="box">
      <!-- /.box-header -->
        <div class="box-body">

          <div class="btn-group pull-right">
            <!--btn chamar pfd-->
             @if(count($purchData) >= 1)
              <a target="_blank" href="{{URL::to('/')}}/supplier/pdf-contacorrente-pdf/{{$supplierData->supplier_id}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
            @endif
          </div><br><br>

              <table id="example1" class="table table-bordered table-striped">
                <thead>

                  <tr>
                    <th>{{ trans('message.accounting.data') }}</th>
                    <th>{{ trans('message.accounting.docs') }}</th>
                    <th>{{ trans('message.accounting.debits') }}</th>
                    <th>{{ trans('message.accounting.credits') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                  </tr>

                </thead>
                <tbody>
                <?php while($rs_docs = $comando_docs->fetch(PDO::FETCH_ASSOC)){
                	//$order_no = $rs_docs ['order_no_doc']; ?>                 
                  <tr>
                    <!--data-->
                    <td><?php echo $rs_docs ['ord_date_doc']?></td>

                    <!--documento-->
                    <td>
                    	    <?php echo $rs_docs ['reference_doc']?>
                    </td>

                    <!--amount doc-->
                    <td><?php if($rs_docs["amount_doc"] > 0){
                      echo Session::get('currency_symbol').number_format($rs_docs["amount_doc"],2);
                    }else{
                      echo $rs_docs["amount_doc"];
                    }?>
                    </td>

                    <!--credito-->
                    <td><?php if($rs_docs["amount_credito_doc"] > 0){
                      echo Session::get('currency_symbol').number_format($rs_docs["amount_credito_doc"],2);
                    }else{
                      echo $rs_docs["amount_credito_doc"];
                    }?>
                    </td>

                    <td><?php echo Session::get('currency_symbol').number_format($rs_docs["saldo"],2);?></td>
                  </tr>               
                <?php }?>
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
          "targets": 4,
          "orderable": false
          } ],

          "language": '{{Session::get('dflt_lang')}}',
          "pageLength": '{{Session::get('row_per_page')}}'
      });
      
    });

    </script>
@endsection
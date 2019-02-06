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
        <div class="panel-body">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group" style="margin-right: 5px">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="from" type="text" name="from" value="{{$from}}" required>
                  </div>
                </div>
              </div> 
  
  
              <div class="col-md-2">
                <div class="form-group" style="margin-right: 5px">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="dataFim" name="dataFim" value="{{$to}}" required>
                  </div>
                </div>
              </div>
  
              <div class="col-md-2">
                <div class="form-group" style="margin-right: 5px">
                  <label for="">.</label>
                  <div class="input-group">
                      <button type="submit" id="Rfiltro" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
                  </div>
                </div>
              </div> 
              
            </div>  
          </div>
        </div>
      </div>

    <div class="box">
      <!-- /.box-header -->
        <div class="box-body">

          <div class="btn-group pull-right">
            <!--btn chamar pfd-->
            <input type="hidden" id="ordem" value="{{ $ordem }}">
            <?php if($rs_rows >= 1){?>
              <a id="report" target="_blank" href="{{URL::to('/')}}/invoice/pdf-contacorrente/{{$ordem}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
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
                    </tr>
                      <td class="{{ $dados->ord_date_doc }}" >
                        {{ formatDate($dados->ord_date_doc) }}
                      </td>
                      <td>
                        {{$dados->reference_doc}}
                      </td>
                        <!--amount doc-->
                        <td>
                          {{-- @if($dados->debito_credito!=0 and $dados->amount_doc>0) --}}
                          @if($dados->amount_doc>0)
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
                              <div>  
                                {{Session::get('currency_symbol').number_format($dados->amount_credito_doc,2)}}
                              </div> 
                          @endif
                        </td>
                        <td>{{Session::get('currency_symbol').number_format($saldo,2)}}</td>
                    </tr>      
                  @endforeach
                    <tr>
                      <td></td>
                      <td><strong>Totais:</strong> </td>
                      <td style="font-weight:bold"><strong>{{Session::get('currency_symbol').number_format($DebitoTotal,2)}}</strong></td>
                      <td style="font-weight:bold">
                        <strong>
                          @if($CreditoTotal > 0)
                            {{Session::get('currency_symbol').number_format($CreditoTotal,2)}}
                          @else
                            {{$CreditoTotal}}
                          @endif
                        </strong>
                      </td>
                      <td style="font-weight:bold">
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

    $('.select2').select2({});
      $('#from').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: '{{Session::get('date_format_type')}}'
      });

      $('#dataFim').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: '{{Session::get('date_format_type')}}'
      });

      $('#Rfiltro').click(function() {
  
        var dataIni, dataFim, clienteId, cliente, table, tr, tdData, tdCliente, i, ordemId;

        dataIni  = $('#from').val();
        dataFim = $('#dataFim').val();
        clienteId  = $('#customer').val() != 'all' ? $('#customer').val() : 'all';
        cliente = $('#customer option:selected').text();
        table = $('#example1');
        tr = table.find("tr");
        ordemId = $('#ordem').val();

        dataIniISO = dataIni.split("/");
        dataFimISO = dataFim.split("/");

        var di = dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0];
        var df = dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0];

        baseUrl = $('#baseUrl').val();

        $("#report").attr("href", SITE_URL+"/invoice/pdf-contacorrente/"+ordemId+"/"+di+"/"+df);
        var saldo = 0;
        var debito = 0;
        var credito = 0;
        for (i = 0; i < tr.length; i++) {
          tdData = tr[i].getElementsByTagName("td")[0];
          

          // if (tdDebito != null) {
          //   console.log(tdDebito.innerText);
          // }

          if (tdData) {
            txtValue = new Date(tdData.className);

            fDate = new Date(dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0]);   
            lDate = new Date(dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0]);  
            cDate =  new Date(tdData.className+"");
          
            if(cDate >= fDate && cDate <= lDate) {
              tdDebito = tr[i].getElementsByTagName("td")[2];
              tdCredito = tr[i].getElementsByTagName("td")[3];
              tdSaldo = tr[i].getElementsByTagName("td")[4];

              debito += Number(tdDebito.innerText.replace(",", ""));
              credito += Number(tdCredito.innerText.replace(",", ""));
              saldo += (Number(tdDebito.innerText.replace(",", "")) - Number(tdCredito.innerText.replace(",", "")));
              tr[i].style.display = "";
            } else {
              if (isNaN(cDate.getTime())) {
                tdDebito = tr[i].getElementsByTagName("td")[2];
                tdCredito = tr[i].getElementsByTagName("td")[3];
                tdSaldo = tr[i].getElementsByTagName("td")[4];
                
                tdDebito.innerText = debito.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                tdCredito.innerText = credito.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                tdSaldo.innerText = saldo.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
              
            }
            
          }
        }
      });

      const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
      })

      function numeroParaMoeda(n, c, d, t) {
        c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
      }
      
    // });

  </script>
@endsection
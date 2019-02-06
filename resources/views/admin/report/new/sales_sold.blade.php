@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-body">
          <div class="col-md-7 col-xs-12">
              <div class="row">
            <form class="form-horizontal" action="#" method="GET" id='salesHistoryReport'>
              {{-- url('report/inventory-sold') --}}
              <div class="col-md-4">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control" id="from" type="text" name="from" value="<?= isset($from) ? $from : '' ?>" required>
                  </div>
              </div>
              <div class="col-md-4">
                  <label for="exampleInputEmail1">{{ trans('message.report.to') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="to" type="text" name="to" value="<?= isset($to) ? $to : '' ?>" required>
                  </div>
              </div>

              <div class="col-md-1">
                <label for="btn">&nbsp;</label>
                <button type="submit" name="btn" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
              </div>
            </form>
          </div>
          </div>
          <div class="col-md-5 col-xs-12">
            <br>
            <div class="btn-group pull-right">
              <a href="#" title="CSV" class="btn btn-default btn-flat" id="csv">{{ trans('message.extra_text.excel') }}</a>
              <a href="{{url("report/inventory-sold/new/pdf")}}" target="_blank" title="PDF" class="btn btn-default btn-flat" id="pdf">{{ trans('message.extra_text.pdf') }}</a>
            </div>
        </div>
        </div>
        <br>
      </div><!--Top Box End-->


   
      <div class="box">
        <div class="box-body">
          <div class="col-md-2 col-xs-6 border-right text-center">
              <h3 class="bold">{{ number_format($Quantity,2,'.',',')}}</h3>
              <span class="text-info">{{ trans('message.extra_text.quantity') }}</span>
          </div>
          <div class="col-md-3 col-xs-6 border-right text-center">
              <h3 class="bold">{{ Session::get('currency_symbol').number_format($venda ,2,'.',',')}}</h3>
              <span class="text-info">{{ trans('message.report.sales_value') }} </span>
          </div>
          <div class="col-md-3 col-xs-6 border-right text-center">
              <h3 class="bold">{{Session::get('currency_symbol').number_format($custo,2,'.',',')}}</h3>
              <span class="text-info">{{ trans('message.report.cost') }}</span>
          </div>
          {{--
          <div class="col-md-2 col-xs-6 border-right text-center">
              <h3 class="bold">{{number_format(0,2,'.',',')}}</h3>
              <span class="text-info">{{ trans('message.report.tax') }}</span>
          </div>
          --}}

          <div class="col-md-2 col-xs-6 text-center">
              <h3 class="bold">
              
          </div> 
        </div>
      </div>
      
      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="salesList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">{{ trans('message.report.date') }}</th>
                  <th class="text-center">Descricao</th>
                  <th class="text-center">Preco Unitario</th>
                  <th class="text-center">{{ trans('message.extra_text.quantity') }}</th>
                  <th class="text-center">{{ trans('message.report.sales_value') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.cost') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.tax') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.profit') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.profit_margin') }}(%)</th>
                </tr>
                </thead>
                <tbody>
                @php
                  $qty = 0;
                  $sales_price = 0;
                  $purchase_price = 0;
                  $tax = 0;
                  $total_profit = 0;
                  $proveito = 0;
                  $custo= 0;
                  $lucro= 0;

                @endphp   
             
                @foreach ($itemList as $item)

                
                  @php 
                      $proveito=$item->quantidade*$item->price;
                      $custo=$item->quantidade*$item->cost_price;
                      $lucro=$proveito-$custo;
                      if($custo==0){
                        $lucropercegem=100;
                      }else{
                       $lucropercegem=($lucro*100)/$custo;
                    }
                  @endphp
               <tr>
                  <td class="text-center">{{ formatDate($item->created_at) }}</td>
                  <td class="text-center">{{ $item->description}}</td>
                  <td class="text-center">{{ number_format(($item->price),2,'.',',') }}</td>
                  <td class="text-center">{{ $item->quantidade }}</td>
                  <td class="text-center">{{ number_format(($proveito),2,'.',',') }}</td>
                  <td class="text-center">{{ number_format(($custo),2,'.',',') }}</td>
                  <td class="text-center">{{ number_format((0),2,'.',',') }}</td>

                  <td class="text-center">{{ number_format(($lucro),2,'.',',') }}</td>
                  <td class="text-center">{{ number_format(($lucropercegem),2,'.',',') }}%</td>
                </tr>
               @endforeach
                </tfoot>
              </table>
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
    $("#salesList").DataTable({
      "order": [],

      "columnDefs": [ {
        "targets": 6,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  $(".select2").select2({});
    
    $('#from').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
    //$('#from').datepicker('update', new Date());

    $('#to').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
    //$('#to').datepicker('update', new Date());

  });

// Item form validation
    $('#salesHistoryReports').validate({
        rules: {
            from: {
                required: true
            },
            to: {
                required: true
            }                  
        }
    });

   $('#pdf').on('click', function(event){
      event.preventDefault();
      var to = $('#to').val();
      var from = $('#from').val();
      //var customer = $("#customer").val();
    //  window.location = SITE_URL+"/dashboard";
      window.open(SITE_URL+"/report/inventory/sold/"+from+"/"+to);
    });


    $("#gerar").on('click', function(e) {
    e.preventDefault();
     
      if($("#customer").val()!="all"){
        var SITE_URL= $('#envio_fuel').val();
       /* $inicio=$("#from").val();
        $fim=$("#to").val();
        $customer=$("#customer").val();
      */
        window.open(SITE_URL+'/dashboard');
      //  window.open(SITE_URL+'/reportt/emitidas/senhas/'+$inicio+'/'+$fim+'/'+$customer);
     }
  });





   $('#csv').on('click', function(event){
      event.preventDefault();
      var to = $('#to').val();
      var from = $('#from').val();
      var customer = $("#customer").val();
      window.location = SITE_URL+"/report/sales-history-report-csv?to="+to+"&from="+from+"&customer="+customer;
    });

    </script>
@endsection
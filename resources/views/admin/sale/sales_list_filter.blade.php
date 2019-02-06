@extends('layouts.app')
@section('content')
  <!-- Main content -->
  <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
            <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.invoices') }}</div>
          </div> 
          <div class="col-md-2">
            @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
              <a href="{{ url('sales/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_invoice') }}</a>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <div class="box-body">

        {{-- <ul class="nav nav-tabs cus" role="tablist">
          <li>
            <a href='{{url("sales/list")}}' >{{ trans('message.extra_text.all') }}</a>
          </li>
          <li class="active">
            <a href="{{url("sales/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
          </li>
        </ul> --}}

        {{-- <form class="form-horizontal" action="{{ url('sales/filtering') }}" method="GET" id='orderListFilter'> --}}
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
                  <label for="sel1">{{ trans('message.form.customer') }}</label>
                  <div class="input-group">
                    <select class="form-control select2" name="customer" id="customer">
                      <option value="">All</option>
                      @if(!empty($customerList))
                        @foreach($customerList as $customerItem)
                          <option value="{{$customerItem->debtor_no}}" <?= ($customerItem->debtor_no == $customer) ? 'selected' : ''?>>{{$customerItem->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group" style="margin-right: 5px">
                  <label for="location">{{ trans('message.form.location') }}</label>
                  <div class="input-group">
                    <button type="submit" name="btn" id="Rfiltro" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
                  </div>
                </div>
              </div>
            </div>
           
            <div class="row">
                {{-- <div class="col-md-1">
                  <div class="form-group">
                    <div class="input-group">
                      <button type="submit" name="btn" id="Rfiltro" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
                    </div>
                  </div>
                </div> --}}
            
        {{-- </form> --}}

        {{-- <form class="form-horizontal" action="{{ url('sales/filtering') }}" method="GET" id='Rfiltro'> --}}
        
          <input type="hidden" class="form-control" id="Rfrom" type="text" name="Rfrom" value="" >
          <input type="hidden" class="form-control" id="Rto" type="text" name="Rto" value="">
          <input type="hidden" class="form-control" id="Rcustomer" type="text" name="Rcustomer" value="">
          <input type="hidden" class="form-control" id="Rlocation" type="text" name="Rlocation" value="">


          <div class="col-md-1">
            <div class="form-group">
              <div class="input-group">
                <a id="report" target="_blank" href="{{ url('sales-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
              </div>
            </div>
          </div> 
        {{-- </form>      --}}
      </div>
         

    </div>
        
    </div><!--Filtering Box End-->
      <!-- Default box -->
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>{{ trans('message.invoice.invoice_date') }}</th>
                  <th>{{ trans('message.table.invoice_no') }}</th>
                  <th>{{ trans('message.table.customer_name') }}</th>
                  <th>{{ trans('message.table.total_price') }}</th>
                  <th>{{ trans('message.table.paid_amount') }}</th>
                  <th>{{ trans('message.table.paid_status') }}</th>
                  <th width="9%">{{ trans('message.table.action') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($salesData as $data)
                  <tr>
                    <td class="{{ $data->ord_date }}">{{ formatDate($data->ord_date) }}</td>
                    <td><a href="{{URL::to('/')}}/invoice/view-detail-invoice/{{$data->order_reference_id.'/'.$data->order_no}}">{{$data->reference }}</a></td>
                    <td class="cliente">
                      @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                        <a href="{{url("customer/edit/$data->debtor_no")}}">{{ $data->cus_name }}</a>
                      @else
                        {{ $data->cus_name }}
                      @endif
                    </td>
                    <td>{{ Session::get('currency_symbol').number_format($data->total,2,'.',',') }}</td>
                    <td >{{ Session::get('currency_symbol').number_format($data->paid_amount,2,'.',',') }}</td>
                      @if($data->paid_amount == 0)
                        <td><span class="label label-danger">{{ trans('message.invoice.unpaid')}}</span></td>
                      @elseif($data->paid_amount > 0 && $data->total > $data->paid_amount )
                        <td><span class="label label-warning">{{ trans('message.invoice.partially_paid')}}</span></td>
                      @elseif($data->paid_amount<=$data->paid_amount)
                        <td><span class="label label-success">{{ trans('message.invoice.paid')}}</span></td>
                      @endif
                    <td>
                      @if(Helpers::has_permission(Auth::user()->id, 'edit_invoice'))
                        <a  title="edit" class="btn btn-xs btn-primary" href='{{ url("sales/edit/$data->order_no") }}'><span class="fa fa-edit"></span></a> &nbsp;
                      @endif
                      @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                        <form method="POST" action="{{ url("invoice/delete/$data->order_no") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_invoice') }}" data-message="{{ trans('message.invoice.delete_invoice_confirm') }}">
                              <i class="fa fa-remove" aria-hidden="true"></i>
                          </button>
                        </form> 
                      @endif
                    </td>
                  </tr>
                @endforeach
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

    $('#fromISO').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
    });

    $('#dataFimISO').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
    });

    // $("#to").datepicker( "setDate" , new Date() );
    
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
    /*
    
    Rto
    Rcustomer
    Rlocation
    */
    

$('#Rfiltro').click(function() {
  
  var dataIni, dataFim, clienteId, cliente, table, tr, tdData, tdCliente, i;

  dataIni  = $('#from').val();
  dataFim = $('#dataFim').val();
  clienteId  = $('#customer').val();
  cliente = $('#customer option:selected').text();
  table = $('#example1');
  tr = table.find("tr");

  baseUrl = $('#baseUrl').val();

  $("#report").attr("href", SITE_URL+"/sales-report/"+dataIni+"/"+dataFim+"/"+clienteId);

  dataIniISO = dataIni.split("-");
  dataFimISO = dataFim.split("-");
  
  for (i = 0; i < tr.length; i++) {
    tdData = tr[i].getElementsByTagName("td")[0];
    clienteNome = tr[i].getElementsByTagName("td")[2]; 
    if(cliente != "All") {
      // console.log(clienteNome);
      if (tdData) {
        txtValue = clienteNome.textContent || clienteNome.innerText;

        fDate = new Date(dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0]);   
        lDate = new Date(dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0]);  
        cDate =  new Date(tdData.className+"");
      
        if(cDate >= fDate && cDate <= lDate && txtValue.trim() == cliente) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
        
      }
    } else {
      if (tdData) {
        txtValue = new Date(tdData.className);

        fDate = new Date(dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0]);   
        lDate = new Date(dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0]);  
        cDate =  new Date(tdData.className+"");
      
        if(cDate >= fDate && cDate <= lDate) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
        
      }
    }
    
  }


});

    </script>
@endsection
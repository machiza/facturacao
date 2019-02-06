@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.sales_orders') }}</div>
          </div> 
          <div class="col-md-2">
            @if(Helpers::has_permission(Auth::user()->id, 'add_quotation'))
              <a href="{{ url('order/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.accounting.add_new_quotation') }}</a>
            @endif
           
          </div>
        </div>
      </div>
    </div>
      <div class="box">
        <div class="box-body">

                {{-- <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li>
                      <a href='{{url("order/list")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>
                    
                    <li class="active">
                      <a href="{{url("order/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
                    </li>

               </ul> --}}

          {{-- <form class="form-horizontal" action="{{ url('order/filtering') }}" method="GET" id='orderListFilter'> --}}
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
                  <label for="exampleInputEmail1">{{ trans('message.report.to') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="dataFim" type="text" name="dataFim" value="{{$to}}" required>
                  </div>
                  </div>
               </div> 

               <div class="col-md-2">
                 <div class="form-group" style="margin-right: 5px">
                  <label for="sel1">{{ trans('message.form.customer') }}</label>
                  <div class="input-group">
                  <select class="form-control select2" name="customer" id="customer">
                    <option value="all">All</option>
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
                  <label for="">.</label>
                  <div class="input-group">
                      <button type="submit" id="Rfiltro" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
                  </div>
                </div>
              </div> 

            </div>
           
            <div class="row">
              <div class="col-md-1">
                <div class="form-group">
                  <div class="input-group">
                    <a id="report" target="_blank" href="{{ url('sales_orders-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
                  </div>
                </div>
              </div> 
            </div>
          </div>
          {{-- </form> --}}
        </div>
      </div><!--Filtering Box End-->


      <div class="box">
        <div class="box-body">
          
              <div class="table-responsive">
                <table id="orderList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.table.ord_date') }}</th>
                    <th>{{ trans('message.accounting.quotation_no') }}</th>
                    <th>{{ trans('message.table.customer_name') }}</th>
                    {{-- <th>{{ trans('message.extra_text.quantity') }}</th> --}}
                    <th>{{ trans('message.table.total') }}</th>
                    <th width="8%">{{ trans('message.table.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($orderData as $data)
                 
                  <tr>
                    <td class="{{ $data->ord_date }}">{{formatDate($data->ord_date)}}</td>
                    <td><a href="{{URL::to('/')}}/order/view-order-details/{{$data->order_no}}">{{$data->reference }}</a></td>
                    <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{URL::to('/')}}/customer/edit/{{$data->debtor_no}}">{{ $data->name }}</a>
                    @else
                    {{ $data->name }}
                    @endif
                    </td>
                    {{-- <td>{{ $data->qty }}</td> --}}

                    <td>{{ Session::get('currency_symbol').number_format($data->order_amount,2,'.',',') }}</td>
                    
                    <td>
                    
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_quotation'))
                        <a  title="Edit" class="btn btn-xs btn-primary" href='{{ url("order/edit/$data->order_no") }}'><span class="fa fa-edit"></span></a> &nbsp;

                    @endif
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_quotation'))
                        <form method="POST" action="{{ url("order/delete/$data->order_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            
                            <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_order') }}" data-message="{{ trans('message.invoice.delete_order_confirm') }}">
                                <i class="glyphicon glyphicon-trash"></i> 
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
    
    $(function () {
      $("#orderList").DataTable({
        "order": [],
        "columnDefs": [{ "targets": 4, "orderable": false }],
        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
      });
    });

    $('#Rfiltro').click(function() {
  
      var dataIni, dataFim, clienteId, cliente, table, tr, tdData, tdCliente, i;

      dataIni  = $('#from').val();
      dataFim = $('#dataFim').val();
      clienteId  = $('#customer').val() != 'all' ? $('#customer').val() : 'all';
      cliente = $('#customer option:selected').text();
      table = $('#orderList');
      tr = table.find("tr");

      dataIniISO = dataIni.split("/");
      dataFimISO = dataFim.split("/");

      var di = dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0];
      var df = dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0];

      baseUrl = $('#baseUrl').val();

      $("#report").attr("href", SITE_URL+"/sales_orders-report/"+di+"/"+df+"/"+clienteId);

      // dataIniISO = dataIni.split("/");
      // dataFimISO = dataFim.split("/");
      
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
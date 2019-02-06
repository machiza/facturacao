@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.payments') }}</div>
          </div> 
        </div>
      </div>
    </div>
      <div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                <li>
                 <a href='{{url("payment/list")}}' >{{ trans('message.extra_text.all') }}</a>
                 </li>
                 <li class="active">
                 <a href="{{url("payment/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
                 </li>
               </ul>
          <form class="form-horizontal" action="{{ url('payment/filtering') }}" method="GET" id='orderListFilter'>
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
                    <input class="form-control" id="to" type="text" name="to" value="{{$to}}" required>
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
                  <label for="sel1">{{ trans('message.extra_text.payment_method') }}</label>
                  <div class="input-group">
                  <select class="form-control select2" name="method" id="method">
                    <option value="">All</option>
                    @if(!empty($methodList))
                    @foreach($methodList as $methodItem)
                    <option value="{{$methodItem->id}}" <?= ($methodItem->id == $method) ? 'selected' : ''?>>{{$methodItem->name}}</option>
                    @endforeach
                    @endif
                  </select>
                  </div>
                </div>
               </div>
            </div>
           
             <div class="row">
             <div class="col-md-1">
             <div class="form-group">
                <div class="input-group">
                <button type="submit" name="btn" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
                </div>
              </div>
              </div>
             </div>
          </div>
          </form>
        </div>
      </div><!--Filtering Box End-->
      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="paymentList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.invoice.payment_no') }}</th>
                    <th>{{ trans('message.accounting.quotation_no') }}</th>
                    <th>{{ trans('message.invoice.invoice_no') }}</th>
                    <th>{{ trans('message.invoice.customer_name') }}</th>
                    <th>{{ trans('message.extra_text.payment_method') }}</th>
                    <th>{{ trans('message.invoice.amount') }}</th>
                    <th>{{ trans('message.invoice.payment_date') }}</th>
                    <th>{{ trans('message.invoice.status') }}</th>
                    <th>{{ trans('message.invoice.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($paymentList as $data)
                  <tr>
                    <td><a href="{{ url("payment/view-receipt/$data->id") }}">{{sprintf("%04d", $data->id)}}</a></td>
                    <td><a href="{{ url("order/view-order-details/$data->order_id") }}">{{$data->order_reference}}</a></td>
                    <td><a href="{{ url("invoice/view-detail-invoice/$data->order_id/$data->invoice_id") }}">{{ $data->invoice_reference }}</a></td>
                    <td>

                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{url("customer/edit/$data->customer_id")}}">{{ $data->name }}</a>
                    @else
                    {{ $data->name }}
                    @endif

                    </td>
                    <td>{{ $data->pay_type }}</td>
                    <td>{{ Session::get('currency_symbol').number_format($data->amount,2,'.',',') }}</td>
                    <td>{{formatDate($data->payment_date)}}</td>
                    <td>
                    @if($data->status=='pending')
                    <span class="label label-danger">Pending</span>
                    @else
                    <span class="label label-success">Completed</span>
                    @endif
                    </td>

                    <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_payment'))
                        <a  title="View" class="btn btn-xs btn-primary" href='{{ url("payment/view-receipt/$data->id") }}'><span class="fa fa-eye"></span></a> &nbsp;
                    @endif
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_payment'))
                        <form method="POST" action="{{ url("payment/delete") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_payment_header') }}" data-message="{{ trans('message.invoice.delete_payment') }}">
                                <i class="glyphicon glyphicon-trash"></i> 
                            </button>
                        </form>
                    @endif
                    </td>
                  </tr>
                 @endforeach
                  </tfoot>
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

    $('#to').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
  $(function () {
    $("#paymentList").DataTable({
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
@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.payments') }}</div>
          </div>

          <div class="col-md-2">
           @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
              <a href="{{ url('payment_supplier/new_payment') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_payments') }}</a>
           @endif
          </div>
        </div>
      </div>
    </div>


      <div class="box">

        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                <li class="active">
                 <a href='{{url("payment_supplier/list")}}' >{{ trans('message.extra_text.all') }}</a>
                 </li>
                 <!--<li>
                 <a href="{{url("payment/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
                 </li>-->
               </ul>
        </div>
      </div>
      <!--Filtering Box End-->
      <!-- Default box -->
      <div class="box">
        <div class="box-header">
             <a href="{{ url('payment_supplier/report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
          </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="paymentList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.invoice.payment_no') }}</th>
                    <th>{{ trans('message.table.supp_name') }}</th>
                    <th>{{ trans('message.extra_text.payment_method') }}</th>
                    <th>{{ trans('message.invoice.amount') }}</th>
                    <th>{{ trans('message.invoice.payment_date') }}</th>
                    <th>{{ trans('message.invoice.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($paymentList as $data)
                  <tr>
                    <td>
                      <a href="{{ url("payment/view-supp-receipt/$data->pay_history_id") }}">
                      {{ $data->reference }}
                      </a>
                    </td>

                    <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_supplier'))
                    <a href="{{ url("edit-supplier/$data->supplier_id") }}">{{ $data->supp_name }}</a>
                    @else
                    {{ $data->supp_name }}
                    @endif
                    </td>

                    <td>{{ $data->pay_type }}</td>
                    
                    <td>{{ Session::get('currency_symbol').number_format($data->total_amount,2,'.',',') }}</td>
                    
                    <td>{{formatDate($data->payment_date)}}</td>
                   
                    <td>
                    <a  title="View" class="btn btn-xs btn-primary" href='{{ url("payment/view-supp-receipt/$data->pay_history_id") }}'><span class="fa fa-eye"></span></a> &nbsp;
                    </td>
                     <td>
                        @if(Helpers::has_permission(Auth::user()->id, 'delete_payment'))
                         <form method="POST" action="{{ url("payment_supplier/delete_payment/$data->id") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!} 
                                <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.extra_text.payments')  }}" data-message="{{ trans('message.table.payment_info') }}">
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
  <!-- Modal -->


@include('layouts.includes.message_boxes')

@endsection

@section('js')
    <script type="text/javascript">
    $(".select2").select2();
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

    $('.editPayment').on('click', function() {
      var pid = $(this).attr("pid");
      var trid = $(this).attr("trid");
        $.ajax({
            url: '{{ URL::to('payment/edit-payment')}}',
            data:{  
                pid:pid,
                trid:trid
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
              
                $('#pid').val(data.pid);
                $('#trid').val(data.trid);
                $('#preAmount').val(data.amount);
                $('#invoice_ref').val(data.invoice_reference);
                $('#amount').val(data.amount);
                $("#account_no").val(data.account_no).change();
                $("#category_id").val(data.category_id).change();
                $("#attachment").html("<a href='"+SITE_URL+'/uploads/attachment/'+data.attachment+"' class='btn btn-sm btn-info'>Download</a>");             

                $('#editPayment').modal();
            }
        });
      });

    </script>
@endsection
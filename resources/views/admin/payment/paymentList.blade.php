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
              <a href="{{ url('payment/new_payment') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_payments') }}</a>
           @endif
          </div>
        </div>
      </div>
    </div>


    <div class="box">
      <div class="box-body">
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
            </div>
  
      </div>
    </div>
      <!--Filtering Box End-->
      <!-- Default box -->
      <div class="box">
        <div class="box-header">
             <a id="report" target="_blank" href="{{ url('payment/report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
          </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="paymentList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.invoice.payment_date') }}</th>
                    <th>{{ trans('message.invoice.payment_no') }}</th>
                    <th>{{ trans('message.invoice.customer_name') }}</th>
                    <th>{{ trans('message.extra_text.payment_method') }}</th>
                    <th>Valor</th>
                    {{--<th colspan="2">{{ trans('message.invoice.action') }}</th>--}}
                    <th></th>
                    <th></th>
                   
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($paymentList as $data)
                  <tr>
                    <td class="{{ $data->ord_date_doc }}">{{ formatDate($data->ord_date_doc) }}</td>
                    <td>
                      <a href="{{ url("payment/view-receipt/$data->rec_no_doc") }}">
                      {{ $data->reference_doc }}
                      </a>
                    </td>

                    <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{url("customer/edit/$data->debtor_no_doc")}}">{{ $data->name }}</a>
                    @else
                    {{ $data->name }}
                    @endif
                    </td>

                    <td>{{ $data->pay_type }}</td>

                    <td>{{ Session::get('currency_symbol').number_format($data->amount_credito_doc,2,'.',',') }}</td>

                    <td>
                        <a  title="View" class="btn btn-xs btn-primary" href='{{ url("payment/view-receipt/$data->rec_no_doc") }}'><span class="fa fa-eye"></span></a> &nbsp;
                    </td>
                    <td>
                        @if(Helpers::has_permission(Auth::user()->id, 'delete_payment'))
                         <form method="POST" action="{{ url("payment/delete_payment/$data->rec_no_doc") }}" accept-charset="UTF-8" style="display:inline">
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
  <div class="modal fade editPayment" id="editPayment" role="dialog" style="display: none;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form action='{{ url("payment/update-payment") }}' method="post" class="form-horizontal" id="customerAdd">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Payment</h4>
        </div>
        <div class="modal-body">


          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          <input type="hidden" name="pid" id="pid">
          <input type="hidden" name="trid" id="trid">
          <input type="hidden" name="preAmount" id="preAmount">
          <input type="hidden" name="invoice_ref" id="invoice_ref">

          <div class="form-group clearfix">
            <label class="col-sm-3 control-label text-right require" for="inputEmail3">{{ trans('message.table.amount') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.table.amount') }}" class="form-control" id="amount" name="amount" min="0" required>
            </div>
          </div>

          <div class="form-group clearfix">
            <label class="col-sm-3 control-label text-right" for="inputEmail3">{{ trans('message.bank.account') }}</label>
            <div class="col-sm-6">
               <select class="form-control select2" name="account_no" id="account_no" style="width:100%">
                @foreach($accounts as $acc_no=>$acc_name)
                  <option value="{{$acc_no}}" >{{$acc_name}}</option>
                @endforeach
                </select>
            </div>
          </div>

          <div class="form-group clearfix">
            <label class="col-sm-3 control-label text-right" for="inputEmail3">{{ trans('message.table.category') }}</label>
            <div class="col-sm-6">
               <select class="form-control select2" name="category_id" id="category_id" style="width:100%" required>
               
                @foreach($incomeCategories as $cat_id=>$cat_name)
                  <option value="{{$cat_id}}" >{{$cat_name}}</option>
                @endforeach
                </select>

            </div>
          </div>



          <div class="form-group clearfix">
            <label class="col-sm-3 control-label text-right" for="inputEmail3">{{ trans('message.table.status') }}</label>
            <div class="col-sm-6">
               <select class="form-control select2" name="status" id="status" style="width:100%" required>
                  <option value="completed">Completed</option>
                  <option value="pending">Pending</option>
                </select>

            </div>
          </div>

          <div class="form-group clearfix">
            <label class="col-sm-3 control-label text-right" for="inputEmail3">{{ trans('message.transaction.attachment') }}</label>
            <div class="col-sm-6" id="attachment">
                
            </div>
          </div>


          <br/>
         
        </div>
        <div class="box-footer">
          <a href="{{ url('payment/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
          <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
        </div>
      </div>
   </form>    
    </div>
  </div>

@include('layouts.includes.message_boxes')

@endsection

@section('js')
  <script type="text/javascript">
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
      var dataIni, dataFim, clienteId, cliente, table, tr, tdData, tdCliente, i;

      dataIni  = $('#from').val();
      dataFim = $('#dataFim').val();
      clienteId  = $('#customer').val() != 'all' ? $('#customer').val() : 'all';
      cliente = $('#customer option:selected').text();
      table = $('#paymentList');
      tr = table.find("tr");

      dataIniISO = dataIni.split("/");
      dataFimISO = dataFim.split("/");

      var di = dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0];
      var df = dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0];

      baseUrl = $('#baseUrl').val();

      $("#report").attr("href", SITE_URL+"/payment/report/"+di+"/"+df+"/"+clienteId);

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
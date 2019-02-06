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
                    
                    <li class="active">
                      <a href="{{url("customer/payment/$customerData->debtor_no")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>

                    <li>
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
              <table id="example1" class="table table-bordered table-striped">
                   <thead>
                  <tr>
                    <th>{{ trans('message.invoice.payment_no') }}</th>
                    <th>{{ trans('message.extra_text.payment_method') }}</th>
                    <th>{{ trans('message.invoice.amount') }}</th>
                    <th>{{ trans('message.invoice.payment_date') }}</th>
                    <th colspan="2">{{ trans('message.invoice.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                   @php
                   $total=0;
                   @endphp

                  @foreach($paymentList as $data)
                  <tr>
                    <td>
                      <a href="{{ url("payment/view-receipt/$data->rec_no_doc") }}">
                      {{ $data->reference_doc }}
                      </a>
                    </td>

                  
                    <td>{{ $data->pay_type }}</td>

                    <td>
                       @php
                        $total=$total+$data->amount_credito_doc;
                       @endphp
                        
                      {{ Session::get('currency_symbol').number_format($data->amount_credito_doc,2,'.',',') }}
                    </td>

                    <td>{{formatDate($data->ord_date_doc)}}</td>
                   
                    <td>
                        <a  title="View" class="btn btn-xs btn-primary" href='{{ url("payment/view-receipt/$data->rec_no_doc") }}'><span class="fa fa-eye"></span></a> &nbsp;
                    </td>
                   
                  </tr>
                 @endforeach
                    <tr>
                          <td></td>
                          <td><strong>Total:</strong></td>
                          <td><strong>{{Session::get('currency_symbol').number_format($total,2)}}</strong></td>

                          <td></td>
                           <td></td>
                  </tr>

                  </tbody>
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
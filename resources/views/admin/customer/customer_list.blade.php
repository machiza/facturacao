@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-8 col-sm-4 col-xs-12">
             <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.customers') }}</div>
            </div> 
             @if(Helpers::has_permission(Auth::user()->id, 'add_customer'))
            <div class="col-md-2 col-sm-4 col-xs-12 btn_bottom">
                <a href="{{ URL::to('customerimport') }}" class="btn btn-block btn-default btn-flat btn-border-purple"><span class="fa fa-upload"> &nbsp;</span>{{ trans('message.extra_text.import_new_customer') }}</a>
            </div>
          
            <div class="col-md-2 col-sm-4 col-xs-12">
                <a href="{{ url('create-customer') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.form.add_new_customer') }}</a>
            </div>
              
              
            <!--<div class="col-md-2 col-sm-4 col-xs-12">
               <a class="video-play-icon" href="https://www.youtube.com/watch?v=MhxDgePckRQ">video Ajuda<i class="fa fa-play"></i></a>
            </div>
            -->

            @endif
          </div>
        </div>
      </div>

      <!-- Top Box-->
      <div class="box">
        <div class="box-body">
          <div class="col-md-2 col-xs-6 border-right">
              <h3 class="bold">{{$customerCount}}</h3>
              <span>{{ trans('message.extra_text.total_customer') }}</span>
          </div>
          <div class="col-md-2 col-xs-6 border-right">
              <h3 class="bold">{{$customerActive}}</h3>
              <span>{{ trans('message.extra_text.active_customer') }}</span>
          </div>
          <div class="col-md-2 col-xs-6 border-right">
              <h3 class="bold">{{$customerInActive}}</h3>
              <span>{{ trans('message.extra_text.inactive_customer') }}</span>
          </div>

        </div>
        <br>
      </div><!--Top Box End-->

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <a href="{{ URL::to('customerdownloadXls/xls') }}"><button class="btn btn-default btn-flat btn-border-info"><span class="fa fa-download"> &nbsp;</span>{{ trans('message.table.download_xls') }}</button></a>

                <a href="{{ url('customer/report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
           
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>{{ trans('message.table.customer_name') }}</th>

                  <!--nuit-->
                  <th>Nuit</th>
                  <!--<th>{{ trans('message.table.balance_amount') }}</th>-->

                  <th>{{ trans('message.extra_text.email') }}</th>
                  <th>{{ trans('message.extra_text.phone') }}</th>
                  <th>{{ trans('message.form.status') }}/ Actions</th>
                 
                </tr>
                </thead>
                <tbody>
                @foreach($customerData as $data)
                <tr>
                  <td>
                   @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{url("customer/edit/$data->debtor_no")}}">{{ $data->name }}</a>
                  @else 
                    {{ $data->name }}
                  @endif
                  </td>
                  
                  <!--NUIT-->
                  <td>{{ $data->nuit }}</td>
                  
                  

                  <td>{{ $data->email }}</td>
                  
                  <td>{{ $data->phone }}</td>
                  <td>
                  @if($data->inactive == 0)
                    <span class='label label-success'>{{ trans('message.table.active') }}</span>
                  @else
                    <span class='label label-danger'>{{ trans('message.table.inactive') }}</span>
                  @endif
                    
                  @if(Helpers::has_permission(Auth::user()->id, 'delete_customer'))
                     <form method="POST" action="{{ url("customer/delete/$data->debtor_no") }}" accept-charset="UTF-8" style="display:inline">
                        {!! csrf_field() !!}
                        <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.customerL.title') }}" data-message="{{ trans('message.customerL.mensage') }}">
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
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>

@include('layouts.includes.message_boxes')

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
        "pageLength": '{{Session::get('row_per_page')}}',

    });
    
  });

    </script>
@endsection
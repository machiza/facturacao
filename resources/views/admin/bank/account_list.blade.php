@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title padding-bottom">{{ trans('message.bank.bank_accounts') }}</div>
            </div>
            <div class="col-md-2 top-right-btn">
            @if(Helpers::has_permission(Auth::user()->id, 'add_bank_account'))
                <a href="{{ url('bank/add-account') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.bank.new_account') }}</a>
            @endif
            </div>

          </div>
        </div>
      </div>


      <!-- Default box -->
      <div class="box">
        <div class="box-header">
             <a href="{{ url('bank/report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
          </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="accountList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>{{ trans('message.bank.account_name') }}</th>
                  <th>{{ trans('message.bank.account_type') }}</th>
                  <th>{{ trans('message.bank.account_no') }}</th>
                  <th>{{ trans('message.bank.bank_name') }}</th>
                  <th>{{ trans('message.bank.bank_address') }}</th>
                  <th>{{ trans('message.bank.balance') }}({{Session::get('currency_symbol')}})</th>
                  <th>{{ trans('message.table.action') }}</th>
  
                </tr>
                </thead>
                <tbody>
                <?php
                $balance = 0;
                ?>
                @foreach($accountList as $data)
                <?php
                $balance += $data->balance;
                ?>
                <tr>
                  <td>
                  @if(Helpers::has_permission(Auth::user()->id, 'edit_bank_account'))
                  <a href='{{url("bank/edit-account/transaction/$data->id")}}'>{{ $data->account_name }}</a>
                  @else
                  {{ $data->account_name }}
                  @endif
                  </td> 
                  <td>{{ $data->account_type }}</td>
                  <td>{{ $data->account_no }}</td>
                  <td>{{ $data->bank_name }}</td>
                  <td>{{ $data->bank_address }}</td>
                  <td>{{ number_format($data->balance, 2,'.',',') }}</td>
                  <td>
                     @if(Helpers::has_permission(Auth::user()->id, 'edit_bank_account'))
                      <a title="edit" class="btn btn-xs btn-primary" href='{{url("bank/edit-account/edit/$data->id")}}'><span class="fa fa-edit"></span></a> &nbsp;
                      @endif

                       @if(Helpers::has_permission(Auth::user()->id, 'delete_bank_account'))
                      <form method="POST" action="{{ url("bank/delete/$data->id") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <button title="{{ trans('message.form.Delete') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Bank account delete" data-message="Are you sure to delete ?">
                              <i class="glyphicon glyphicon-trash"></i> 
                          </button> &nbsp;
                      </form>
                      @endif

                  </td>
                </tr>
               @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">{{ trans('message.bank.total_balance') }}</th>
                        <th>{{ number_format($balance,2,'.',',')}}</th>
                    </tr>
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
    $("#accountList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 5,
        "orderable": true
        } ],

        "language": '{{Session::get('language')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection
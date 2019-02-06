@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title padding-bottom">{{ trans('message.transaction.expenses') }}</div>
            </div>
            <div class="col-md-2">
            @if(Helpers::has_permission(Auth::user()->id, 'add_expense'))
                <a href="{{ url('expense/add-expense') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.transaction.new_expense') }}</a>
            @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Default box -->
      <div class="box">
          <div class="box-header">
            <a href="{{ url('expense/report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
          </div>
          
         <!-- /.box-header -->
            <div class="box-body">
              <table id="expenseList" class="table table-bordered table-striped">
                <thead>
                <tr>
                 
                  <th class="text-center">{{ trans('message.bank.account_name') }}</th>
                  <th class="text-center">{{ trans('message.bank.account_no') }}</th>
                  <th class="text-center">{{ trans('message.table.description') }}</th>
                  <th class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.table.date') }}</th>
                  <th width="3%">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($expenseList as $data)
                <tr>
                  <td class="text-center">{{ $data->account_name }}</td>
                  <td class="text-center">{{ $data->account_no }}</td>
                  <td class="text-center">{{ $data->description }}</td>
                  <td class="text-center">{{ abs($data->amount) }}</td>
                  <td class="text-center">{{ formatDate($data->trans_date) }}</td>
                  <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_expense'))
                    <a  title="Edit" class="btn btn-xs btn-primary" href='{{ url("expense/edit-expense/$data->id") }}'><span class="fa fa-edit"></span></a> &nbsp;
                    @endif
                     @if(Helpers::has_permission(Auth::user()->id, 'delete_expense'))
                       <form method="POST" action="{{ url("expense/delete/$data->id") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.transaction.delete_expense_header') }}" data-message="{{ trans('message.transaction.delete_expense') }}">
                             <i class="fa fa-remove" aria-hidden="true"></i>
                          </button>
                      </form>  
                      @endif        

                  </td>
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
    $("#expenseList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 4,
        "orderable": true
        } ],

        "language": '{{Session::get('language')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection
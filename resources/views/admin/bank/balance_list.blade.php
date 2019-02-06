@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
             <div class="top-bar-title padding-bottom">{{ trans('message.bank.account_balances') }}</div>
            </div>
          </div>
        </div>
      </div>


      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="balanceList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>{{ trans('message.bank.bank_name') }}</th>
                  <th>{{ trans('message.bank.account_name') }}</th>
                  <th>{{ trans('message.bank.account_no') }}</th>
                  <th>{{ trans('message.bank.balance') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accountList as $data)
                <tr>
                  <td>{{ $data->bank_name }}</td>
                  <td>{{ $data->account_name }}</td>
                  <td>{{ $data->account_no }}</td>
                  <td></td>
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
    $("#balanceList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 3,
        "orderable": true
        } ],

        "language": '{{Session::get('language')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection
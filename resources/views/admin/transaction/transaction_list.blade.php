@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">

            <form class="form-horizontal" action="{{ url('transaction/list') }}" method="GET" id='transactionFilter'>
              
              <div class="col-md-2">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control" id="from" type="text" name="from" value="<?= isset($from) ? formatDate($from) : '' ?>" required>
                  </div>
              </div>

              <div class="col-md-2">
                  <label for="exampleInputEmail1">{{ trans('message.report.to') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="to" type="text" name="to" value="<?= isset($to) ? formatDate($to) : '' ?>" required>
                  </div>
              </div>

              <div class="col-md-2">
                <label for="exampleInputEmail1">{{ trans('message.table.type') }}</label>
                <select class="form-control select2" name="type" id="type">
                <option value="">All</option>
                @foreach($types as $type)
                  <option value="{{$type}}" <?= ($type==$type_id) ? 'selected' : '' ?>>{{$type}}</option>
                @endforeach
                </select>
              </div>

              <div class="col-md-2">
                <label for="exampleInputEmail1">{{ trans('message.form.category') }}</label>
                <select class="form-control select2" name="category_id" id="category_id">
                <option value="">All</option>
                @foreach($categoryList as $key=>$name)
                  <option value="{{$key}}" <?= ($key==$category_id) ? 'selected' : '' ?> >{{$name}}</option>
                @endforeach
                </select>
              </div>

              <div class="col-md-2">
                <label for="exampleInputEmail1">{{ trans('message.bank.account_name') }}</label>
                <select class="form-control select2" name="account_no" id="account_no">
                <option value="">All</option>
                @foreach($accountList as $index=>$data)
                  <option value="{{$index}}" <?= ($index==$account_no) ? 'selected' : '' ?>>{{$data}}</option>
                @endforeach
                </select>
              </div>

              <div class="col-md-1">
                <label for="btn">&nbsp;</label>
                <button type="submit" name="btn" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
              </div>

            </form>

            </div>
          </div>
        </div>
      </div>

      <!-- Default box -->
      <div class="box">
        <div class="box-header">
             <a href="{{ url('transaction/report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
          </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
              <table id="transactionList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">{{ trans('message.table.date') }}</th>
                  <th class="text-center">{{ trans('message.bank.account_name') }}</th>
                  <th class="text-center">{{ trans('message.bank.account_no') }}</th>
                  <th class="text-center">{{ trans('message.table.type') }}</th>
                  <th class="text-center">{{ trans('message.table.category') }}</th>
                  <th class="text-center">{{ trans('message.table.description') }}</th>
                  <th class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>            
                </tr>
                </thead>
                <tbody>
                @foreach($transactionList as $data)
                <tr>
                  <td class="text-center">{{ formatDate($data->trans_date) }}</td>
                  <td class="text-center">{{ $data->account_name }}</td>
                  <td class="text-center">{{ $data->account_no }}</td>
                  <td class="text-center">
                    @if($data->amount <= 0)
                      Expense
                    @else
                      Income
                    @endif
                  </td>
                  <td class="text-center">{{ $data->category }}</td>
                  <td class="text-center">{{ $data->description }}</td>
                  <td class="text-center">{{ abs($data->amount) }}</td>
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
@endsection
@section('js')
    <script type="text/javascript">

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
    $("#transactionList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 6,
        "orderable": false
        } ],

        "language": '{{Session::get('language')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection
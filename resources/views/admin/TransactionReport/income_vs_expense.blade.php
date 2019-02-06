@extends('layouts.app')
@section('content')
<style>
.dataTables_filter
{
    display:none;
}
</style>
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
             <div class="top-bar-title padding-bottom">{{ trans('message.transaction.income_vs_expense') }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-12">
                <form class="form-horizontal">
                <div class="form-group">
                  <label class="col-sm-5 control-label" for="inputEmail3">{{ trans('message.purchase_report.year') }}</label>
                  <div class="col-sm-2">
                     <select class="form-control select2" name="year" id="year">
                      @foreach($yearList as $year)
                        <option value="{{$year->year}}" <?= ($yearSelected == $year->year) ? 'selected' : ''?> >{{$year->year}}</option>
                      @endforeach
                      </select>
                  </div>
                </div>
                </form>
                </div>
            </div>

            <div class="box-body">
              <div class="table-responsive">
                <table id="expenseList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="text-center">{{ trans('message.purchase_report.month') }}</th>
                    <th class="text-center">{{ trans('message.transaction.income') }}({{Session::get('currency_symbol')}})</th>
                    <th class="text-center">{{ trans('message.transaction.expense') }}({{Session::get('currency_symbol')}})</th>
                    <th class="text-center">{{ trans('message.report.profit') }}({{Session::get('currency_symbol')}})</th>
              
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $totalIncome = 0;
                  $totalExpense = 0;
                  $totalProfit = 0; 
                   ?>
                  @foreach($dataList as $result)
                  <?php
                    $totalIncome += $result['income'];
                    $totalExpense += $result['expense'];
                    $totalProfit += $result['profit']; 
                  ?>
                  <tr>
                    <td class="text-center">{{$result['month']}}</td>
                    <td class="text-center">{{$result['income']}}</td>
                    <td class="text-center">{{$result['expense']}}</td>
                    <td class="text-center">{{$result['profit']}}</td>
                  </tr>
                  @endforeach
                
                  <tr>
                    <th class="text-right">{{ trans('message.table.total') }}</th>
                    <th class="text-center">{{Session::get('currency_symbol').$totalIncome}}</th>
                    <th class="text-center">{{Session::get('currency_symbol').$totalExpense}}</th>
                    <th class="text-center">{{Session::get('currency_symbol').$totalProfit}}</th>
                  </tr>

                 </tbody>

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
    $('.select2').select2();
    $("#year").on("change", function(){
      var year = $(this).val();
      window.location = SITE_URL+"/transaction/income-vs-expense?year="+year;
    });
    </script>
@endsection
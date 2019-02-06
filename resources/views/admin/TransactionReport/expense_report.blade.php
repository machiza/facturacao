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
             <div class="top-bar-title padding-bottom">{{ trans('message.transaction.expense_report') }}</div>
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
                        <option value="{{$year}}" <?= ($yearSelected == $year) ? 'selected' : ''?> >{{$year}}</option>
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
                    <th class="text-center">{{ trans('message.table.category') }}</th>
                    <th class="text-center">{{ trans('message.month.january') }}</th>
                    <th class="text-center">{{ trans('message.month.february') }}</th>
                    <th class="text-center">{{ trans('message.month.march') }}</th>
                    <th class="text-center">{{ trans('message.month.april') }}</th>
                    <th class="text-center">{{ trans('message.month.may') }}</th>
                    <th class="text-center">{{ trans('message.month.june') }}</th>
                    <th class="text-center">{{ trans('message.month.july') }}</th>
                    <th class="text-center">{{ trans('message.month.august') }}</th>
                    <th class="text-center">{{ trans('message.month.september') }}</th>
                    <th class="text-center">{{ trans('message.month.october') }}</th>
                    <th class="text-center">{{ trans('message.month.november') }}</th>
                    <th class="text-center">{{ trans('message.month.december') }}</th>
              
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $january = 0;
                  $february = 0;
                  $march = 0;
                  $april = 0;
                  $may = 0;
                  $june = 0;
                  $july = 0;
                  $august = 0;
                  $september = 0;
                  $october = 0;
                  $november = 0;
                  $december = 0;
                  ?>
                  @foreach($expenseList as $category=>$data)
                  <tr>
                    <td class="text-center">{{$category}}</td>
                    @for($month=1;$month<=12;$month++)
                      <td class="text-center">
                          <?= isset($data[$month]) ? abs($data[$month]) : 0 ?>
                      </td>
                      <?php
                      if( isset($data[$month]) ){
                        $amount = abs($data[$month]);
                        if( $month == 1 ){
                          $january += $amount; 
                        }elseif( $month == 2 ){
                          $february += $amount;
                        }elseif( $month == 3 ){
                          $march += $amount;
                        }elseif( $month == 4 ){
                          $april += $amount;
                        }elseif( $month == 5){
                          $may += $amount;
                        }elseif( $month == 6 ){
                          $june += $amount;
                        }elseif( $month == 7 ){
                          $july += $amount;
                        }elseif( $month == 8 ){
                          $august += $amount;
                        }elseif( $month == 9 ){
                          $september += $amount;
                        }elseif( $month == 10 ){
                          $october += $amount;
                        }elseif( $month == 11 ){
                          $november += $amount;
                        }elseif( $month == 12 ){
                          $december += $amount;
                        }
                      }

                      ?>
                    @endfor
                  </tr>
                 @endforeach
                 </tbody>
                 <tfoot>
                 <tr>
                   <th class="text-right">{{ trans('message.invoice.sub_total') }}</th>
                   <th class="text-center">{{ Session::get('currency_symbol').$january }}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$february}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$march}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$april}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$may}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$june}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$july}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$august}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$september}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$october}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$november}}</th>
                   <th class="text-center">{{Session::get('currency_symbol').$december}}</th>

                 </tr>
                  </tfoot>
                </table>
              </div>
              <div style="font-size: 18px; font-weight: bold; margin: 10px 0px;">
              {{ trans('message.table.grand_total') }} : {{Session::get('currency_symbol').($january+$february+$march+$april+$may+$june+$july+$august+$september+$october+$november+$december)}}
              </div>

            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->
      <div class="box">
            <div class="box-body">

          <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>

            </div>
      </div>

    </section>
@include('layouts.includes.message_boxes')
@endsection
@section('js')
    <script type="text/javascript">
    //$(.dataTables_filter ).remove();
    $('.select2').select2();
    $(function () {
      $("#expenseList").DataTable({
        "paging":   false,
         "info":     false,
        "order": [],
        "columnDefs": [ {
          "targets": 7,
          "orderable": true
          } ],
          "language": '{{Session::get('language')}}'
      });
    });

    $("#year").on("change", function(){
      var year = $(this).val();
      window.location = SITE_URL+"/transaction/expense-report?year="+year;
    });


// bar Chart Start
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: '{{ trans('message.transaction.expense_report') }}'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Expense'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Expense: <b>{point.y:.2f}</b>'
    },
    series: [{
        name: 'Expense',
        data: jQuery.parseJSON('{!! $graph !!}'),
        
        dataLabels: {
            enabled: false,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
// bar Chart End    

    </script>
@endsection
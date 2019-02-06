@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="row">
        <!--Graph Chart-->
          <div class="col-md-12">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <div id="row">
                <div class="col-md-12">
                  <div class="text-center">
                   <strong>{{ trans('message.transaction.last_thirt_days') }}</strong>
                  </div>
                </div>
              </div>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart" style="height: 246px; width: 1069px;" height="246" width="1069"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer with-border">
              <div id="row">
                <div class="col-md-1">
                  <div class="row">
                    <div class="col-md-4">
                    <div id="sale">
                    </div>
                    </div>
                    <div class="col-md-8 scp">
                      {{ trans('message.transaction.income') }}
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="row">
                    <div class="col-md-4">
                    <div id="cost">
                    </div>
                    </div>
                    <div class="col-md-8 scp">
                      {{ trans('message.transaction.expense') }}
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="row">
                    <div class="col-md-4">
                    <div id="profit">
                    </div>
                    </div>
                    <div class="col-md-8 scp">
                      {{ trans('message.report.profit') }}
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- /.box -->
        </div>
        <!--Graph Chart-->
      </div>
      <!-- /.box -->
      <?php
      $duePercent = 0;
      if($openInvoice>0){
      $duePercent = (int) ($overDue*100/$openInvoice)-4;
        }
//d($openInvoice);
        
      ?>

      <div class="row">
          <div class="col-md-8">
            <!--- Start sale, revenue and profit-->
            <div class="box box-info">
                <div class="box box-body">
                <div style="font-weight:bold; font-size:20px; padding: 10px 0px;">{{ trans('message.transaction.income') }}</div>
                  <div class="row">
                 
                  <div class="col-md-8 text-center" style="padding-right:0px ">
                   @if($openInvoice>0)
                    <div style="height:40px; margin-top: 3px;background-color:#F0AD4E; width:100%; padding-right: 3%;padding-left: 3%"> 
                      <div class="pull-right" style="height:40px; background-color:#D9534F; width:<?php echo $duePercent ?>%">        
                       </div>
                    </div>
                    @endif
                  </div>
                            
                  @if($paidAmount>0)
                  <div class="col-md-4 text-center">
                    <div class="bg-primary" style="height:40px;margin-top: 3px;""></div>
                  </div>
                  @endif

                  </div>

<div class="row">
<div class="col-md-4">
<div style="font-weight: bold; font-size: 18px; padding-top: 10px;">{{Session::get('currency_symbol').number_format($openInvoice,2,'.',',')}}
</div>
{{ trans('message.transaction.open_invoices') }}
</div>
<div class="col-md-4">
<div style="font-weight: bold; font-size: 18px; padding-top: 10px;">{{Session::get('currency_symbol').number_format($overDue,2,'.',',')}}
</div>
{{ trans('message.transaction.overdue') }}
</div>
<div class="col-md-4">
<div style="font-weight: bold; font-size: 18px; padding-top: 10px;">{{Session::get('currency_symbol').number_format($paidAmount,2,'.',',')}}
</div>
{{ trans('message.transaction.paid_last_days') }}
</div>
</div>
                </div>
            </div>
<!--Expense Category Graph Start-->
            <div class="box box-info">
                <div class="box box-body">
                    <div style="font-weight:bold; font-size:20px; padding: 10px 0px;">
                    {{ trans('message.transaction.expenses') }}
                    </div>
                    <div class="row">
                    <div class="col-md-4">
                      <div style="font-weight: bold; font-size: 18px;">{{Session::get('currency_symbol').number_format($expenseAmount,2,'.',',')}}
                      </div>
                      {{ trans('message.transaction.expense_last_days') }}
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                        <div class="col-md-8">
                          <ul class="chart-legend clearfix">
                          <?php
                          $colors = ['text-red','text-green','text-yellow','text-aqua','text-light-blue','text-gray'];
                          $otherAmount = 0;
                          ?>
                          @if(!empty($expenseAmountCategory))
                            @foreach($expenseAmountCategory as $colorIndex=>$catName)
                              @if($colorIndex<=4)
                              <li><i class="fa fa-circle {{$colors[$colorIndex]}}"></i> {{Session::get('currency_symbol').abs($catName->amount) .' '.$catName->name}}</li>
                              @endif

                              <?php
                                  if($colorIndex>4){
                                    $otherAmount += $catName->amount;
                                  }
                                ?>
                            @endforeach

                          <li><i class="fa fa-circle text-gray"></i> {{Session::get('currency_symbol').abs($otherAmount).' Others'}}</li>

                          @endif
                          </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="chart-responsive">
                              <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>    
<!--Expense Category Graph End-->

<!--Income Expense Start-->
            <div class="box box-info">
                <div class="box box-body">
                    <div style="font-weight:bold; font-size:20px; padding: 10px 0px;">
                    {{ trans('message.transaction.profit_loss') }}
                    </div>
                    <div class="row">
                    <div class="col-md-4">
                    <?php
                    $netIncome = ($totalIncome-$totalExpense);
                    ?>
                      <div>
                      <p style="font-weight: bold;font-size: 16px; margin: 0px;">
                        @if($netIncome >= 0)
                        {{ Session::get('currency_symbol').number_format(abs($netIncome),2,'.',',') }}
                        @else
                        -{{ Session::get('currency_symbol').number_format(abs($netIncome),2,'.',',') }}
                        @endif
                      </p>

                      {{ trans('message.transaction.net_income') }}
                      </div>

                      <div style="margin : 7px 0px; border-left: 3px solid #286090;padding-left: 10px;">
                      <p style="font-size: 16px; margin: 0px;">
                        @if($totalIncome >= 0)
                        {{ Session::get('currency_symbol').number_format($totalIncome,2,'.',',') }}
                        @else
                        -{{ Session::get('currency_symbol').number_format($totalIncome,2,'.',',') }}
                        @endif
                      </p>

                      {{ trans('message.transaction.income') }}
                      </div>

                      <div style="margin : 7px 0px; border-left: 3px solid #C9302C;padding-left: 10px;">

                      <p style="font-size: 16px; margin: 0px;">
                        @if($totalExpense >= 0)
                        {{ Session::get('currency_symbol').number_format($totalExpense,2,'.',',') }}
                        @else
                        -{{ Session::get('currency_symbol').number_format($totalExpense,2,'.',',') }}
                        @endif
                      </p>

                      {{ trans('message.transaction.expenses') }}
                      </div>

                    </div>
                    <div class="col-md-8">
                <div id="container" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
                    </div>
                    </div>
                </div>
            </div>    
          </div>

          <div class="col-md-4">
          <!-- Account List-->
          <div class="box box-info">
              <div class="box-header">
                      <div style="font-weight:bold; font-size:20px;">
                      {{ trans('message.bank.bank_accounts') }}
                      </div>
              </div>
              <div class="box box-body">
                @if(!empty($accountList))
                 
                 @foreach($accountList as $item)
                  <div style="min-height:60px;border-bottom: 1px solid gray;padding: 5px 0px;">
                    <div style="width:60%;float: left;">
                      <div style="font-weight: bold; min-height: 25px;">{{$item->bank_name}}</div><div class="clearfix"></div>
                      <div style="margin-bottom: 5px;min-height: 25px;">{{$item->account_type}}</div>
                      <div class="clearfix"></div>
                    </div>
                    <div style="width:40%;float: left;text-align: right;font-weight: bold;">
                    {{Session::get('currency_symbol').number_format($item->balance,2,'.',',')}}
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  @endforeach

                @else
                <h5 class="text-center">{{ trans('message.bank.no_account') }}</h5>
                @endif
              </div>
          </div>
<!-- Income List-->
          <div class="box box-info">
              <div class="box-header">
                      <div style="font-weight:bold; font-size:20px;">
                      {{ trans('message.transaction.latest_income') }}
                      </div>
              </div>
              <div class="box box-body">
                @if(!empty($latestIncomeList))
                 
                  <table class="table table-bordered">
                  <thead>
                  <tr>
                  <th class="text-center">{{ trans('message.dashboard.order_date') }}</th>
                  <th class="text-center">{{ trans('message.table.description') }}</th>
                  <th class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                  

                  </tr>
                  </thead>
                  <tbody>
                  @foreach($latestIncomeList as $itemIncome)
                  <tr>
                  <td align="center">{{formatDate($itemIncome->trans_date)}}</td>
                  <td align="center">{{$itemIncome->description}}</td>
                  <td align="center">{{abs($itemIncome->amount)}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                  </table>

                @else
                <h5 class="text-center">{{ trans('message.transaction.no_transaction') }}</h5>
                @endif

              </div>
          </div>

<!-- Expense List-->
          <div class="box box-info">
              <div class="box-header">
                      <div style="font-weight:bold; font-size:20px;">
                      {{ trans('message.transaction.latest_expense') }}
                      </div>
              </div>
              <div class="box box-body">
                @if(!empty($latestIncomeExpenses))
                 
                  <table class="table table-bordered">
                  <thead>
                  <tr>
                  <th class="text-center">{{ trans('message.dashboard.order_date') }}</th>
                  <th class="text-center">{{ trans('message.table.description') }}</th>
                  <th class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                  

                  </tr>
                  </thead>
                  <tbody>
                  @foreach($latestIncomeExpenses as $itemExpense)
                  <tr>
                  <td align="center">{{formatDate($itemExpense->trans_date)}}</td>
                  <td align="center">{{$itemExpense->description}}</td>
                  <td align="center">{{abs($itemExpense->amount)}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                  </table>

                @else
                <h5 class="text-center">{{ trans('message.transaction.no_transaction') }}</h5>
                @endif

              </div>
          </div>
          </div>
      </div>


    </section>
@endsection
@section('js')
<script>
  $(function () {
 'use strict';
    var areaChartData = {
      labels: jQuery.parseJSON('{!! $date !!}'),
      datasets: [
        {
          label: "Income",
          fillColor: "rgba(66,155,206, 1)",
          strokeColor: "rgba(66,155,206, 1)",
          pointColor: "rgba(66,155,206, 1)",
          pointStrokeColor: "#429BCE",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(66,155,206, 1)",
          data: {{$incomesArray}}
        },
        {
          label: "Expense",
          fillColor: "rgba(255,105,84,1)",
          strokeColor: "rgba(255,105,84,1)",
          pointColor: "#F56954",
          pointStrokeColor: "rgba(255,105,84,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(255,105,84,1)",
          data: {{$expenseArray}}
        },
        {
          label: "Profit",
          fillColor: "rgba(47, 182, 40,0.9)",
          strokeColor: "rgba(47, 182, 40,0.8)",
          pointColor: "#2FB628",
          pointStrokeColor: "rgba(47, 182, 40,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(47, 182, 40,1)",
          data: {{$thirtyDayprofit}}
        }        
      ]
    };

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
    var lineChartOptions = areaChartOptions;
    lineChartOptions.datasetFill = false;
    lineChart.Line(areaChartData, lineChartOptions);
  });

  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
  var PieData = jQuery.parseJSON('{!! $expenseGraph !!}'); 

  var pieOptions = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: "#fff",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: "easeOutBounce",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
    //String - A tooltip template
    tooltipTemplate: "<%=label%>"
  };
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  //-----------------
  //- END PIE CHART -
  //-----------------

  //-----------------
  //- START INCOME AND PROFIT CHART -
  //-----------------
  Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: jQuery.parseJSON('{!! $sixMonth !!}')
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Income',
        data: jQuery.parseJSON('{!! $incomeArr !!}')
    },{
        name: 'Expense',
        data: jQuery.parseJSON('{!! $expensesArr !!}')
    }, {
        name: 'Profit',
        data: jQuery.parseJSON('{!! $profitArr !!}')
    }]
});
  //-----------------
  //- END INCOME AND PROFIT CHART -
  //-----------------
</script>
@endsection
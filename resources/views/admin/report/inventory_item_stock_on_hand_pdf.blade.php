<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title>Stock on hand report</title>
<style>
 body{ font-family: 'DejaVu Sans', Helvetica, sans-serif; color:#121212; line-height:22px;}

.page-break {
    page-break-after: always;
}

 table, tr, td{
    border-bottom: 1px solid #d1d1d1;
    padding: 6px 0px;
}
tr{ height:40px;}

</style>
</head>

<body>
  <div style="width:100%; margin:15px auto;">
  <div style="height:130px">
    <div style="width:70%; float:left; font-size:15px; color:#383838; font-weight:400;">
      <div style="font-size:20px;"><strong>{{ trans('message.report_pdf.inventory_stock_on_hand') }}</strong></div>
      <div>{{ trans('message.report_pdf.date') }} : {{formatDate(date('d-m-Y'))}}</div>
      <div>{{ trans('message.report_pdf.location') }} : {{$location_name}}</div>
      <div>{{ trans('message.report_pdf.category') }} : {{$category_name}}</div>
    </div>

    <div style="width:30%; float:left;font-size:15px; color:#383838; font-weight:400;">
    <div><strong>{{ Session::get('company_name') }}</strong></div>
    <div>{{ Session::get('company_street') }}</div>
    <div>{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
    <div>{{ Session::get('company_country_id') }}, {{ Session::get('company_zipCode') }}</div>
    </div>
  </div>

  <div>
 <table style="width:100%; border-radius:2px; border:2px solid #d1d1d1; border-collapse: collapse;">
 <tr style="background-color:#f0f0f0; border-bottom:1px solid #d1d1d1; text-align:center; font-size:13px; font-weight:bold;">
   <td>{{ trans('message.report.product') }}</td>
   <td>{{ trans('message.report.stock_id') }}</td>
   <td>{{ trans('message.report.in_stock') }}</td>
   <td>{{ trans('message.report.mac') }}</td>
   <td>{{ trans('message.report.retail_price') }}</td>
   <td>{{ trans('message.report.in_value') }}</td>
   <td>{{ trans('message.report.retail_value') }}</td>
   <td>{{ trans('message.report.profit_value') }}</td>
   <td>{{ trans('message.report_pdf.profit') }}</td>
 </tr>
 <?php
 $instock = 0;
 $invalue = 0;
 $retailValue = 0;
 $profitValue = 0;
 ?>
  @foreach ($itemList as $item)
      <?php
        $mac = 0;
        $profit_margin = 0;
        if($item->received_qty !=0){
         $mac = $item->cost_amount/$item->received_qty;
        }
        $in_value = $item->available_qty*$mac;
        $retail_value = $item->available_qty*$item->retail_price;
        $profit_value = ($retail_value-$in_value);
        if($in_value !=0){
        $profit_margin = ($profit_value*100/$in_value); 
        }
        // calculate total info
        $instock += $item->received_qty;
        $invalue += $in_value;
        $retailValue += $retail_value; 
        $profitValue += ($retail_value-$in_value);

      ?>

 <tr style="background-color:#fff; text-align:center; font-size:13px; font-weight:normal;">
  <td>{{ $item->description }}</td>
  <td>{{ $item->stock_id }}</td>
  <td>{{ $item->available_qty }}</td>
  <td>{{ Session::get('currency_symbol').number_format($mac,2,'.',',') }}</td>
  <td>{{ Session::get('currency_symbol').number_format($item->retail_price,2,'.',',') }}</td>
  <td>{{ Session::get('currency_symbol').number_format(abs($in_value),2,'.',',') }}</td>
  <td>{{ Session::get('currency_symbol').number_format(abs($retail_value),2,'.',',') }}</td>
  <td>{{ Session::get('currency_symbol').number_format(abs($profit_value),2,'.',',') }}</td>
  <td>{{ number_format($profit_margin,2,'.',',') }}%</td>
 </tr>
  @endforeach 
  <tr style="background-color:#f0f0f0; text-align:right; font-size:13px; font-weight:normal;">
    <td colspan="2"><strong>{{ trans('message.report_pdf.total') }}</stong></td>
    <td align="center"><strong>{{$instock}}</stong></td>
    <td align="center"><strong>&nbsp;</stong></td>
    <td align="center"><strong>&nbsp;</stong></td>
    <td align="center"><strong>{{Session::get('currency_symbol').number_format($invalue,2,'.',',')}}</stong></td>
    <td align="center"><strong>{{ Session::get('currency_symbol').number_format(abs($retailValue),2,'.',',') }}</stong></td>
    <td align="center"><strong>{{ Session::get('currency_symbol').number_format(abs($profitValue),2,'.',',') }}</stong></td>
    <td align="center"><strong>&nbsp;</stong></td>            
  </tr>
</table> 
  </div>
  </div>
</body>
</html>
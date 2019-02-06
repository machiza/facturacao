<div class="col-md-4 left-padding-col4">
    @if($invoiceType == 'directOrder')
    <div class="box box-default">
      <div class="box-header text-center">
        <h5 class="text-left text-info"><b>{{ trans('message.accounting.quotation_no') }} # <a href="{{URL::to('/')}}/order/view-order-details/{{$orderInfo->order_no}}">{{$orderInfo->reference}}</a></b></h5>
      </div>
    </div>
    <!--Start-->
    <div class="box box-default">
      <div class="box-header text-center">
        <strong>{{ trans('message.accounting.invoice') }}</strong>
      </div>
        @if($invoiced_status == 'no')
        <div class="box-body">
          <div class="row">
            <div class="col-md-12 btn-block-left-padding">
              <a href="{{URL::to('/')}}/order/auto-invoice-create/{{$orderInfo->order_no}}" title="{{ trans('message.accounting.convert_to_invoice') }}" class="btn btn-success btn-flat btn-block ">{{ trans('message.accounting.convert_to_invoice') }}</a>
            </div>
          </div>
        </div>
        @else
        <div class="box-body">
          <div class="row">
            <div class="col-md-12 text-center">
            {{ trans('message.accounting.quotation_invoiced_on') }} {{formatDate($invoiced_date)}}
            </div>
          </div>
        </div>
        @endif
    </div>    
    @endif
    <!--END-->
    <div class="box box-default">
      <div class="box-header text-center">
        <strong>{{ trans('message.invoice.payment_list') }}</strong>
      </div>
      <div class="box-body">
        @if(!empty($paymentsList))
        <table class="table table-bordered">
          <thead>
            <tr>
              <!--<th class="text-center">{{ trans('message.invoice.payment_no') }}</th>-->
              <th>{{ trans('message.invoice.invoice_no') }}</th>
              <th>{{ trans('message.extra_text.method') }}</th>
              <th>{{ trans('message.invoice.amount') }}({{ Session::get('currency_symbol')}})</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sumInvoice = 0;
            ?>
            @foreach($paymentsList as $payment)
            <tr>
             <!-- <td align="center"><a href="{{ url("payment/view-receipt/$payment->id") }}"><i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;{{sprintf("%04d", $payment->id)}}</a></td>-->
              <td align="center">{{$payment->invoice_reference}}</td>
              <td align="center">{{$payment->name}}</td>
              <td align="right">{{number_format($payment->amount,2,'.',',')}}</td>
            </tr>
            <?php
            $sumInvoice += $payment->amount;
            ?>
            @endforeach
              <td colspan="2" align="right"><strong>{{ trans('message.invoice.total') }}</stron></td><td align="right"><strong>{{Session::get('currency_symbol').number_format($sumInvoice,2,'.',',')}}</strong></td>
          </tbody>
        </table>
        @else
        <h5 class="text-center">{{ trans('message.invoice.no_payment') }}</h5>
        @endif
      </div>
    </div>      
</div>
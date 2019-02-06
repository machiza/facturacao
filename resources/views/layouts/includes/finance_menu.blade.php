<!-- Profile Image -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">{{trans('message.header.finance_setting')}}</h3>
  </div>
  <div class="box-body no-padding" style="display: block;">
    <ul class="nav nav-pills nav-stacked">
     
      
      <li {{ isset($list_menu) &&  $list_menu == 'tax' ? 'class=active' : ''}} ><a href="{{ URL::to("tax")}}">{{ trans('message.extra_text.taxes') }}</a></li>
    
      
      @if(Helpers::has_permission(Auth::user()->id, 'manage_currency'))
      <li {{ isset($list_menu) &&  $list_menu == 'currency' ? 'class=active' : ''}}><a href="{{ URL::to("currency")}}">{{ trans('message.extra_text.currencies') }}</a></li>
      @endif

      @if(Helpers::has_permission(Auth::user()->id, 'manage_payment_term'))
      <li {{ isset($list_menu) &&  $list_menu == 'payment_term' ? 'class=active' : ''}}><a href="{{ URL::to("payment/terms")}}">{{ trans('message.extra_text.payment_terms') }}</a></li>
      @endif
      
      @if(Helpers::has_permission(Auth::user()->id, 'manage_payment_method'))
      <li {{ isset($list_menu) &&  $list_menu == 'payment_method' ? 'class=active' : ''}}><a href="{{ URL::to("payment/method")}}">{{ trans('message.extra_text.payment_methods') }}</a></li>
      @endif

      @if(Helpers::has_permission(Auth::user()->id, 'manage_payment_gateway'))
      <li {{ isset($list_menu) &&  $list_menu == 'payment_gateway' ? 'class=active' : ''}}><a href="{{ URL::to("payment/gateway")}}">{{ trans('message.extra_text.payment_gateway') }}</a></li>
      @endif


    </ul>
  </div>
  <!-- /.box-body -->
</div>
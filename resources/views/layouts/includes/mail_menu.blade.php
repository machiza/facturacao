<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">{{trans('message.header.email__temp_setting')}}</h3>
  </div>
  <div class="box-body no-padding" style="display: block;">
    <ul class="nav nav-pills nav-stacked">
      
      <li {{ isset($list_menu) &&  $list_menu == 'menu-5' ? 'class=active' : ''}} ><a href="{{ URL::to("customer-invoice-temp/5")}}">{{ trans('message.accounting.quotation') }}</a></li>

      @if(Helpers::has_permission(Auth::user()->id, 'manage_invoice_email_template'))
      <li {{ isset($list_menu) &&  $list_menu == 'menu-4' ? 'class=active' : ''}} ><a href="{{ URL::to("customer-invoice-temp/4")}}">{{ trans('message.email.sales_invoice') }}</a></li>
      @endif

      @if(Helpers::has_permission(Auth::user()->id, 'manage_payment_email_template'))
      <li {{ isset($list_menu) &&  $list_menu == 'menu-1' ? 'class=active' : ''}}><a href="{{ URL::to("customer-invoice-temp/1")}}">{{ trans('message.extra_text.payment_notification') }} </a></li>
      @endif
    </ul>
  </div>
            <!-- /.box-body -->
</div>
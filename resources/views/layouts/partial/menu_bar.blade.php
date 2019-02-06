<ul class="nav navbar-nav">
  <?php  
  	$id = Auth::guard('customer')->user()->debtor_no;
  ?>
  <li <?= isset($menu) && $menu == 'home' ? ' class="active"' : ''?> ><a href='{{url("customer/dashboard")}}'>{{ trans('message.customer_panel.home')}}</a></li>
  <li <?= isset($menu) && $menu == 'order' ? ' class="active"' : ''?> ><a href='{{url("customer-panel/order/$id")}}'>{{ trans('message.accounting.quotations')}}</a></li>
  <li  <?=isset($menu) && $menu == 'invoice' ? ' class="active"' : ''?> ><a href="{{url("customer-panel/invoice/$id")}}">{{ trans('message.customer_panel.invoices')}}</a></li>
  <li  <?=isset($menu) && $menu == 'payment' ? ' class="active"' : ''?> ><a href="{{url("customer-panel/payment/$id")}}">{{ trans('message.customer_panel.payments')}}</a></li>
  
</ul>
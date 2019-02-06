<!-- Profile Image -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">{{trans('message.header.general_setting')}}</h3>
  </div>
  <div class="box-body no-padding" style="display: block;">
    <ul class="nav nav-pills nav-stacked">
          
      @if(Helpers::has_permission(Auth::user()->id, 'manage_income_expense_category'))
      <li {{ isset($list_menu) &&  $list_menu == 'income-expense-category' ? 'class=active' : ''}} ><a href="{{ URL::to("income-expense-category/list")}}">{{ trans('message.sidebar.income-expense-category') }}</a></li>
      @endif

      @if(Helpers::has_permission(Auth::user()->id, 'manage_db_backup'))
      <li {{ isset($list_menu) &&  $list_menu == 'backup' ? 'class=active' : ''}}><a href="{{ URL::to("backup/list")}}">{{ trans('message.extra_text.db_backup') }}</a></li>
      @endif

      @if(Helpers::has_permission(Auth::user()->id, 'manage_email_setup'))
      <li {{ isset($list_menu) &&  $list_menu == 'email_setup' ? 'class=active' : ''}}><a href="{{ URL::to("email/setup")}}">{{ trans('message.extra_text.email_setup') }}</a></li>
      @endif
      
      @if(Helpers::has_permission(Auth::user()->id, 'manage_db_backup'))
      <li {{ isset($list_menu) &&  $list_menu == 'update_version' ? 'class=active' : ''}}><a href="{{ URL::to("update/version")}}">{{ trans('message.extra_text.update_version') }}</a></li>
      @endif
      
    </ul>
  </div>
  <!-- /.box-body  update_version-->
</div>
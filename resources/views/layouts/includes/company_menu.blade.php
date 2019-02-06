<!-- Profile Image -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">{{trans('message.header.company_setting')}}</h3>
  </div>
  <div class="box-body no-padding" style="display: block;">
    <ul class="nav nav-pills nav-stacked">
     
      @if(Helpers::has_permission(Auth::user()->id, 'manage_company_setting'))
      <li {{ isset($list_menu) &&  $list_menu == 'sys_company' ? 'class=active' : ''}}><a href="{{ URL::to("company/setting")}}">{{ trans('message.table.company_setting') }}</a></li>
      @endif
      
      @if(Helpers::has_permission(Auth::user()->id,'manage_team_member'))
      <li {{ isset($list_menu) &&  $list_menu == 'users' ? 'class=active' : ''}}><a href="{{ URL::to("users")}}">{{ trans('message.extra_text.team_member') }}</a></li>
      @endif
      
      @if(Helpers::has_permission(Auth::user()->id, 'manage_role'))
        <li {{ isset($list_menu) &&  $list_menu == 'role' ? 'class=active' : ''}}><a href="{{ URL::to("role/list")}}">{{ trans('message.extra_text.user_role') }}</a></li>
      @endif

      @if(Helpers::has_permission(Auth::user()->id, 'manage_role'))
        <li {{ isset($list_menu) &&  $list_menu == 'bank' ? 'class=active' : ''}}><a href="{{ URL::to("bank_account")}}">Dados Bancários</a></li>
      @endif
      
      @if(Helpers::has_permission(Auth::user()->id, 'manage_location'))
      <li {{ isset($list_menu) &&  $list_menu == 'location' ? 'class=active' : ''}}><a href="{{ URL::to("location")}}">{{ trans('message.extra_text.locations') }}</a></li>
      @endif

    </ul>
  </div>
  <!-- /.box-body -->
</div>
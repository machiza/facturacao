<!-- Profile Image -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Configuracao dos Item</h3>
  </div>
  <div class="box-body no-padding" style="display: block;">
    <ul class="nav nav-pills nav-stacked">
      
      
      <li {{ isset($list_menu) &&  $list_menu == 'category' ? 'class=active' : ''}} ><a href="{{ URL::to("item-category")}}">{{ trans('message.sidebar.item_category') }}</a></li>
     
     <li {{ isset($list_menu) &&  $list_menu == 'brand' ? 'class=active' : ''}} ><a href="{{ URL::to("item-brand")}}">{{ trans('message.sidebar.item_brand') }}</a></li>
     
      
      @if(Helpers::has_permission(Auth::user()->id, 'manage_unit'))
      <li {{ isset($list_menu) &&  $list_menu == 'unit' ? 'class=active' : ''}} ><a href="{{ URL::to("unit")}}">{{ trans('message.extra_text.units') }}</a></li>
      @endif


    </ul>
  </div>
  <!-- /.box-body  update_version-->
</div>
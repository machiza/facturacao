@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Top Box-->
      <div class="box">
        <div class="box-body">
          <strong>{{$itemInfo->description}}</strong>
        </div>
      </div><!--Top Box End-->
      <!-- Default box -->
      <div class="box">

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom" id="tabs">
            <ul class="nav nav-tabs">
              
              <li class="<?= ($tab=='item-info') ? 'active' :'' ?>"><a href="#tab_1" data-toggle="tab" aria-expanded="false">{{ trans('message.table.general_settings') }}</a></li>
              <li class="<?= ($tab=='sales-info') ? 'active' :'' ?>"><a href="#tab_2" data-toggle="tab" aria-expanded="false">{{ trans('message.table.sales_pricing') }}</a></li>
              <li class="<?= ($tab=='purchase-info') ? 'active' :'' ?>"><a href="#tab_3" data-toggle="tab" aria-expanded="true">{{ trans('message.table.purchase_pricing') }}</a></li>
              <li class="<?= ($tab=='transaction-info') ? 'active' :'' ?>"><a href="#tab_4" data-toggle="tab" aria-expanded="false">{{ trans('message.table.transctions') }}</a></li>
              <li class="<?= ($tab=='status-info') ? 'active' :'' ?>"><a href="#tab_5" data-toggle="tab" aria-expanded="true">{{ trans('message.table.status') }}</a></li>
            
            </ul>
            <div class="tab-content">
              <div class="tab-pane <?= ($tab=='item-info') ? 'active' :'' ?>" id="tab_1">
                <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center">{{ trans('message.table.item_info') }}</h4>
                  <form action="{{ url('update-item-info') }}" method="post" id="itemEditForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                    <input type="hidden" value="{{$itemInfo->id}}" name="id">
                    <div class="box-body">
                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.item_id') }}</label>
                        <div class="col-sm-9">
                          <input type="text" placeholder="{{ trans('message.form.item_id') }}" class="form-control" name="stock_id" value="{{$itemInfo->stock_id}}" readonly="true">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.item_name') }}</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="description" value="{{$itemInfo->description}}">
                        </div>
                      </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.brand') }}</label>
                      <div class="col-sm-9">
                        <select class="form-control select2" name="brand_id" id="brand">
                       
                        @foreach ($brandData as $data)
                           <option value="{{$data->id}}" <?= ($data->id==$itemInfo->brand_id)?'selected':''?>>{{$data->description}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.category') }}</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" name="category_id">
                         
                          @foreach ($categoryData as $data)
                            <option value="{{$data->category_id}}" <?= ($data->category_id==$itemInfo->category_id)?'selected':''?>>{{$data->description}}</option>
                          @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.unit') }}</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" name="units">
                          @foreach ($unitData as $data)
                            <option value="{{$data->name}}" <?= ($data->name==$itemInfo->units)?'selected':''?>>{{$data->name}}</option>
                          @endforeach
                          </select>
                        </div>
                      </div>    

                      <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.unit') }}</label>
                      <div class="col-sm-3">
                        <select class="form-control" name="units" id="unit">
                        @foreach ($unitData as $data)
                           <option value="{{$data->name}}" <?= ($data->name==$itemInfo->units)?'selected':''?>>{{$data->name}}</option>
                        @endforeach
                        </select>
                      </div>

                      <label class="col-sm-2 control-label require" for="inputEmail3">Tipo</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="tipo_servico" id="tipo_servico">
                         {{-- <option value="0">Item</option>
                          <option value="1">Servico</option>
                          <option value="2">Senha</option>
                          <option value="1">Combustivel</option>--}}

                            <option value="0" <?=isset($itemInfo->item_type_id) && $itemInfo->item_type_id ==  0? 'selected':""?> >Item</option>
                            <option value="1" <?=isset($itemInfo->item_type_id) && $itemInfo->item_type_id ==  1? 'selected':""?> >Servico</option>
                            <option value="2" <?=isset($itemInfo->item_type_id) && $itemInfo->item_type_id ==  2? 'selected':""?> >Senha</option>
                           <option value="0" <?=isset($itemInfo->item_type_id) && $itemInfo->item_type_id ==  3? 'selected':""?> >Combustivel</option>

                        </select>
                      </div>

                    </div>                  
                      

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3">Tipo de Item</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" name="units">
                          @foreach ($unitData as $data)
                            <option value="{{$data->name}}" <?= ($data->name==$itemInfo->units)?'selected':''?>>{{$data->name}}</option>
                          @endforeach
                          </select>
                        </div>
                      </div> 


                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.item_tax_type') }}</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" name="tax_type_id">
                        
                          @foreach ($taxTypes as $taxType)
                            <option value="{{$taxType->id}}" <?= ($taxType->id==$itemInfo->tax_type_id)?'selected':''?>>{{$taxType->name}}</option>
                          @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.item_des') }}</label>

                        <div class="col-sm-9">
                          <textarea placeholder="{{ trans('message.form.item_des') }} ..." rows="3" class="form-control" name="long_description">{{$itemInfo->long_description}}</textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.status') }}</label>

                        <div class="col-sm-9">
                          <select class="form-control valdation_select" name="inactive" >
                            
                            <option value="0" <?=isset($itemInfo->inactive) && $itemInfo->inactive ==  0? 'selected':""?> >Active</option>
                            <option value="1"  <?=isset($itemInfo->inactive) && $itemInfo->inactive == 1 ? 'selected':""?> >Inactive</option>
                          
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.picture') }}</label>
                        <div class="col-sm-9">
                          <input type="file" class="form-control input-file-field" name="item_image">
                          <br>
                          @if (!empty($itemInfo->item_image))
                          <img src='{{ url("public/uploads/itemPic/$itemInfo->item_image") }}' alt="Item Image" width="80" height="80">
                          @else
                          <img src='{{ url("public/uploads/default_product.jpg") }}' alt="Item Image" width="80" height="80">
                          @endif
                         <input type="hidden" name="pic" value="{{ $itemInfo->item_image ? $itemInfo->item_image : 'NULL' }}">
                            
                        <?php
                        $code = $itemInfo->stock_id; 
                        echo '<img width="150" src="data:image/png;base64,'.DNS1D::getBarcodePNG($code, "C128") . '" alt="barcode" class="bcimg"/>';
                        ?> 

                        </div>
                      </div>
                      
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <a href="{{ url('item') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                      <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                    </div>
                   
                    <!-- /.box-footer -->
                  </form>
              </div>
              </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane <?= ($tab=='sales-info') ? 'active' :'' ?>" id="tab_2">
                <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center"></h4>
                <div class="box-body">


                  <form action="{{ url('update-sale-price') }}" method="post" id="purchaseInfoForm" class="form-horizontal">
                    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                    <input type="hidden" value="{{$salesInfo->id}}" name="id">
                    <input type="hidden" value="{{$itemInfo->id}}" name="item_id">
                    <div class="box-body">
                                     
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('message.form.price') }} <span class="text-danger"> *</label>
                      <div class="col-sm-10">
                        <input type="text" placeholder="{{ trans('message.form.price') }}" class="form-control" name="price" value="{{isset($salesInfo->price) ? $salesInfo->price : 0}}" required="true">
                      </div>
                    </div>

                     <div class="form-group">
                      <label class="col-sm-2 control-label" for="inputEmail3">{{ trans('message.form.tax_info') }} <span class="text-danger"> </label>
                       
                           <div class="col-sm-2">
                              <label >
                               {{ trans('message.form.no') }}
                               @if($salesInfo->inclusao_iva==0)
                                <input type="radio" name="inclusao_iva" value="0" class="minimall" checked>
                               @else
                               <input type="radio" name="inclusao_iva" value="0" class="minimall"> 
                               @endif
                              </label>
                            </div>
                         <div class="col-sm-2">
                          <label>
                            {{ trans('message.form.yes') }}
                            @if($salesInfo->inclusao_iva==1)
                            <input type="radio" name="inclusao_iva" value="1" class="minimall" checked>
                           @else
                           <input type="radio" name="inclusao_iva" value="1" class="minimall"> 
                           @endif
                          </label>
                         </div>
                       <!--
                        <label class="col-sm-3">{{ trans('message.form.discount_percent') }} <span class="text-danger"> *</label>
                          <div class="col-sm-3">
                             <input type="text" placeholder="{{ trans('message.form.discount_percent') }}" class="form-control" name="discounto" value="{{isset($salesInfo->discounto) ? $salesInfo->discounto : 0}}" required="true">
                          </div>
                      -->
                    </div>    
                    
                    

                  </div>
                  <!-- /.box-body -->
                  
                  <div class="box-footer">
                    <a href="{{ url('item') }}" class="btn btn-primary btn-flat">{{ trans('message.form.cancel') }}</a>
                    <button class="btn btn-info pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                  </div>
                 
                  <!-- /.box-footer -->
                </form>



                </div>

              </div>
              </div>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane <?= ($tab=='purchase-info') ? 'active' :'' ?>" id="tab_3">
                <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center"></h4>
                  <form action="{{ url('update-purchase-price') }}" method="post" id="purchaseInfoForm" class="form-horizontal">
                    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                    <input type="hidden" value="{{$itemInfo->stock_id }}" name="stock_id">
                    <input type="hidden" value="{{$itemInfo->id}}" name="item_id">
                    <div class="box-body">
                                     
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.price') }} <span class="text-danger"> *</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.price') }}" class="form-control" name="price" value="{{isset($purchaseInfo->price) ? $purchaseInfo->price : 0}}">
                      </div>
                    </div>
                                                            
                  </div>
                  <!-- /.box-body -->
                 
                  <div class="box-footer">
                    <a href="{{ url('item') }}" class="btn btn-primary btn-flat">{{ trans('message.form.cancel') }}</a>
                    <button class="btn btn-info pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                  </div>
                 
                  <!-- /.box-footer -->
                </form>
              </div>
              </div>

              </div>
             
              <div style="min-height:200px" class="tab-pane <?= ($tab=='transaction-info') ? 'active' :'' ?>" id="tab_4">
                @if(count($transations)>0)
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">{{ trans('message.table.transaction_type')}}</th>
                      <th class="text-center">{{ trans('message.table.transaction_date')}}</th>
                      <th class="text-center">{{ trans('message.table.location')}}</th>
                      <th class="text-center">{{ trans('message.table.qty_in')}}</th>
                      <th class="text-center">{{ trans('message.table.qty_out')}}</th>
                      <th class="text-center">{{ trans('message.table.qty_on_hand')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sum = 0;
                    $StockIn = 0;
                    $StockOut = 0;
                    ?>
                    @foreach($transations as $result)
                    <tr>
                      <td align="center">
                        
                        @if($result->trans_type == PURCHINVOICE)
                          <a href="{{URL::to('/purchase/view-purchase-details/'.$result->transaction_reference_id)}}">Purchase</a>
                        @elseif($result->trans_type == SALESINVOICE)
                          <a href="{{URL::to('/invoice/view-detail-invoice/'.$result->order_no.'/'.$result->transaction_reference_id)}}">Sale</a>
                        @elseif($result->trans_type == STOCKMOVEIN)
                          <a href="{{URL::to('/transfer/view-details/'.$result->transaction_reference_id)}}">Transfer</a>
                        @elseif($result->trans_type == STOCKMOVEOUT)
                          <a href="{{URL::to('/transfer/view-details/'.$result->transaction_reference_id)}}">Transfer</a>
                        @endif

                      </td>
                      <td align="center">{{formatDate($result->tran_date)}}</td>
                      <td align="center">{{$result->location_name}}</td>
                      <td align="center">
                        @if($result->qty >0 )
                          {{$result->qty}}
                          <?php
                          $StockIn +=$result->qty;
                          ?>
                        @else
                        -
                        @endif
                      </td>
                      <td align="center">
                        @if($result->qty <0 )
                          {{str_ireplace('-','',$result->qty)}}
                          <?php
                          $StockOut +=$result->qty;
                          ?>
                        @else
                        -
                        @endif
                      </td>
                      <td align="center">{{$sum += $result->qty}}</td>
                    </tr>
                    @endforeach
                    <tr><td colspan="3" align="right">{{ trans('message.table.total')}}</td><td align="center">{{$StockIn}}</td><td align="center">{{str_ireplace('-','',$StockOut)}}</td><td align="center">{{$StockIn+$StockOut}}</td></tr>
                  </tbody>
                </table>
                @else
                <br>
                {{ trans('message.table.no_transaction')}}
                @endif

              </div>

          <!-- /.tab-pane status -->
              <div class="tab-pane <?= ($tab=='status-info') ? 'active' :'' ?>" id="tab_5">
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>{{ trans('message.table.location')}}</th>
                          <th>{{ trans('message.table.qty_available')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($locData))
                        <?php
                          $sum = 0;
                        ?>
                        @foreach ($locData as $data)
                        <tr>
                          <td>{{$data->location_name}}</td>
                          <td>{{getItemQtyByLocationName($data->loc_code,$salesInfo->stock_id)}}</td>
                        </tr>
                        <?php
                          $sum += getItemQtyByLocationName($data->loc_code,$salesInfo->stock_id); 
                        ?>
                       @endforeach
                       @endif
                       <tr><td align="right">{{ trans('message.invoice.total') }}</td><td>{{$sum}}</td></tr>
                        </tfoot>
                      </table>
                    </div>
                    </div>
                    </div>
              </div>
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        
          </div>
        <div class="clearfix"></div>
    </section>

    @include('layouts.includes.message_boxes')


@endsection
@section('js')
    <script type="text/javascript">
$(document).ready(function () {
// Item form validation
    $('#itemEditForm').validate({
        rules: {
            stock_id: {
                required: true
            },
            description: {
                required: true
            },
            category_id:{
               required: true
            },
            tax_type_id:{
               required: true
            }, 
            units:{
               required: true
            }                        
        }
    });
    // Sales form validation
    $('#salesInfoForm').validate({
        rules: {
            sales_type_id: {
                required: true
            },
            price: {
                required: true
            }                        
        }
    });

    // Purchse form validation
    $('#purchaseInfoForm').validate({
        rules: {
            supplier_id: {
                required: true
            },
            price: {
                required: true
            },
            suppliers_uom: {
                required: true
            }                                     
        }
    });

    $(".select2").select2({
       width: '100%'
    });


    $('.edit_type').on('click', function() {
      
        var id = $(this).attr("id");

        $.ajax({
            url: '{{ URL::to('edit-sale-price')}}',
            data:{  // data that will be sent
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
              
                $('#sales_type_id').val(data.sales_type_id);
                $('#price').val(data.price);
                $('#type_id').val(data.id);

                $('#edit-type-modal').modal();
            }
        });

    });

});

    </script>
@endsection
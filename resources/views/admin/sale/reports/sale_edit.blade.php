@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
        <h4 class="text-info">{{trans('message.invoice.invoice_no')}} # <a href="{{url('/invoice/view-detail-invoice/'.$inoviceInfo->order_reference_id.'/'.$saleData->order_no)}}">{{$inoviceInfo->reference}}</a></h4>
        <div class="clearfix"></div>

        <!--INICIO DO FORMULARIO {{url('sales/update')}}-->
        <form action="{{url('sales/update')}}" method="POST" id="salesForm">  
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" value="{{$saleData->order_no}}" name="order_no" id="order_no">
        <input type="hidden" value="{{$inoviceInfo->order_reference_id}}" name="order_reference_id" id="order_reference_id">
        <div class="row">
           
            <div class="col-md-3">
              <div class="form-group">
                <label for="exampleInputEmail1">{{ trans('message.form.customer') }}</label>
                <select class="form-control select2" name="debtor_no" id="customer">
                <option value="">{{ trans('message.form.select_one') }}</option>
                @foreach($customerData as $data)
                  <option value="{{$data->debtor_no}}" <?= ($data->debtor_no == $saleData->debtor_no) ? 'selected' : ''?> >{{$data->name}}</option>
                @endforeach
                </select>
                
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.form.from_location') }}</label>
                     <select class="form-control select2" name="from_stk_loc" id="loc">
                    @foreach($locData as $data)
                      <option value="{{$data->loc_code}}" <?= ($data->loc_code == $saleData->from_stk_loc ? 'selected':'')?>>{{$data->location_name}}</option>
                    @endforeach
                    </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>{{ trans('message.table.date') }}<span class="text-danger"> *</span></label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input  class="form-control" id="datepicker" type="text" name="ord_date" value="<?= isset($saleData->ord_date) ? formatDate($saleData->ord_date) :'' ?>">
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.extra_text.payment_method') }}</label>
                     <select class="form-control select2" name="payment_id">
                    
                    @foreach($payments as $payment)
                      <option value="{{$payment->id}}" <?= ($payment->id == $saleData->payment_id) ? 'selected' : ''?>>{{$payment->name}}</option>
                    @endforeach
                    </select>
              </div>
            </div>   
        

            <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.form.payment_term') }}</label>
                    <select class="form-control select2" name="payment_term">
                    @foreach($paymentTerms as $term)
                      <option value="{{$term->id}}" <?= ($term->id == $saleData->payment_term ? 'selected':'')?>>{{$term->terms}}</option>
                    @endforeach
                    </select>
              </div>
            </div> 

            <div class="col-md-3" style="display: none;">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.form.sales_type') }}</label>
                     <select class="form-control select2" name="sales_type" id="sales_type_id">
                    @foreach($salesType as $key=>$saleType)
                      <option value="{{$saleType->id}}" <?= ($saleType->id== 1 )?'selected':''?>>{{$saleType->sales_type}}</option>
                    @endforeach
                    </select>
              </div>
            </div>

            <!--REFERENCIA DA FACTURA:-->
            <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.table.reference') }}<span class="text-danger"> *</span></label>
                  <?php
                    $refArray = explode('-',$saleData->reference);
                  ?>
                <div class="input-group">
                   <div class="input-group-addon">{{ trans('message.table.inv') }}-</div>
                   <input id="reference_no" class="form-control" value="<?= isset($refArray[1]) ? $refArray[1] :'' ?>" type="text" readonly>
                   <input type="hidden"  name="reference" id="reference_no_write" value="{{$saleData->reference}}">
                </div>
              </div>
              <span id="errMsg" class="text-danger"></span>
            </div>
            <!--FIM-->

        </div>
        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.form.add_item') }}</label>
                  <input class="form-control auto" placeholder="{{ trans('message.invoice.search_item') }}" id="search">

                <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="no_div" tabindex="0" style="display: none; top: 60px; left: 15px; width: 520px;">
                <li>No record found!</li>
                </ul>

              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="table-responsive">
                <table class="table table-bordered" id="salesInvoice">
                  <tbody>

                  <tr class="tbl_header_color dynamicRows">
                    <th width="30%" class="text-center">{{ trans('message.table.description') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.rate') }}({{Session::get('currency_symbol')}})</th>
                    <th width="15%" class="text-center">{{ trans('message.table.tax') }}(%)</th>
                    <th width="10%" class="text-center">{{ trans('message.table.tax') }}({{Session::get('currency_symbol')}})</th>
                    <th width="10%" class="text-center">{{ trans('message.table.discount') }}(%)</th>
                    <th width="10%" class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                    <th width="5%"  class="text-center">{{ trans('message.table.action') }}</th>
                  </tr>
                  <?php
                    $taxTotal = 0;
                    $subTotalAmount = 0;
                  ?>
                  @if(count($invoiceData)>0)
                    @foreach($invoiceData as $result)
                        <?php
                            $priceAmount = ($result->quantity*$result->unit_price);
                            $discount = ($priceAmount*$result->discount_percent)/100;
                            $newPrice = ($priceAmount-$discount);
                            $tax = ($newPrice*$result->tax_rate/100);
                            $subTotalAmount += $newPrice;
                            $taxTotal += $tax;
                        ?>

                         <input type="hidden" name="stock_id[]" value="{{$result->stock_id}}">
                         

                        @if($result->is_inventory == 1)
                        <tr id="rowid{{$result->item_id}}">
                        <input type="hidden" name="item_rowid[]" value="{{$result->id}}">
                          <td class="text-center">{{$result->description}}<input type="hidden" name="description[]" value="{{$result->description}}"></td>
                          <td><input class="form-control text-center no_units" min="0" data-id="{{$result->item_id}}" data-rate="{{$result->unit_price}}" id="qty_{{$result->item_id}}" name="item_quantity[]" value="{{$result->quantity}}" type="text"></td>
                          <td class="text-center"><input min="0" class="form-control text-center unitprice" name="unit_price[]" data-id="{{$result->item_id}}" id="rate_id_{{$result->item_id}}" value="{{$result->unit_price}}" type="text"></td>
                          <td class="text-center">
                            <select class="form-control taxList" name="tax_id[]">
                            @foreach($tax_types as $item)
                              <option value="{{$item->id}}" taxrate="{{$item->tax_rate}}" <?= ($item->id == $result->tax_type_id ? 'selected':'')?>>{{$item->name}}({{$item->tax_rate}})</option>
                            @endforeach
                            </select>
                          </td>
                          <td class="text-center taxAmount">{{$tax}}</td>
                          <td class="text-center"><input class="form-control text-center discount" name="discount[]" data-input-id="{{$result->item_id}}" id="discount_id_{{$result->item_id}}" max="100" min="0" type="text" value="{{$result->discount_percent}}"></td>
                          <td><input amount-id="{{$result->item_id}}" class="form-control text-center amount" id="amount_{{$result->item_id}}" value="{{$newPrice}}" name="item_price[]" readonly type="text"></td>
                          <td class="text-center"><button id="{{$result->item_id}}" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>
                        </tr>
                        @else

                       <tr>
                       <input type="hidden" name="item_rowid[]" value="{{$result->id}}">
                        <td><input type='text' class='form-control text-center' name='description[]' value="{{$result->description}}" required></td>
                        <td><input type='text' class='form-control text-center custom_units' name='item_quantity[]' value='{{$result->quantity}}'></td>
                        <td><input type='text' class='form-control text-center custom_rate' name='unit_price[]' value='{{$result->unit_price}}'></td>
                        <td class="text-center">
                            <select class="form-control taxListCustom" name="tax_id[]">
                            @foreach($tax_types as $item)
                              <option value="{{$item->id}}" taxrate="{{$item->tax_rate}}" <?= ($item->id == $result->tax_type_id ? 'selected':'')?>>{{$item->name}}({{$item->tax_rate}})</option>
                            @endforeach
                            </select>
                          </td>
                        <td class='text-center taxAmount'>{{$tax}}</td>
                        <td><input type='text' class='form-control text-center custom_discount' name='discount[]' value='{{$result->discount_percent}}'></td>
                        <td><input type='text' class='form-control text-center amount custom_amount' name='item_price[]' value='{{$newPrice}}' readonly></td>
                        <td class='text-center'><button class='btn btn-xs btn-danger delete_item'><i class='glyphicon glyphicon-trash'></i></button></td>
                        </tr>

                        @endif

                      <?php
                        $stack[] = $result->item_id;
                      ?>

                    @endforeach

                  <tr class="custom-item"><td class="add-row text-danger"><strong>Add Custom Item</strong></td><td colspan="7"></td></tr>

                  <tr class="tableInfos"><td colspan="6" align="right"><strong>{{ trans('message.table.sub_total') }}({{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><strong id="subTotal"></strong></td></tr>
                  <tr class="tableInfos"><td colspan="6" align="right"><strong>{{ trans('message.invoice.totalTax') }}({{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><strong id="taxTotal">{{$taxTotal}}</strong></td></tr>

                  <!--TOTAL da tbl-->
                  <tr class="tableInfos"><td colspan="6" align="right">
                    <strong>{{ trans('message.table.grand_total') }}({{Session::get('currency_symbol')}})</strong>
                  </td>
                  <td align="left" colspan="2">
                    <input type='text' name="total" class="form-control" id = "grandTotal" value="{{($subTotalAmount+$taxTotal)}}" readonly>
                  </td>
                </tr>
                <!--FIM-->

                  @endif
                  </tbody>
                </table>
                </div>
                <br><br>
              </div>
            </div>
              <!-- /.box-body -->
              <div class="col-md-12">
              <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('message.table.note') }}</label>
                    <textarea placeholder="{{ trans('message.table.description') }} ..." rows="3" class="form-control" name="comments">{{$saleData->comments}}</textarea>
                </div>

                
                <a href="{{url('/sales/list')}}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                <!--BTN ENVIAR EDICAO DA FACTURA-->
                <button type="submit" class="btn btn-primary btn-flat pull-right" id="btnSubmit" name="btn_debito">{{ trans('message.form.submit') }}</button>
                <!--FIM-->

              </div>
        </div>
        </form>
        <!--FIM FORMULARIO-->
            <!-- /.col -->
            
            <!-- /.col -->
      </div>
          <!-- /.row -->
    </div>
        <!-- /.box-body -->
      <!-- /.box -->

    </section>
@endsection
@section('js')
    <script type="text/javascript">

    $(function() {
        $(document).on('click', function(e) {
            if (e.target.id === 'no_div') {
                $('#no_div').hide();
            } else {
                $('#no_div').hide();
            }

        })
    });

    var taxOptionList = "{!! $tax_type_new !!}";
    var taxOptionListCustom = "{!! $tax_type_custom !!}";

    $(document).ready(function(){
      var refNo ='SO-'+$("#reference_no").val();
      $("#reference_no_write").val(refNo);
      $("#customer").on('change', function(){
      var debtor_no = $(this).val();
      $.ajax({
        method: "POST",
        url: SITE_URL+"/sales/get-branches",
        data: { "debtor_no": debtor_no,"_token":token }
      })
        .done(function( data ) {
          var data = jQuery.parseJSON(data);
          if(data.status_no == 1){
            $("#branch").html(data.branchs);
          }
        });
      });
    });

    $(document).on('keyup', '#reference_no', function () {
        var ref = 'SO-'+$(this).val();
        $("#reference_no_write").val(ref);
      // Check Reference no if available
      $.ajax({
        method: "POST",
        url: SITE_URL+"/sales/reference-validation",
        data: { "ref": ref,"_token":token }
      })
        .done(function( data ) {
          var data = jQuery.parseJSON(data);
          if(data.status_no == 1){
            $("#errMsg").html("{{ trans('message.invoice.exist') }}");
          }else if(data.status_no == 0){
            $("#errMsg").html("{{ trans('message.invoice.available') }}");
          }
        });
    });


    function in_array(search, array)
    {
      for (i = 0; i < array.length; i++)
      {
        if(array[i] ==search )
        {
          return true;
        }
      }
        return false;
    }

    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2({

        });

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: '{{Session::get('date_format_type')}}'
        });

        $('.ref').val(Math.floor((Math.random() * 100) + 1));
       
    })

    var stack = [];
    var stack = <?php echo json_encode($stack); ?>;

    var token = $("#token").val();
    $( "#search" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{URL::to('sales/search')}}",
                dataType: "json",
                type: "POST",
                data: {
                    _token:token,
                    search: request.term,
                    salesTypeId:$("#sales_type_id").val()
                },
                success: function(data){
                  //Start
                    if(data.status_no == 1){
                    $("#val_item").html();
                     var data = data.items;
                     $('#no_div').css('display','none');
                    response( $.map( data, function( item ) {
                        return {
                            id: item.id,
                            stock_id: item.stock_id,
                            value: item.description,
                            units: item.units,
                            price: item.price,
                            tax_rate: item.tax_rate,
                            tax_id: item.tax_id
                        }
                    }));
                  }else{
                    $('.ui-menu-item').remove();
                    $("#no_div").css('display','block');
                  }
                  //end

                 }
            })
        },

        select: function(event, ui) {
          var e = ui.item;

          console.log(e);

          if(e.id) {
              if(!in_array(e.id, stack))
              {
                stack.push(e.id);
               var taxAmount = roundToTwo((e.price*e.tax_rate)/100);
                var new_row = '<tr id="rowid'+e.id+'">'+
                          '<td class="text-center">'+ e.value +'<input type="hidden" name="description_new[]" value="'+e.value+'"><input type="hidden" name="stock_id_new[]" value="'+e.stock_id+'"></td>'+
                          '<td> <input class="form-control text-center no_units" min="0" data-id="'+e.id+'" data-rate="'+ e.price +'" type="text" id="qty_'+e.id+'" name="item_quantity_new[]" value="1"><input type="hidden" name="item_id_new[]" value="'+e.id+'"></td>'+
                          '<td class="text-center"><input min="0"  type="text" class="form-control text-center unitprice" name="unit_price_new[]" data-id = "'+e.id+'" id="rate_id_'+e.id+'" value="'+ e.price +'"></td>'+
                          '<td class="text-center">'+ taxOptionList +'</td>'+
                          '<td class="text-center taxAmount">'+ taxAmount +'</td>'+
                          '<td class="text-center"><input type="text" class="form-control text-center discount" name="discount_new[]" data-input-id="'+e.id+'" id="discount_id_'+e.id+'" max="100" min="0" value="0"></td>'+
                          '<td><input class="form-control text-center amount" type="text" amount-id = "'+e.id+'" id="amount_'+e.id+'" value="'+e.price+'" name="item_price_new[]" readonly></td>'+
                          '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>'+
                          '</tr>';
                
                //$(new_row).insertAfter($('table tr.dynamicRows:last'));
                 $("table tbody .custom-item").before(new_row);
                 
                $(function() {
                    $("#rowid"+e.id+' .taxList').val(e.tax_id);
                });
                var taxRateValue = roundToTwo(parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate')));

                // Calculate subtotal
                var subTotal = calculateSubTotal();
                $("#subTotal").html(subTotal);

                // Calculate Grand Total
                var taxTotal = calculateTaxTotal();
                $("#taxTotal").text(taxTotal);
                var grandTotal = (subTotal + taxTotal);
                $("#grandTotal").val(roundToTwo(grandTotal));
                $('.tableInfo').show();

              } else {
                 
                  $('#qty_'+e.id).val( function(i, oldval) {
                      return ++oldval;
                  });
                  
                  var q = $('#qty_'+e.id).val();
                  var r = $("#rate_id_"+e.id).val();

                $('#amount_'+e.id).val( function(i, amount) {
                    var result = q*r; 
                    var amountId = $(this).attr("amount-id");
                    var qty = parseFloat($("#qty_"+amountId).val());
                    var unitPrice = parseFloat($("#rate_id_"+amountId).val());
                    var discountPercent = roundToTwo(parseFloat($("#discount_id_"+amountId).val())/100);
                    if(isNaN(discountPercent)){
                      discountPercent = 0;
                    }
                    var discountAmount = qty*unitPrice*discountPercent;
                    var newPrice = parseFloat([(qty*unitPrice)-discountAmount]);
                    return newPrice;
                });
               
               var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));
               var amountByRow = $('#amount_'+e.id).val(); 
               var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
              
               $("#rowid"+e.id+" .taxAmount").text(taxByRow);

                // Calculate subTotal
                var subTotal = calculateSubTotal();
                $("#subTotal").html(subTotal);
                // Calculate taxTotal
                var taxTotal = calculateTaxTotal();
                $("#taxTotal").text(taxTotal);
                // Calculate GrandTotal
                var grandTotal = (subTotal + taxTotal);
                $("#grandTotal").val(roundToTwo(grandTotal));

              }
              
              $(this).val('');
              $('#val_item').html('');
              return false;
          }
        },
        minLength: 1,
        autoFocus: true
    });


    $(document).on('change keyup blur','.check',function() {
      var row_id = $(this).attr("id").substr(2);
      var disc = $(this).val();
      var amd = $('#a_'+row_id).val();

      if (disc != '' && amd != '') {
        $('#a_'+row_id).val((parseFloat(amd)) - (parseFloat(disc)));
      } else {
        $('#a_'+row_id).val(parseFloat(amd));
      }
      
    });

    $(document).ready(function() {
          $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
          });
        });

    // price calcualtion with quantity
     $(document).ready(function(){
       $('.tableInfo').hide();
      });

     // calculate amount with item quantity
    $(document).on('keyup', '.no_units', function(ev){
      var id = $(this).attr("data-id");
      var qty = parseInt($(this).val());
      var order_no = $("#order_no").val();
      var reference = $("#reference").val();
      var token = $("#token").val();
      var from_stk_loc = $("#loc").val();
      // check item quantity in store location after sale

      if(isNaN(qty)){
          qty = 0;
       }
       
      var rate = $("#rate_id_"+id).val();
      
      var price = calculatePrice(qty,rate);  

      var discountRate = parseFloat($("#discount_id_"+id).val());     
      if(isNaN(discountRate)){
          discountRate = 0;
       }
      var discountPrice = calculateDiscountPrice(price,discountRate); 
      $("#amount_"+id).val(discountPrice);


       var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
       var amountByRow = $('#amount_'+id).val(); 
       var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
       $("#rowid"+id+" .taxAmount").text(taxByRow);
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").html(subTotal);


      // Calculate GrandTotal
      var grandTotal = (subTotal + taxTotal);
      $("#grandTotal").val(roundToTwo(grandTotal));

    });

     // calculate amount with discount
    $(document).on('keyup', '.discount', function(ev){
     
      var discount = parseFloat($(this).val());

      if(isNaN(discount)){
          discount = 0;
       }
     
      var id = $(this).attr("data-input-id");
      var qty = $("#qty_"+id).val();
      var rate = $("#rate_id_"+id).val();
      var discountRate = $("#discount_id_"+id).val();

      var price = calculatePrice(qty,rate); 
      var discountPrice = calculateDiscountPrice(price,discountRate);       
      $("#amount_"+id).val(discountPrice);

     var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
     var amountByRow = $('#amount_'+id).val(); 
     var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
     $("#rowid"+id+" .taxAmount").text(taxByRow);

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").html(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal + taxTotal);
      $("#grandTotal").val(roundToTwo(grandTotal));

    });


     // calculate amount with unit price
    $(document).on('keyup', '.unitprice', function(ev){
     
      var unitprice = parseFloat($(this).val());

      if(isNaN(unitprice)){
          unitprice = 0;
       }
     
      var id = $(this).attr("data-id");
      var qty = $("#qty_"+id).val();
      var rate = $("#rate_id_"+id).val();
      var discountRate = $("#discount_id_"+id).val();

      var price = calculatePrice(qty,rate);  
      var discountPrice = calculateDiscountPrice(price,discountRate);     
      $("#amount_"+id).val(discountPrice);

     var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
     var amountByRow = $('#amount_'+id).val(); 
     var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
     $("#rowid"+id+" .taxAmount").text(taxByRow);

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").html(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal + taxTotal);
      $("#grandTotal").val(roundToTwo(grandTotal));

    });

    $(document).on('change', '.taxList', function(ev){
      var taxRateValue = $(this).find(':selected').attr('taxrate');
      var rowId = $(this).closest('tr').prop('id');
      var amountByRow = $("#"+rowId+" .amount").val(); 
      
      var taxByRow = roundToTwo(amountByRow*taxRateValue/100);

      $("#"+rowId+" .taxAmount").text(taxByRow);

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").html(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal + taxTotal);
      $("#grandTotal").val(roundToTwo(grandTotal));

    });

    // Delete item row
    $(document).ready(function(e){
      $('#salesInvoice').on('click', '.delete_item', function() {
            var v = $(this).attr("id");
            stack = jQuery.grep(stack, function(value) {
              return value != v;
            });
            
            $(this).closest("tr").remove();

            var taxRateValue = parseFloat( $("#rowid"+v+' .taxList').find(':selected').attr('taxrate'));
           var amountByRow = $('#amount_'+v).val(); 
           var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
           $("#rowid"+v+" .taxAmount").text(taxByRow);
            
            var subTotal = calculateSubTotal();
            $("#subTotal").html(subTotal);
            
            var taxTotal = calculateTaxTotal();
            $("#taxTotal").text(taxTotal);
            // Calculate GrandTotal
            var grandTotal = (subTotal + taxTotal);
            $("#grandTotal").val(roundToTwo(grandTotal));           

        });

    });
      
      /**
      * Calcualte Total tax
      *@return totalTax for row wise
      */
      function calculateTaxTotal (){
          var totalTax = 0;
            $('.taxAmount').each(function() {
                totalTax += parseFloat($(this).text());
            });
            return roundToTwo(totalTax);
      }
      
      /**
      * Calcualte Sub Total 
      *@return subTotal
      */
      function calculateSubTotal (){
        var subTotal = 0;
        $('.amount').each(function() {
            subTotal += parseFloat($(this).val());
        });
        return roundToTwo(subTotal);
      }
      /**
      * Calcualte price
      *@return price
      */
      function calculatePrice (qty,rate){
         var price = (qty*rate);
         return roundToTwo(price);
      }   
      // calculate tax 
      function caculateTax(p,t){
       var tax = (p*t)/100;
       return roundToTwo(tax);
      }   


      // calculate discont amount
      function calculateDiscountPrice(p,d){
        var discount = [(d*p)/100];
        var result = (p-discount); 
        return roundToTwo(result);
      }

// Item form validation
    $('#salesForm').validate({
        rules: {
            debtor_no: {
                required: true
            },
            from_stk_loc: {
                required: true
            },
            ord_date:{
               required: true
            },
            reference:{
              required:true
            },
            payment_id:{
              required:true
            },
            branch_id:{
              required:true
            }                    
        }
    });

    $(document).ready(function(){
        var subTotal = calculateSubTotal();
        $("#subTotal").text(subTotal);
      });

// Custom product line add
    $(".add-row").click(function(){

    var markup ="<tr>"
    +"<td><input type='text' class='form-control text-center' name='custom_items_name_new[]' required></td>"
    +"<td><input type='text' class='form-control text-center custom_units' name='custom_items_qty_new[]' value='1'></td>"
    +"<td><input type='text' class='form-control text-center custom_rate' name='custom_items_rate_new[]' value='0'></td>"
    +"<td>" +taxOptionListCustom+ "</td>"
    +"<td class='text-center taxAmount'>0</td>"
    +"<td><input type='text' class='form-control text-center custom_discount' name='custom_items_discount_new[]' value='0'></td>"
    +"<td><input type='text' class='form-control text-center amount custom_amount' name='custom_items_amount_new[]' value='0' readonly></td>"
    +"<td class='text-center'><button class='btn btn-xs btn-danger delete_item'><i class='glyphicon glyphicon-trash'></i></button></td>"
    +"</tr>";

    $("table tbody .custom-item").before(markup);

    });

    // Change the item quantity
    $(document).on('keyup','.custom_units', function(){
    var qty = $(this).val();
    var rate = $(this).parents('tr').find('input.custom_rate').val();
    var taxRate = $(this).parents('tr').find('.taxListCustom').find(':selected').attr('taxrate');
    var discountRate = $(this).parents('tr').find('input.custom_discount').val();
    
    var price = calculatePrice(qty,rate);  
    var discountPrice = calculateDiscountPrice(price,discountRate);     
    var taxAmount = roundToTwo((discountPrice*taxRate)/100);
    $(this).parents('tr').find('input.custom_amount').val(discountPrice);
    $(this).parents('tr').find('.taxAmount').text(taxAmount);

    var subTotal = calculateSubTotal();
    $("#subTotal").html(subTotal);
      // Calculate taxTotal
    var taxTotal = calculateTaxTotal();
    $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
    var grandTotal = (subTotal + taxTotal);
    $("#grandTotal").val(roundToTwo(grandTotal));
    });

    // Change the item rate
    $(document).on('keyup','.custom_rate', function(){
    var rate = $(this).val();
    var qty = $(this).parents('tr').find('input.custom_units').val();
    var taxRate = $(this).parents('tr').find('.taxListCustom').find(':selected').attr('taxrate');
    var discountRate = $(this).parents('tr').find('input.custom_discount').val();
    
    var price = calculatePrice(qty,rate);  
    var discountPrice = calculateDiscountPrice(price,discountRate);
     
    var taxAmount = roundToTwo((discountPrice*taxRate)/100);
    $(this).parents('tr').find('input.custom_amount').val(discountPrice);
    $(this).parents('tr').find('.taxAmount').text(taxAmount);

    var subTotal = calculateSubTotal();
    $("#subTotal").html(subTotal);
      // Calculate taxTotal
    var taxTotal = calculateTaxTotal();
    $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
    var grandTotal = (subTotal + taxTotal);
    $("#grandTotal").val(roundToTwo(grandTotal));
    });

    // Change the discount
    $(document).on('keyup','.custom_discount', function(){
    var discountRate = $(this).val();
    var qty = $(this).parents('tr').find('input.custom_units').val();
    var taxRate = $(this).parents('tr').find('.taxListCustom').find(':selected').attr('taxrate');
    var rate = $(this).parents('tr').find('input.custom_rate').val();
    
    var price = calculatePrice(qty,rate);  
    var discountPrice = calculateDiscountPrice(price,discountRate);     
    var taxAmount = roundToTwo((discountPrice*taxRate)/100);
    $(this).parents('tr').find('input.custom_amount').val(discountPrice);
    $(this).parents('tr').find('.taxAmount').text(taxAmount);

    var subTotal = calculateSubTotal();
    $("#subTotal").html(subTotal);
      // Calculate taxTotal
    var taxTotal = calculateTaxTotal();
    $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
    var grandTotal = (subTotal + taxTotal);
    $("#grandTotal").val(roundToTwo(grandTotal));
    });
    
    // Change the tax type
    $(document).on('change', '.taxListCustom', function(ev){

      var taxRate = $(this).parents('tr').find(':selected').attr('taxrate');
      var amount = $(this).parents('tr').find('input.amount').val(); 
      var taxAmount = roundToTwo(amount*taxRate/100);
      $(this).parents('tr').find('.taxAmount').text(taxAmount);

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").html(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal + taxTotal);
      $("#grandTotal").val(roundToTwo(grandTotal));

    });
/// Craete Round Figure
function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}

    </script>
@endsection
@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
    <div class="row">
      
      <div class="col-md-12">
        <div class="box box-default">
           <div class="box-header">
              <h4 class="text-info ">{{ trans('message.accounting.quotation')}} # <a href="{{url('order/view-order-details/'.$saleData->order_no)}}">{{$saleData->reference}}</a></h4>
            </div>
        <!-- /.box-header -->
        <div class="box-body">

        <form action="{{url('order/update')}}" method="POST" id="salesForm">  
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" value="{{$saleData->order_no}}" name="order_no" id="order_no">
        <input type="hidden" value="{{$saleData->reference}}" id="reference">

        <input type="text" name="customer_new" id="customer_new" value="" hidden>
        <input type="text" name="customer_Old_id" id="customer_Old_id" value="{{$saleData->debtor_no}}" hidden>
        <input type="text" name="customer_new_nuit" id="customer_new_nuit" value=""  hidden>
        <input type="text" name="customer_new_telemovel" id="customer_new_telemovel" value="" hidden>
        <input type="text" name="tipocliente" id="tipocliente" value="" hidden>

        <input type="number" id="imposto" value="" hidden>
        <input type="number" id="discounto" value="" hidden>
        <input type="number" id="contagem" value="" hidden>


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

            @if($clienteGenerico=="yes")
            <div class="col-md-1">
              <div class="form-group">
                 <label for="exampleInputEmail1">{{ trans('message.form.customer') }}<span class="text-danger"> *</span>
                 </label>
                 <button title="{{ trans('message.invoice.cancel')}}" type="button" class="form-control btn btn-default btn-flat Danger-btn" data-toggle="modal" data-target="#Register_customer">edit{{-- trans('message.form.add_new_customer')--}}
                </button>
              </div>
            </div>
             @endif
            <div id="dados">
              <div id="dados_cliente">
                

              </div>
           </div>


          </div>

         <div class="row">
          <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.table.reference') }}<span class="text-danger"> *</span></label>
                  <?php
                    $refArray = explode('-',$saleData->reference);
                  ?>
                <div class="input-group">
                   <div class="input-group-addon">COT-</div>
                   <input id="reference_no" class="form-control" value="<?= isset($refArray[1]) ? $refArray[1] :'' ?>" type="text" readonly>
                   <input type="hidden"  name="reference" id="reference_no_write" value="">
                </div>
              </div>
              <span id="errMsg" class="text-danger"></span>
            </div>

            <div class="col-md-3" style="display: none;">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.form.sales_type') }}</label>
                     <select class="form-control select2" name="sales_type" id="sales_type_id">
                    @foreach($salesType as $key=>$saleType)
                      <option value="{{$saleType->id}}" <?= ($saleType->defaults== 1 )?'selected':''?>>{{$saleType->sales_type}}</option>
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
                  <input class="form-control" id="datepicker" type="text" name="ord_date" value="<?= isset($saleData->ord_date) ? formatDate($saleData->ord_date) :'' ?>">
                </div>
                <!-- /.input group -->
              </div>
            </div>
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
            <div class="col-md-3">
            </div> 
            <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">Requisicao</label>
                  <input class="form-control auto" placeholder="Nr Requisicao" name="requisicao" id="requisicao" value="{{$saleData->requisicao}}">
              </div>
            </div>      
        </div>


        <div class="row">
          <div class="col-md-12">
            <div class="text-center" id="quantityMessage" style="color:red; font-weight:bold">
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="table-responsive">
               
                <table class="table table-bordered" id="purchaseInvoice">
                  <tbody>
                     <tr class="tbl_header_color dynamicRows">
                    <th width="30%" class="text-center">{{ trans('message.table.description') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.rate') }}({{Session::get('currency_symbol')}})</th>
                    <th width="10%" class="text-center">{{ trans('message.table.tax') }}(%)</th>
                    <th width="10%" class="text-center">{{ trans('message.table.tax') }}({{Session::get('currency_symbol')}})</th>
                    <th width="5%" class="text-center">({{ trans('message.table.tax_incluso')}})</th>
                    <th width="7.5%" class="text-center">{{ trans('message.table.discount') }}(%)</th>
                    <th width="12.5%" class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
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
                             
                             if($result->taxa_inclusa_valor=='no'){
                                $preco=$result->unit_price;
                             }else{

                                $precoDesconto=($newPrice/$result->quantity)+$tax;
                                //$preco=$result->unit_price;
                                $Des=1-$result->discount_percent/100;
                                
                                $preco= $precoDesconto/$Des; 

                             }
                        ?>
                        
                        
                        @if($result->is_inventory == 1)
                         <tr id="rowid{{$result->item_id}}" class="linha">
                           <input type="hidden" name="stock_id[]" value="{{$result->stock_id}}">
                         <input type="hidden" name="item_rowid[]" value="{{$result->id}}">
                          <td class="text-center">{{$result->description}}

                            <input type="hidden" name="description[]" value="{{$result->description}}">
                          </td>

                          <td>
                              <input class="form-control text-center unidades no_units" min="0" data-id="{{$result->item_id}}" data-rate="{{$result->unit_price}}" id="qty_{{$result->item_id}}" name="item_quantity[]" value="{{$result->quantity}}" type="text">
                               <input type='hidden' name='item_id[]' value="{{$result->item_id}}">
                          </td>
                          <td class="text-center">
                            <input min="0" class="form-control text-center unitprice percentagem" name="unit_price[]" data-id="{{$result->item_id}}" id="rate_id_{{$result->item_id}}" value="{{number_format($preco,2,'.','')}}" type="text"></td>

                          <td class="text-center">
                            <select class="form-control taxList taxa" name="tax_id[]">
                            @foreach($tax_types as $item)
                              <option value="{{$item->id}}" taxrate="{{$item->tax_rate}}" <?= ($item->id == $result->tax_type_id ? 'selected':'')?>>{{$item->name}}({{$item->tax_rate}})</option>
                            @endforeach
                            </select>
                          </td>
                          <td class="text-center taxAmount">{{number_format($tax,2,'.','')}}</td>
                          <td class="text-center">
                            @if($result->taxa_inclusa_valor=='no')
                            <input type="checkbox" value="" name="inclusao[]" data-input-id_check="{{$result->item_id}}" class="inclusaos checkitem" value="zero"><input class="pegar" type="hidden" value="no" name="taxainclusa[]">
                            @else
                              <input type="checkbox" value="" name="inclusao[]" data-input-id_check="{{$result->item_id}}" class="inclusaos checkitem" checked value="zero"><input class="pegar" type="hidden" value="yes" name="taxainclusa[]">
                            @endif
                          </td>


                          <td class="text-center"><input class="form-control text-center discount disconto" name="discount[]" data-input-id="{{$result->item_id}}" id="discount_id_{{$result->item_id}}" max="100" min="0" type="text" value="{{$result->discount_percent}}"></td>
                          <td><input amount-id="{{$result->item_id}}" class="form-control text-center amount" id="amount_{{$result->item_id}}" value="{{number_format($newPrice,2,'.','')}}" name="item_price[]" readonly type="text"></td>
                          <td class="text-center"><button id="{{$result->item_id}}" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>
                        </tr>

                        @else

                       <tr id="rowid{{$result->item_id}}" class="linha">
                          <input type="hidden" name="item_rowid[]" value="{{$result->id}}">
                          
                          <td>
                            <input type="hidden" name="stock_id[]" value="{{$result->stock_id}}">
                            @if($result->item_id==null)
                              <input type='text' class='form-control text-center' name='description[]' value="{{$result->description}}" required>
                            @else
                              {{$result->description}}
                              <input type="hidden" name="description[]" value="{{$result->description}}">
                            @endif
                            </td>
                          <td>
                            <input type='text' class='form-control text-center custom_units unidades' name='item_quantity[]' value='{{$result->quantity}}'>
                            <input type='hidden' name='item_id[]' value="{{$result->item_id}}">
                          </td>
                        <td>
                          <input type='text' class='form-control text-center custom_rate percentagem' name='unit_price[]' value='{{number_format($preco,2,'.','')}}'>
                        </td>
                        <td class="text-center">
                            <select class="form-control taxListCustom taxa" name="tax_id[]">
                            @foreach($tax_types as $item)
                              <option value="{{$item->id}}" taxrate="{{$item->tax_rate}}" <?= ($item->id == $result->tax_type_id ? 'selected':'')?>>{{$item->name}}({{$item->tax_rate}})</option>
                            @endforeach
                            </select>
                          </td>
                        <td class='text-center taxAmount'>{{number_format($tax,2,'.','')}}</td>

                        <td class='text-center'>
                           @if($result->taxa_inclusa_valor=='no')
                          <input type='checkbox'  name='inclusao[]' class='checkitem inclusaos' value="no">
                          <input type='hidden' <input class='pegar' value='no' name="taxainclusa[]">
                          @else
                          <input type='checkbox'  name='inclusao[]' class='checkitem inclusaos' checked value="yes">
                          <input type='hidden' <input class='pegar' value='yes' name="taxainclusa[]">
                          @endif
                          </td>

                        <td><input type='text' class='form-control text-center custom_discount disconto' name='discount[]' value='{{$result->discount_percent}}'></td>
                        <td><input type='text' class='form-control text-center amount custom_amount' name='item_price[]' value='{{number_format($newPrice,2,'.','')}}' readonly></td>
                        <td class='text-center'><button class='btn btn-xs btn-danger delete_item'><i class='glyphicon glyphicon-trash'></i></button></td>
                        </tr>

                        @endif
                      <?php
                        $stack[] = $result->item_id;
                      ?>

                     
                    
                    @endforeach

                  @endif

                  <tr class="custom-item"><td class="add-row text-danger"><strong>Add Custom Item</strong></td><td colspan="7"></td></tr>

                  <tr class="tableInfo"><td colspan="7" align="right"><strong>{{ trans('message.table.sub_total') }}({{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><strong id="subTotal">{{number_format($subTotalAmount,2,'.','')}}</strong></td></tr>

                  <tr class="tableInfo"><td colspan="7" align="right"><strong>{{ trans('message.table.discount')}}{{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><strong id="Descount"></strong></td></tr>

                  <tr class="tableInfo"><td colspan="7" align="right"><strong>{{ trans('message.invoice.totalTax') }}({{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><strong id="taxTotal">{{number_format($taxTotal,2,'.','')}}</strong></td></tr>

                 
                  <!--total:-->
                  <tr class="tableInfo">
                    <td colspan="7" align="right">
                      <strong>{{ trans('message.table.grand_total') }}({{Session::get('currency_symbol')}})</strong>
                    </td>
                    <td align="left" colspan="2">
                      <input type='text' name="total" class="form-control" id = "grandTotal" value="{{number_format($subTotalAmount+$taxTotal,2,'.','')}}"  readonly>

                      

                    </td>
                  </tr>

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
                <a href="{{url('/order/list')}}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                <button type="submit" class="btn btn-primary btn-flat pull-right" id="btnSubmit">{{ trans('message.form.submit') }}</button>
              </div>
        </div>
        </form>
      </div>
          <!-- /.row -->
    </div>


           <!-- Cancel Order Modal -->
  <div class="modal fade" id="Register_customer" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('message.form.add_new_customer') }}</h4>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" id="payForm" action="#" method="POST">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                      
          <input type="hidden" name="orderInvoiceId" value="#">
          

           <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.table.name') }}</label>
            <div class="col-sm-6">
              <input type="text" name="nome_customer"  class="form-control" id="nome_customer" placeholder="{{ trans('message.table.name') }}" >
            </div>
          </div>
          
          <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.table.nuit') }}</label>
            <div class="col-sm-6">
              <input type="text" name="nuit_customer" id="nuit_customer" placeholder="{{ trans('message.table.nuit') }}"  class="form-control" >
            </div>
          </div>

          <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.table.phone') }}  </label>
            <div class="col-sm-6">
              <input type="text" name="telemovel_customer"  class="form-control" id="telemovel_customer" placeholder="{{ trans('message.table.phone') }}" >
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-Normal btn-flat" id="cancelar_cadastro" data-dismiss='modal'>{{ trans('message.form.cancel') }}</button>
              <button type="submit" class="btn btn-sucess btn-flat" id="cadastro">{{ trans('message.form.submit')}}</button>
           </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

<!-- /.box-body -->
  <!-- /.box -->
   <div class='modal fade' id='actualizar' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
            <h4 class='modal-title' id='myModalLabel'>Imformação do Cliente</h4>
          </div>
          <div class='modal-body'>
                <h4>{{trans('message.table.customer_detales')}}</h4>
            </div><!-- modal body -->
          
      <div class='box-footer'>
          <div class='form-group'>
            <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Cancelar</button>
             <button type='submit' class='btn crud-submit btn-primary pull-right' id="comfirmar">Sim</button>
          </div>  
        </div>
      </div>
    </div>
 </div> 
  <!--Pay Modal End-->
</section>

@endsection

@section('js')
<script src="{{asset('public/dist/js/cotacao.js')}}"></script>

<script type="text/javascript">
  var stack = [];

  $(function() {
      $(document).on('click', function(e) {
          if (e.target.id === 'no_div') {
              $('#no_div').hide();
          } else {
              $('#no_div').hide();
          }

      })
  });

    var taxOptionList = "{!! $tax_type !!}";
    var taxOptionListCustom = "{!! $tax_type_custom !!}";
   
    $(document).ready(function(){
      var refNo ='COT-'+$("#reference_no").val();

      $("#reference_no_write").val(refNo);

      var elementos="{!! $elementos !!}"
      var elementos_novos=elementos.split('/'); 

      $("#nome_customer").val("{!! $estadoCliente->name !!}");
      $("#nuit_customer").val("{!! $estadoCliente->nuit !!}");
      $("#telemovel_customer").val("{!! $estadoCliente->phone !!}");


         for (i = 0; i < elementos_novos.length-1; i++) {
            stack.push(elementos_novos[i]);
        }   
        // alert(stack[3]);


      /*$("#customer").on('change', function(){
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
      */


    });



    $('#Register_customer').on('shown.bs.modal', function (e) {
      $("#nome_customer").val("{!! $estadoCliente->name !!}");
      $("#nuit_customer").val("{!! $estadoCliente->nuit !!}");
      $("#telemovel_customer").val("{!! $estadoCliente->phone !!}");
   })

    
    $(document).on('keyup', '#reference_no', function () {
        var val = $(this).val();

        if(val == null || val == ''){
         $("#errMsg").html("{{ trans('message.invoice.exist') }}");
          $('#btnSubmit').attr('disabled', 'disabled');
          return;
         }else{
          $('#btnSubmit').removeAttr('disabled');
         }

        var ref = 'COT-'+$(this).val();
        $("#reference_no_write").val(ref);
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
        $(".select2").select2({});

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: '{{Session::get('date_format_type')}}'
        });

        $('.ref').val(Math.floor((Math.random() * 100) + 1));
       
         $('#datepicker').datepicker('update', new Date());
    })

    
    var token = $("#token").val();

    $( "#search" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{URL::to('order/search')}}",
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
                            tax_id: item.tax_id,
                            inclusao_iva:item.inclusao_iva
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
          var desconto=0;

          if(e.id) {

            if($('#discounto').val()!=""){

               var desconto=parseFloat($('#discounto').val());
            }else{
              desconto = 0;
            }
          
              var impost= $('#imposto').val();
              var imposto= parseFloat(impost);

            //alert('i have just arrived');

              if(!in_array(e.id, stack))
              {
                stack.push(e.id);
               
                var taxAmount = roundToTwo((e.price*e.tax_rate)/100);

                  //produto com iva incluso
                 if(e.inclusao_iva==1)
                 {    

                 

                     var ValorSemTaxa1=e.price/(1+((e.tax_rate/100)));
                     var taxAmount = roundToTwo((ValorSemTaxa1*e.tax_rate)/100); 
                       if(imposto==1){
                        taxAmount=0;
                      } 
                    //
                    var valor='valor';

                     var new_row = '<tr id="rowid'+e.id+'" class="linha">'+
                          '<td class="text-center">'+ e.value +'<input type="hidden" name="stock_id[]" value="'+e.stock_id+'"><input type="hidden" name="description[]" value="'+e.value+'"></td>'+
                          '<td><input class="form-control text-center unidades no_units" min="0" data-id="'+e.id+'" type="text" id="qty_'+e.id+'" name="item_quantity[]" value="1"><input type="hidden" name="item_id[]" value="'+e.id+'"></td>'+
                          '<td class="text-center"><input min="0"  type="text" class="form-control text-center unitprice percentagem" name="unit_price[]" data-id = "'+e.id+'" id="rate_id_'+e.id+'" value="'+ e.price +'"></td>'+
                          
                          '<td class="text-center">'+ taxOptionList +'</td>'+
                          '<td class="text-center taxAmount">'+ taxAmount +'</td>'+
                          '<td class="text-center"><input type="checkbox" value="" name="inclusao[]" data-input-id_check="'+e.id+'"  class="inclusaos checkitem" checked value="'+valor+'"><input <input class="pegar" type="hidden" value="yes" name="taxainclusa[]"></td>'+
                          '<td class="text-center"><input type="text" class="form-control text-center discount disconto" name="discount[]" data-input-id="'+e.id+'" id="discount_id_'+e.id+'" max="100" min="0" value="'+desconto+'"></td>'+
                          '<td><input class="form-control text-center amount" type="text" amount-id = "'+e.id+'" id="amount_'+e.id+'" value="'+e.price+'" name="item_price[]" readonly></td>'+
                          '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>'+
                          '</tr>';
                }else {      
                

                        // clientes insetos do imposto
                        if(imposto==1){
                             taxAmount=0;
                        } 
                 var zero='zero';         

                 var new_row = '<tr id="rowid'+e.id+'" class="linha">'+
                          '<td class="text-center">'+ e.value +'<input type="hidden" name="stock_id[]" value="'+e.stock_id+'"><input type="hidden" name="description[]" value="'+e.value+'"></td>'+
                          '<td><input class="form-control text-center unidades no_units" min="0" data-id="'+e.id+'" type="text" id="qty_'+e.id+'" name="item_quantity[]" value="1"><input type="hidden" name="item_id[]" value="'+e.id+'"></td>'+
                          '<td class="text-center"><input min="0"  type="text" class="form-control text-center unitprice percentagem" name="unit_price[]" data-id = "'+e.id+'" id="rate_id_'+e.id+'" value="'+ e.price +'"></td>'+
                          
                          '<td class="text-center">'+ taxOptionList +'</td>'+
                          '<td class="text-center taxAmount">'+ taxAmount +'</td>'+
                          '<td class="text-center"><input type="checkbox" value="" name="inclusao[]" data-input-id_check="'+e.id+'" class="inclusaos checkitem" value="'+zero+'"><input class="pegar" type="hidden" value="no" name="taxainclusa[]"></td>'+
                          '<td class="text-center"><input type="text" class="form-control text-center discount disconto" name="discount[]" data-input-id="'+e.id+'" id="discount_id_'+e.id+'" max="100" min="0" value="'+desconto+'"></td>'+
                          '<td><input class="form-control text-center amount" type="text" amount-id = "'+e.id+'" id="amount_'+e.id+'" value="'+e.price+'" name="item_price[]" readonly></td>'+
                          '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>'+
                          '</tr>';        
              }        
                
              // adicionando a linha
              $("table tbody .custom-item").before(new_row);
              //contagem  
              $("#contagem").val(1);
                 
                // Sha@dy add
                var discountValue = calculateDiscountAmountt();
                $("#Descount").text(discountValue);
        
                 
                  var q = $('#qty_'+e.id).val();
                  var r = $("#rate_id_"+e.id).val();
                
                    $('#amount_'+e.id).val( function(i, amount) {
                    var result = q*r;
   

                      $(function() {
                      $("#rowid"+e.id+' .taxList').val(e.tax_id);
                      });  


                      //O imposto
                      if(imposto==1){
                        $("#rowid"+e.id+' .taxList').val(imposto);
                      }

                   
                      var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));
                      // funcao caso o checkox esteja activo
                      if($("#rowid"+e.id+' .checkitem').prop('checked')==true){
                                  
                          var amountId = $(this).attr("amount-id");
                          var qty = parseFloat($("#qty_"+amountId).val());
                          var unitPrice = parseFloat($("#rate_id_"+amountId).val());
                          var discountPercent = parseFloat($("#discount_id_"+amountId).val())/100;
                          if(isNaN(discountPercent)){
                            discountPercent = 0;
                          }
                          
                          var VarDoIva=ValorSemTaxa*(taxRateValue/100);
                          var ValorSemTaxa=unitPrice/(1+((taxRateValue/100)));
                        
                           var discountAmount = qty*ValorSemTaxa*discountPercent;
                           var newPrice = parseFloat(ValorSemTaxa-discountAmount);
                            console.log("taxRateValue  "+taxRateValue+"valorSem taxa    "+ValorSemTaxa+"descontos "+discountAmount+"new price is "+newPrice);

                      }else{ 

                          var amountId = $(this).attr("amount-id");
                          var qty = parseFloat($("#qty_"+amountId).val());
                          var unitPrice = parseFloat($("#rate_id_"+amountId).val());
                          var discountPercent = parseFloat($("#discount_id_"+amountId).val())/100;
                          if(isNaN(discountPercent)){
                            discountPercent = 0;
                          }
                          var discountAmount = qty*unitPrice*discountPercent;
                          var newPrice = parseFloat([(q*unitPrice)-discountAmount]);

                      }

                          
                    return newPrice.toFixed(2);
                });





                  $(function() {
                  $("#rowid"+e.id+' .taxList').val(e.tax_id);
                  });

                  //O imposto
                  if(imposto==1){
                  $("#rowid"+e.id+' .taxList').val(imposto);
                  } 

                var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));

                // Calculate subtotal
                var subTotal = calculateSubTotal();
                $("#subTotal").html(subTotal);

                // Calculate Grand Total
                var taxTotal = calculateTaxTotal();
                $("#taxTotal").text(taxTotal);

                // Sha@dy add
                var discountValue = calculateDiscountAmountt();
                $("#Descount").text(discountValue);
    

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
                    var discountPercent = parseFloat($("#discount_id_"+amountId).val())/100;
                    if(isNaN(discountPercent)){
                      discountPercent = 0;
                    }
                    //
                     $(function() {
                      $("#rowid"+e.id+' .taxList').val(e.tax_id);
                      });  
                        
                      //O imposto
                      if(imposto==1){
                        $("#rowid"+e.id+' .taxList').val(imposto);
                      }  

                      var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));

                      if($("#rowid"+e.id+' .checkitem').prop('checked')==true){
                          console.log('iva incluido no produto');

                          var amountId = $(this).attr("amount-id");
                          var qty = parseFloat($("#qty_"+amountId).val());
                          var unitPrice = parseFloat($("#rate_id_"+amountId).val());
                          var discountPercent = parseFloat($("#discount_id_"+amountId).val())/100;
                          if(isNaN(discountPercent)){
                            discountPercent = 0;
                          }
                          
                              var VarDoIva=ValorSemTaxa*(taxRateValue/100);
                              var ValorSemTaxa=unitPrice/(1+((taxRateValue/100)));

                              //var discountAmount = qty*unitPrice*discountPercent;
                              //var newPrice = parseFloat([(q*unitPrice)-discountAmount]);

                              var discountAmount = qty*ValorSemTaxa*discountPercent;
                              var newPrice = parseFloat(ValorSemTaxa-discountAmount);

                              //
                              var result = q*r; 
                              var amountId = $(this).attr("amount-id");
                              var qty = parseFloat($("#qty_"+amountId).val());
                              var unitPrice = parseFloat($("#rate_id_"+amountId).val());
                              var discountPercent = parseFloat($("#discount_id_"+amountId).val())/100;
                              if(isNaN(discountPercent)){
                              discountPercent = 0;
                              }
                              // funcao para actualizar apois a primeira insercao
                              var discountAmount = qty*unitPrice*discountPercent;
                              var newPrice = parseFloat([(q*unitPrice)-discountAmount]);
                              return newPrice;
                              }else{
                              console.log('Nao incluido');
                              var discountAmount = qty*unitPrice*discountPercent;
                              var newPrice = parseFloat([(q*unitPrice)-discountAmount]);
                              return newPrice;

                         }


                          var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));
                          console.log("o valor da taxa eh o seguinte "+taxRateValue);

                });
               
                   var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));
                    
                   var amountByRow = $('#amount_'+e.id).val(); 
                   var qty = $("#qty_"+e.id).val();
                   if(isNaN(qty)){
                        qty = 0;
                   }

                  var discountRate = parseFloat($("#discount_id_"+e.id).val());     
                  if(isNaN(discountRate)){
                    discountRate = 0;
                  }

                   //console.log(amountByRow);
                   //var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
                   //$("#rowid"+e.id+" .taxAmount").text(taxByRow);
  

                    var ValorSemTaxaUnitario=amountByRow/(1+((taxRateValue/100)));
                    var price = calculatePrice(qty,ValorSemTaxaUnitario);
                   

                    var discountPrice = calculateDiscountPrice(amountByRow,discountRate); 
                    //$("#amount_"+e.id).val(discountPrice);
                    // done by albert
                    var taxAmount = roundToTwo((ValorSemTaxaUnitario*taxRateValue)/100); 
                    
                    $("#rowid"+e.id+" .taxAmount").text(taxAmount); 
                    //$("#amount_").text(ValorSemTaxaUnitario); 
                     $("#amount_"+e.id).val(ValorSemTaxaUnitario.toFixed(2)); 



                    // Calculate subTotal
                    var subTotal = calculateSubTotal();
                    $("#subTotal").html(subTotal);
                    // Calculate taxTotal
                    var taxTotal = calculateTaxTotal();
                     $("#taxTotal").text(taxTotal);
                    // Calculate GrandTotal
                    var grandTotal = (subTotal + taxTotal);
                    $("#grandTotal").val(roundToTwo(grandTotal));

                     // Sha@dy add
                    var discountValue = calculateDiscountAmountt();
                    $("#Descount").text(discountValue);
        
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
        $('#a_'+row_id).val((parseInt(amd)) - (parseInt(disc)));
      } else {
        $('#a_'+row_id).val(parseInt(amd));
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
    /* $(document).ready(function(){
       $('.tableInfo').hide();
      });*/

     // calculate amount with item quantity
   // calculate amount with item quantity
    $(document).on('keyup', '.no_units', function(ev){
      var id = $(this).attr("data-id");
      var qty = parseInt($(this).val());
      if(isNaN(qty)){
          qty = 0;
       }
      var rate = $("#rate_id_"+id).val();
      var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));

      var discountRate = parseFloat($("#discount_id_"+id).val());     
      if(isNaN(discountRate)){
          discountRate = 0;
      }

      if($("#rowid"+id+' .checkitem').prop('checked')==true){ 
          
          var ValorSemTaxaUnitario=rate/(1+((taxRateValue/100)));
          var price = calculatePrice(qty,ValorSemTaxaUnitario);


          var discountPrice = calculateDiscountPrice(price,discountRate); 
          $("#amount_"+id).val(discountPrice);

          // done by albert
          var taxAmount = roundToTwo((discountPrice*taxRateValue)/100); 
           $("#rowid"+id+" .taxAmount").text(taxAmount);  

                       
       }
      else{
            var price = calculatePrice(qty,rate);
            var discountPrice = calculateDiscountPrice(price,discountRate); 
            $("#amount_"+id).val(discountPrice);
            var amountByRow = $('#amount_'+id).val(); 
            var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
            $("#rowid"+id+" .taxAmount").text(taxByRow);
     }

            // Calculate subTotal
            var subTotal = calculateSubTotal();
            $("#subTotal").html(subTotal);
            // Calculate taxTotal
            var taxTotal = calculateTaxTotal();
            $("#taxTotal").text(taxTotal);
            // Calculate GrandTotal
            var grandTotal = (subTotal + taxTotal);
            $("#grandTotal").val(roundToTwo(grandTotal));

          // Sha@dy add
            var discountValue = calculateDiscountAmountt();
            $("#Descount").text(discountValue);

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
      var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));

      if($("#rowid"+id+' .checkitem').prop('checked')==true){ 
          
         
          var ValorSemTaxaUnitario=rate/(1+((taxRateValue/100)));
          var price = calculatePrice(qty,ValorSemTaxaUnitario);
          var discountPrice = calculateDiscountPrice(price,discountRate); 
          $("#amount_"+id).val(discountPrice);

          // done by albert
          var taxAmount = roundToTwo((discountPrice*taxRateValue)/100); 
           $("#rowid"+id+" .taxAmount").text(taxAmount); 


       }else{
            var price = calculatePrice(qty,rate); 
            var discountPrice = calculateDiscountPrice(price,discountRate);       
            $("#amount_"+id).val(discountPrice);
             var amountByRow = $('#amount_'+id).val(); 
             var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
             $("#rowid"+id+" .taxAmount").text(taxByRow);
        }

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").html(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal + taxTotal);
      $("#grandTotal").val(roundToTwo(grandTotal));

      // Sha@dy add
      var discountValue = calculateDiscountAmountt();
      $("#Descount").text(discountValue);
    

    console.log("function=> id"+id+" quantity "+qty+" discountRate "+discountRate+" rate "+rate);

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
      var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));

       if($("#rowid"+id+' .checkitem').prop('checked')==false){ 
       
        var price = calculatePrice(qty,rate);  
        var discountPrice = calculateDiscountPrice(price,discountRate);     
        $("#amount_"+id).val(discountPrice);

        
        var amountByRow = $('#amount_'+id).val(); 
        var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
        $("#rowid"+id+" .taxAmount").text(taxByRow);
      }

       if($("#rowid"+id+' .checkitem').prop('checked')==true){ 
          
          var ValorSemTaxaUnitario=rate/(1+((taxRateValue/100)));
          var price = calculatePrice(qty,ValorSemTaxaUnitario);
          var discountPrice = calculateDiscountPrice(price,discountRate); 
          $("#amount_"+id).val(discountPrice);

          // done by albert
          var taxAmount = roundToTwo((discountPrice*taxRateValue)/100); 
           $("#rowid"+id+" .taxAmount").text(taxAmount); 
       }

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").html(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal + taxTotal);
      $("#grandTotal").val(roundToTwo(grandTotal));

    // Sha@dy add
      var discountValue = calculateDiscountAmountt();
      $("#Descount").text(discountValue);


    });

    $(document).on('change', '.taxList', function(ev){
      var taxRateValue = $(this).find(':selected').attr('taxrate');
      var rowId = $(this).closest('tr').attr('id');
      var linhaCorrente=$(this).closest('tr');  


        var id = rowId.match(/\d+/); 
        console.log("row id is   "+id);
        var qty = $("#qty_"+id).val();
        var rate = $("#rate_id_"+id).val();
        var discountRate = $("#discount_id_"+id).val(); 
         var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));       




        if($("#rowid"+id+' .checkitem').prop('checked')==false){ 

          var price = calculatePrice(qty,rate);  
          var discountPrice = calculateDiscountPrice(price,discountRate);     
          $("#amount_"+id).val(discountPrice);
          var amountByRow = $('#amount_'+id).val(); 
          var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
          $("#rowid"+id+" .taxAmount").text(taxByRow);

         //   var amountByRow = $("#"+idid+" .amount").val(); 
           // var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
            console.log("o logotipo "+id);
        }
        

        if($("#rowid"+id+' .checkitem').prop('checked')==true){ 


          var ValorSemTaxaUnitario=rate/(1+((taxRateValue/100)));
          var price = calculatePrice(qty,ValorSemTaxaUnitario);
          var discountPrice = calculateDiscountPrice(price,discountRate); 
          $("#amount_"+id).val(discountPrice);
          // done by albert
          var taxAmount = roundToTwo((discountPrice*taxRateValue)/100); 
           $("#rowid"+id+" .taxAmount").text(taxAmount); 
           console.log("the discount price is  "+discountPrice);
       }

      $("#"+id+" .taxAmount").text(taxByRow);
      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").html(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal + taxTotal);
      $("#grandTotal").val(roundToTwo(grandTotal));
      // Sha@dy add
      var discountValue = calculateDiscountAmountt();
      $("#Descount").text(discountValue);

    });

    // Delete item row
    $(document).ready(function(e){
      $('#purchaseInvoice').on('click', '.delete_item', function() {
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

            var discountValue = calculateDiscountAmountt();
            $("#Descount").text(discountValue);           

        });
    });
      
      /**
      * Calculando os discontos
      */
      

             /**
      * Calcualte the discount amount 
      *sh@dy
      
        stiill doing
      */
      function calculateDiscountAmountt(){
        var totalDescount = 0;
        
        $('.disconto').each(function() {

       var taxRateValue = parseFloat( $('.taxa').find(':selected').attr('taxrate'));
        var p = $(this).parents('tr').find('.percentagem').val();
        var d = $(this).parents('tr').find('.disconto').val();
        var unidade = $(this).parents('tr').find('.unidades').val();
        var subtotal=d*unidade;
        var discount = [(subtotal*p)/100];
         
        
          if($(this).parents('tr').find('.checkitem').prop('checked')==true){ 
           var  valor= $(this).parents('tr').find('.amount').val();
           var valorPorUnidade=valor/unidade;
           var ValorLinha=valorPorUnidade*unidade;
            var ValorSemTaxaUnitario=p/(1+((taxRateValue/100)));
            var price = calculatePrice(unidade,ValorSemTaxaUnitario);

           var discont= price-valor;
           var ValorDescontado=valorPorUnidade+ discont;
           //$(this).parents('tr').find('.amount').val(ValorDescontado);
           totalDescount=totalDescount+parseFloat(discont);

          console.log("on valor eh "+valor+"valorPorUnidade  "+valorPorUnidade+" valor ValorLinha "+ValorLinha+" ValorSemTaxaUnitario "+ValorSemTaxaUnitario+" unidade "+unidade+"the discont is "+discont+" valor se totalDescount "+totalDescount+" taxRateValue "+taxRateValue);

           // console.log("on preco eh  ..."+valor+"por unidade eh "+valorPorUnidade+" valor ValorDescontado "+ValorDescontado+" valor da linha "+ValorLinha+" unidade "+unidade+"the price is "+price+" valor se taxa "+ValorSemTaxaUnitario);



          }else{
              //console.log("o valor e o preco eh e desconto e "+p+" =="+d);
              totalDescount=totalDescount+parseFloat(discount);
              //subTotal += parseFloat($(this).val());
          }});

        return roundToTwo(totalDescount);
      }




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

/* Item form validation
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

*/

    // Custom product line add
     var zero="zero"
     $(".add-row").click(function(){
    var markup ='<tr class="linha">'
    +"<td><input type='hidden' name='stock_id[]' value='zero'><input type='text' class='form-control text-center' name='description[]' required></td>"
    +"<td><input type='text' class='form-control text-center custom_units unidades' name='item_quantity[]' value='1'><input type='hidden' name='item_id[]' value='zero'></td>"
    +"<td><input type='text' class='form-control text-center custom_rate percentagem' name='unit_price[]' value='0'></td>"
    +"<td>" +taxOptionListCustom+ "</td>"
    +"<td class='text-center taxAmount'>0</td>"
    +"<td class='text-center'><input type='checkbox'  name='inclusao[]' class='checkitem inclusaos' value='"+zero+"'><input type='hidden' <input class='pegar' value='no' name='taxainclusa[]'</td>"
    
    +"<td><input type='text' class='form-control text-center custom_discount disconto' name='discount[]' value='"+ $('#discounto').val()+"'></td>"
    +"<td><input type='text' class='form-control text-center amount custom_amount' name='item_price[]' value='0' readonly></td>"
    +"<td class='text-center'><button class='btn btn-xs btn-danger delete_item'><i class='glyphicon glyphicon-trash'></i></button></td>"
    +"</tr>";

    $("table tbody .custom-item").before(markup);
    $('.tableInfo').show();

    //contagem  
    $("#contagem").val(1);    
          //console.log("o desconto eh de "+desconto);
    });


    
    // Change the item quantity
    $(document).on('keyup','.custom_units', function(){
    var qty = $(this).val();
    var rate = $(this).parents('tr').find('input.custom_rate').val();
    var taxRate = $(this).parents('tr').find('.taxListCustom').find(':selected').attr('taxrate');
    var discountRate = $(this).parents('tr').find('input.custom_discount').val();
     var qty = $(this).parents('tr').find('input.custom_units').val();    
      //alert('todos dadods devem estar aqui');

        if($(this).parents('tr').find('.checkitem').prop('checked')==false){ 
        var price = calculatePrice(qty,rate);  
        var discountPrice = calculateDiscountPrice(price,discountRate);
        var taxAmount = roundToTwo((discountPrice*taxRate)/100);
        $(this).parents('tr').find('input.custom_amount').val(discountPrice);
        $(this).parents('tr').find('.taxAmount').text(taxAmount);
         console.log("taxa nao incluida no valor !!! the taxrate is "+ taxRate) ;
      }

      if($(this).parents('tr').find('.checkitem').prop('checked')==true){ 
       
 
          var ValorSemTaxaUnitario=rate/(1+((taxRate/100)));
          var price = calculatePrice(qty,ValorSemTaxaUnitario);
          var discountPrice = calculateDiscountPrice(price,discountRate);
          $(this).parents('tr').find('input.custom_amount').val(discountPrice);
          var taxAmount = roundToTwo((discountPrice*taxRate)/100); 
          $(this).parents('tr').find('.taxAmount').text(taxAmount);
          console.log("Taxa incluida no valor colocado do prpoduto ") ;


       }


    var subTotal = calculateSubTotal();
    $("#subTotal").html(subTotal);
      // Calculate taxTotal
    var taxTotal = calculateTaxTotal();
    $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
    var grandTotal = (subTotal + taxTotal);
    $("#grandTotal").val(roundToTwo(grandTotal));

    //var discountValue = calculateDiscountAmount(price,discountRate);
    var discountValue = calculateDiscountAmountt();
    $("#Descount").text(discountValue);  

    });


    

    // Change the item rate
    $(document).on('keyup','.custom_rate', function(){
    var rate = $(this).val();
    var qty = $(this).parents('tr').find('input.custom_units').val();
    var taxRate = $(this).parents('tr').find('.taxListCustom').find(':selected').attr('taxrate');
    var discountRate = $(this).parents('tr').find('input.custom_discount').val();
    

      if($(this).parents('tr').find('.checkitem').prop('checked')==false){ 
        console.log("Taxa nao incluida no valor ") ;
        var price = calculatePrice(qty,rate);  
        var discountPrice = calculateDiscountPrice(price,discountRate);     
        var taxAmount = roundToTwo((discountPrice*taxRate)/100);
        $(this).parents('tr').find('input.custom_amount').val(discountPrice);
        $(this).parents('tr').find('.taxAmount').text(taxAmount);
     }


      if($(this).parents('tr').find('.checkitem').prop('checked')==true){ 
         var ValorSemTaxaUnitario=rate/(1+((taxRate/100)));
          var price = calculatePrice(qty,ValorSemTaxaUnitario);
          var discountPrice = calculateDiscountPrice(price,discountRate);
          $(this).parents('tr').find('input.custom_amount').val(discountPrice);
          var taxAmount = roundToTwo((discountPrice*taxRate)/100); 
          $(this).parents('tr').find('.taxAmount').text(taxAmount);
          console.log("Taxa incluida no valor colocado do prpoduto ") ;
    }
    



    var subTotal = calculateSubTotal();
    $("#subTotal").html(subTotal);
      // Calculate taxTotal
    var taxTotal = calculateTaxTotal();
    $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
    var grandTotal = (subTotal + taxTotal);
    $("#grandTotal").val(roundToTwo(grandTotal));

    var discountValue = calculateDiscountAmountt();
    $("#Descount").text(discountValue);
    
    });

    // Change the discount
    $(document).on('keyup','.custom_discount', function(){
    var discountRate = $(this).val();
    var qty = $(this).parents('tr').find('input.custom_units').val();
    var taxRate = $(this).parents('tr').find('.taxListCustom').find(':selected').attr('taxrate');
    var rate = $(this).parents('tr').find('input.custom_rate').val();
    

      if($(this).parents('tr').find('.checkitem').prop('checked')==false){ 

        var price = calculatePrice(qty,rate);  
        var discountPrice = calculateDiscountPrice(price,discountRate); 
        var taxAmount = roundToTwo((discountPrice*taxRate)/100);
        $(this).parents('tr').find('input.custom_amount').val(discountPrice);
        $(this).parents('tr').find('.taxAmount').text(taxAmount);

        //edited by shady descontando    
        //var discountValue = calculateDiscountAmount(price,discountRate); 
        console.log("Taxa nao incluida no valor ") ;
      }


      if($(this).parents('tr').find('.checkitem').prop('checked')==true){ 
          var ValorSemTaxaUnitario=rate/(1+((taxRate/100)));
          var price = calculatePrice(qty,ValorSemTaxaUnitario);
          var discountPrice = calculateDiscountPrice(price,discountRate);
          $(this).parents('tr').find('input.custom_amount').val(discountPrice);
          var taxAmount = roundToTwo((discountPrice*taxRate)/100); 
          $(this).parents('tr').find('.taxAmount').text(taxAmount);
          console.log("Taxa incluida no valor colocado do prpoduto ") ;






    }

    var discountValue = calculateDiscountAmountt();
    $("#Descount").text(discountValue);
    
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
      var qty = $(this).parents('tr').find('input.custom_units').val();
      var discountRate = $(this).parents('tr').find('input.custom_discount').val();

      if($(this).parents('tr').find('.checkitem').prop('checked')==false){ 
        var amount = $(this).parents('tr').find('input.amount').val(); 
        var taxAmount = roundToTwo(amount*taxRate/100);
        $(this).parents('tr').find('.taxAmount').text(taxAmount);
        console.log("Taxa nao incluida no valor ") ;
      }

      if($(this).parents('tr').find('.checkitem').prop('checked')==true){ 

           var rate = $(this).parents('tr').find('input.custom_rate').val();
           var ValorSemTaxaUnitario=rate/(1+((taxRate/100)));
          var price = calculatePrice(qty,ValorSemTaxaUnitario);
          var discountPrice = calculateDiscountPrice(price,discountRate);
          $(this).parents('tr').find('input.custom_amount').val(discountPrice);
          var taxAmount = roundToTwo((discountPrice*taxRate)/100); 
          $(this).parents('tr').find('.taxAmount').text(taxAmount);
          console.log("Taxa incluida no valor colocado do prpoduto ") ;
      }

     

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
    
    
    
          // novas funcionalidades 
      $('#purchaseInvoice').on('change', '.checkitem', function() {
                      
                var id = $(this).attr("data-input-id_check");

              
                 if(isNaN(id)){

                    console.log("codigo nao defenido trata se de dados vindos do user customer");
                    var discountRate = $(this).parents('tr').find('input.custom_discount').val();
                    var qty = $(this).parents('tr').find('input.custom_units').val();
                    var taxRate = $(this).parents('tr').find('.taxListCustom').find(':selected').attr('taxrate');
                    var rate = $(this).parents('tr').find('input.custom_rate').val();
                     

                      if($(this).parents('tr').find('.checkitem').prop('checked')==false){ 
                        console.log("Taxa nao incluida no valor ") ;
                        var price = calculatePrice(qty,rate);  
                        var discountPrice = calculateDiscountPrice(price,discountRate);     
                        var taxAmount = roundToTwo((discountPrice*taxRate)/100);
                        $(this).parents('tr').find('input.custom_amount').val(discountPrice);
                        $(this).parents('tr').find('.taxAmount').text(taxAmount);
                        $(this).parents('tr').find('.pegar').val("No");
                        $mostar=  $(this).parents('tr').find('.pegar').val();
                        console.log("o valor idem eh "+$mostar);
                      }


                      if($(this).parents('tr').find('.checkitem').prop('checked')==true){ 
                        var ValorSemTaxaUnitario=rate/(1+((taxRate/100)));
                        var price = calculatePrice(qty,ValorSemTaxaUnitario);
                        var discountPrice = calculateDiscountPrice(price,discountRate);
                        $(this).parents('tr').find('input.custom_amount').val(discountPrice);
                        var taxAmount = roundToTwo((discountPrice*taxRate)/100); 
                        $(this).parents('tr').find('.taxAmount').text(taxAmount);
                        $mostar=  $(this).parents('tr').find('.pegar').val();
                        $(this).parents('tr').find('.pegar').val("yes");
                        console.log("Taxa incluida no valor colocado do prpoduto ") ;
                        console.log("o valor idem eh "+$mostar);
                      }


                 }else{

                    //dados vindo do search
                     console.log("dados do search");
                    var discount = parseFloat($(this).val());
                    if(isNaN(discount)){
                    discount = 0;
                    } 
                   
                    var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
                    var qty = $("#qty_"+id).val();
                    var rate = $("#rate_id_"+id).val();
                    var discountRate = $("#discount_id_"+id).val();
                    var ValorSemTaxaUnitario=rate/(1+((taxRateValue/100)));
                    var price = calculatePrice(qty,ValorSemTaxaUnitario);

                        if($(this).prop('checked')==false){ 

                            var price = calculatePrice(qty,rate);  
                            var discountPrice = calculateDiscountPrice(price,discountRate);     
                            $("#amount_"+id).val(discountPrice);
                            var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
                            var amountByRow = $('#amount_'+id).val(); 
                            var taxByRow = roundToTwo(amountByRow*taxRateValue/100);
                            $("#rowid"+id+" .taxAmount").text(taxByRow);
                            console.log("\n\n\n\n\n\n\n\n\n\n\n\n");
                            console.log('Deselecionados checkbox ');

                             $mostar=   $("#rowid"+id+" .pegar").val();
                             console.log("o valor idem eh "+$mostar);
                            $(this).parents('tr').find('.pegar').val("no");
                       
                        }

                        if($(this).prop('checked')==true){

                             console.log("\n\n\n\n\n\n\n\n\n\n\n\n");
                            console.log(' Selecionado o checkbox ');

                            var discountPrice = calculateDiscountPrice(price,discountRate);
                            $("#amount_"+id).val(discountPrice);
                            // done by albert
                            var taxAmount = roundToTwo((discountPrice*taxRateValue)/100); 
                            $("#rowid"+id+" .taxAmount").text(taxAmount);  
                             $(this).parents('tr').find('.pegar').val("yes");
                             $mostar=   $("#rowid"+id+" .pegar").val();
                            
                            console.log("o valor idem eh "+$mostar+ "o taxrate is "+taxRateValue+"o rate eh "+rate);
                            console.log("Taxa incluida no valor colocado do prpoduto ") ;
                            console.log('o preco eh o seguinte '+price+"o desconto eh de "+discountPrice+"o tax rete eh "+taxRateValue+"rate "+rate);
                        }
                 } 

            // Calculate subTotal
              var subTotal = calculateSubTotal();
              $("#subTotal").html(subTotal);
              // Calculate taxTotal
              var taxTotal = calculateTaxTotal();
              $("#taxTotal").text(taxTotal);
              // Calculate GrandTotal
              var grandTotal = (subTotal + taxTotal);
              $("#grandTotal").val(roundToTwo(grandTotal));

              // Sha@dy add
              var discountValue = calculateDiscountAmountt();
              $("#Descount").text(discountValue);                  
      });


    /// Craete Round Figure
    function roundToTwo(num) {    
        return +(Math.round(num + "e+2")  + "e-2");
    }

</script>
@endsection
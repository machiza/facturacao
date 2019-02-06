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
        <form action="{{url('order/save')}}" method="POST" id="salesForm">  
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="text" name="customer_new" id="customer_new" value="" hidden>
        <input type="text" name="customer_new_nuit" id="customer_new_nuit" value=""  hidden>
        <input type="text" name="customer_new_telemovel" id="customer_new_telemovel" value="" hidden>
        <input type="text" name="tipocliente" id="tipocliente" value="" hidden>
 
        <input type="number" id="imposto" value="" hidden>
        <input type="number" id="discounto" value="" hidden>
        <input type="number" id="contagem" value="" hidden>
        <input type="text" id="informacao" value="{{ trans('message.form.notificacao') }}" hidden>



        <div class="row">
            
            <div class="col-md-3">
              <!-- /.form-group -->
              <div class="form-group">
                <label for="exampleInputEmail1">{{ trans('message.form.customer') }}<span class="text-danger"> *</span></label>
                <select  id="customer" name="debtor_no" class="form-control select2">
              <option value="">{{ trans('message.form.select_one') }}</option>
                @foreach($customerData as $data)
                  <option value="{{$data->debtor_no}}">{{$data->name}}</option>
                @endforeach
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            
            <div class="col-md-1">
              <div class="form-group">
                 <label for="exampleInputEmail1">{{ trans('message.form.customer') }}<span class="text-danger"> *</span>
                 </label>
                 <button title="{{ trans('message.invoice.cancel')}}" type="button" class="form-control btn btn-default btn-flat Danger-btn" data-toggle="modal" data-target="#Register_customer">+{{-- trans('message.form.add_new_customer')--}}
                </button>
              </div>
            </div>

            <div class="row">
            <div class="col-md-1" style="width:100px">
              <div class="form-group">
                  <label for="exampleInputEmail1">Moeda<span class="text-danger"> *</span></label>
                 <select  id="moeda_nome" name="moeda_nome" class="form-control select2"> 
                @foreach($moedas as $data)
                  <option value="{{$data->id}}">{{$data->nome}}</option>
                @endforeach  
                </select> 
              </div>
            </div> 
            <div class="col-md-1">
              <div class="form-group">
                   <label for="exampleInputEmail1">Venda<span class="text-danger"> *</span></label>
                  <input type="text"  class="form-control" name="venda" id="venda" readonly>
              </div>
            </div>      
        </div>
            <div id="dados">
              <div id="dados_cliente">
                

              </div>
          </div>
        </div>

        <div class="row">

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
                      <option value="{{$data->loc_code}}" <?= ($data->inactive =="1" ? 'selected':'')?>>{{$data->location_name}}</option>
                    @endforeach
                    </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.extra_text.payment_method') }}</label>
                     <select class="form-control select2" name="payment_id">
                    
                    @foreach($payments as $payment)
                      <option value="{{$payment->id}}" <?= ($payment->defaults =="1" ? 'selected':'')?>>{{$payment->name}}</option>
                    @endforeach
                    </select>
              </div>
            </div>
            

          <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">{{ trans('message.table.reference') }}<span class="text-danger"> *</span></label>
                <div class="input-group">
                   <div class="input-group-addon">COT-</div>
                   <input id="reference_no" class="form-control" value="{{ sprintf("%04d", $order_count+1)}}/<?php echo $parte_ano;?>" type="text" readonly>
                   <input type="hidden"  name="reference" id="reference_no_write" value="">
                </div>
                <span id="errMsg" class="text-danger"></span>
            </div>
          </div>   
        </div>

        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">{{ trans('message.form.payment_term') }}</label>
                  <select id="payment_term" class="form-control select2" name="payment_term">
                  @foreach($paymentTerms as $term)
                    <option value="{{$term->id}}" <?= ($term->defaults == 1 ? 'selected':'')?>>{{$term->terms}}</option>
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
                <input class="form-control" id="datepicker" type="text" name="ord_date">
              </div>
              <!-- /.input group -->
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>{{ trans('message.table.date') }} Fim<span class="text-danger"> *</span></label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control" id="datepicker1" type="text" name="ord_date" disabled>
              </div>
              <!-- /.input group -->
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
                  <input class="form-control auto" placeholder="Nr Requisicao" name="requisicao" id="requisicao">
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
                    <th width="25%" class="text-center">{{ trans('message.table.description') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                    <th width="15%" class="text-center">{{ trans('message.table.rate') }}(<label style="font-size:15px" class="referencia"   name="referencia"></label>)</th>
                    <th width="10%" class="text-center">{{ trans('message.table.tax') }}(%)</th>
                    <th width="10%" class="text-center">{{ trans('message.table.tax') }}</th>
                    <th width="11%" class="text-center">{{ trans('message.table.tax_incluso')}}</th>
                    <th width="7.5%" class="text-center">{{ trans('message.table.discount') }}(%)</th>
                    <th width="12.5%" class="text-center">{{ trans('message.table.amount') }}</th>
                    <th width="5%"  class="text-center">{{ trans('message.table.action') }}</th>
                  </tr>

                  <tr class="custom-item"><td class="add-row text-danger"><strong>Add Custom Item</strong></td><td colspan="7"></td></tr>

                  <tr class="tableInfo"><td colspan="7" align="right"><strong>{{ trans('message.table.sub_total') }}({{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><strong id="subTotal"></strong></td></tr>

                  <tr class="tableInfo"><td colspan="7" align="right"><strong>{{ trans('message.table.discount')}}{{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><strong id="Descount"></strong></td></tr>

                  <tr class="tableInfo"><td colspan="7" align="right"><strong>{{ trans('message.invoice.totalTax') }}({{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><strong id="taxTotal"></strong></td></tr>

                 
                  <!--total:--> 
                   <tr id="cambio" style="display:none" class="tableInfo">
                    <td colspan="7" align="right">
                      <strong>{{ trans('message.table.grand_total') }} em (<label style="font-size:15px" class="referencia" name="referencia"></label>)</strong>
                    </td>
                    <td align="left" colspan="2">
                      <input type='text' name="total" class="form-control" id = "grandTotal" readonly> 
                    </td>
                  </tr>

                  <tr class="tableInfo">
                    <td colspan="7" align="right">
                      <strong>{{ trans('message.table.grand_total') }} em (MZN) </strong>
                    </td>
                    <td align="left" colspan="2">
                      <input type='text' name="grandTotal2" class="form-control" id = "grandTotal2" readonly>
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
                    <textarea placeholder="{{ trans('message.table.description') }} ..." rows="3" class="form-control" name="comments"></textarea>
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

  // =========================== Mexda 4 =============================
  $('#payment_term').change(function() {
    var route = SITE_URL+"/termo_pagamento/"+$('#payment_term').val()

    $.get(route, function(res) {
      var newdate = new Date();

      newdate.setDate(newdate.getDate() + Number(res));

      var dd = newdate.getDate();
      var mm = newdate.getMonth() + 1;
      var y = newdate.getFullYear();
      var dataFim = mm + '/' + dd + '/' + y;

      $('#datepicker1').datepicker('update', new Date(dataFim));
    });

  });
  // ======================== end Mexida 4 ===========================

  String.prototype.number_format = function(d) {
    var n = this;
    var c = isNaN(d = Math.abs(d)) ? 2 : d;
    var s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + ',' : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + ',') + (c ? '.' + Math.abs(n - i).toFixed(c).slice(2) : "");
  }

  $('.custom-item').on('click', function() {
    //console.log("Entrei Mr. Smart");
    recalcularCambio();
  });
  
 function formatar_moeda(his){
  return moeda(his,'.',',',event);
}

function cambio() { 
  var  nome_moeda="";

//Seta MZN nas labels com class="referencia"
$('.referencia').text('MZN');

//Seta o valor de venda no input com id="venda"
$("#venda").val(1);


// Ao Mudar a Moeda executa  este bloco
$("#moeda_nome").on('change', function () {
  
    nome_moeda = $('#moeda_nome option:selected').text()

        $('.referencia').text(nome_moeda); 

         if(nome_moeda =='Selecione'){
          
            $('.referencia').text('MZN'); 
          }
            if(nome_moeda !='MZN' && nome_moeda !='Selecione'){
                $("#cambio").show();
                $('.referencia').text(nome_moeda); 
            }else{
              $("#cambio").hide();   
                  $("#grandTotal2").val();
          }

          var baseUrl = $('#Url_geral').val(); 
 
        var route =baseUrl+"/taxasCambio";
   var venda=0;
 //Trazendo o valor de Venda para o Cambio da moeda

          $.get(route, function(data){
                $(data).each(function (key, item) { 
                  
                  if(nome_moeda==item.nome){
                      venda=item.venda; 
                    } 
               });
                 //Setando o valor de venda pra questoes de auxilio e calculo do valor correspondente
                  $("#venda").val(venda); 
                  var subTotal = Number($('#grandTotal').val());   
                  var PrecoVenda= Number(""+venda.replace(",", ".")); 
                  var grandTotalCambio = ""+(subTotal * PrecoVenda);   



                  $("#grandTotal2").val((grandTotalCambio.number_format())); 
          });
  // fim Trazendo o valor de Venda para o calculo da moeda
                
}); 
}
 
 function recalcularCambio (){

  // console.log("Recalcula o Cambio");
    nome_moeda = $('#moeda_nome option:selected').text()

        $('.referencia').text(nome_moeda); 

         if(nome_moeda =='Selecione'){
          
            $('.referencia').text('MZN'); 
          }
            if(nome_moeda !='MZN' && nome_moeda !='Selecione'){
                $("#cambio").show();
                $('.referencia').text(nome_moeda); 
            }else{
              $("#cambio").hide();   
                  $("#grandTotal2").val();
          }

          var baseUrl1 = $('#Url_geral').val(); 
 
        var route =baseUrl1+"/taxasCambio";
   var venda=0;
 //Trazendo o valor de Venda para o Cambio da moeda

          $.get(route, function(data){
                $(data).each(function (key, item) { 
                  
                  if(nome_moeda==item.nome){
                      venda=item.venda; 
                    } 
               });
                 //Setando o valor de venda pra questoes de auxilio e calculo do valor correspondente
                  $("#venda").val(venda); 
                  var subTotal = Number($('#grandTotal').val());   
                  var PrecoVenda= Number(""+venda.replace(",", ".")); 
                  var grandTotalCambio = ""+(subTotal * PrecoVenda);   



                  $("#grandTotal2").val((grandTotalCambio.number_format())); 
          });
  // fim Trazendo o valor de Venda para o calculo da moeda
           
 }
 

 
//Made by Mr. Smart -> Abdul Sumail -> abdulsumail@gmail.com
$(document).ready(function(){
      cambio();
 });


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

    // Mexida 3 datapicker1
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

      // ====================== new ==========================
      $('#datepicker1').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: '{{Session::get('date_format_type')}}'
      });
      $('#datepicker1').datepicker('update', new Date());
      // ==================== end new ======================
    });

    var stack = [];
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
                          '<td class="text-center"><input type="checkbox" value="" name="inclusao[]" data-input-id_check="'+e.id+'" class="inclusaos checkitem" value="'+zero+'"><input class="pegar" type="hidden" value="No" name="taxainclusa[]"></td>'+
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
                    recalcularCambio();
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
                    recalcularCambio();
        
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

recalcularCambio();  
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
      recalcularCambio();
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

            if(taxRateValue!=0){
           
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

              //taxRateValue
            }
        
            totalDescount=totalDescount+parseFloat(discount);

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
    +"<td class='text-center'><input type='checkbox'  name='inclusao[]' class='checkitem inclusaos' value='"+zero+"'><input type='hidden' <input class='pegar' value='No' name='taxainclusa[]'</td>"
    
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
recalcularCambio();
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
    recalcularCambio();
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
    recalcularCambio();
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
recalcularCambio();
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
                            console.log('Desselecionados checkbox selecionados');

                             $mostar=   $("#rowid"+id+" .pegar").val();
                             console.log("o valor idem eh "+$mostar);
                            $(this).parents('tr').find('.pegar').val("No");
                       
                        }

                        if($(this).prop('checked')==true){
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
              recalcularCambio();         
      });


    /// Craete Round Figure
    function roundToTwo(num) {    
        return +(Math.round(num + "e+2")  + "e-2");
    }

</script>
@endsection
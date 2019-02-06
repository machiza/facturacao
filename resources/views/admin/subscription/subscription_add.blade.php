@extends('layouts.app')
@section('content')
<section class="content">
  <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
           <div class="top-bar-title padding-bottom">Subscricão</div>
          </div> 
        </div>
      </div>
    </div> 
    
    <div class="box">
        <!-- form start -->
      <form action="{{ url('subscrition-store') }}" method="post" id="customerAdd" class="form-horizontal">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
              <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-7">
                    <h4 class="text-info text-center">Nova Subscricão</h4><br>
                      <div class="form-group">
                           <label class="col-sm-4 control-label" for="inputEmail3">Parceiro</label>
                           <div class="col-sm-8">
                            <select class="form-control select2" name="customer" id="customer">
                               <option value="">Selecione</option>
                             @foreach($patners as $customer)
                               <option value="{{$customer->debtor_no}}">{{$customer->name}}</option>
                              @endforeach
                            </select>
                           </div> 
                        </div>

                      <div class="form-group" id="cliente_final">
                        <label class="col-sm-3 control-label" for="inputEmail3"></label>
                         <label class="col-sm-6 control-label" for="inputEmail3">O Cliente selecionado e' Cliente Final?</label>
                      
                          <div class="col-sm-3">
                              <label>SIM
                                    <input type="radio" name="r_tipoCliente" value="0" class="minimall" checked="">
                               </label>
                              <label>
                               Não 
                                <input type="radio" value="1"  name="r_tipoCliente" value="1" class="minimall">
                              </label>
                             
                          </div>
                      </div>

                      <div class="form-group" id="loc_cliente_final"  style="display: none;">
                           <label class="col-sm-4 control-label" for="inputEmail3">Cliente</label>
                           <div class="col-sm-8">
                            <select class="form-control select2" name="cliente_final_id" id="cliente_final_id" ui-select2="{width:'resolve',dropdownAutoWidth:true}" style="width:100%">
                               <option value="">Selecione</option>
                             @foreach($customers as $customer)
                               <option value="{{$customer->debtor_no}}">{{$customer->name}}</option>
                              @endforeach
                            </select>
                           </div> 
                      </div>
                      <div class="form-group">
                           <label class="col-sm-4 control-label" for="inputEmail3">Produto</label>
                           <div class="col-sm-8">
                            <select class="form-control select2" name="produto_id" id="produto_id"> <option value="">Selecione</option>
                             @foreach($produtos as $produto)
                               <option value="{{$produto->id}}">{{$produto->nome}}</option>
                              @endforeach
                            </select>
                           </div> 
                        </div>

                      <div class="form-group">
                       <label class="col-sm-4 control-label" for="inputEmail3">Plano</label>
                       <div class="col-sm-8">
                        <select class="form-control select2" name="plano_id" id="plano_id">
                          <option value="">Selecione</option>
                          @foreach($planos as $plano)
                          <option value="{{$plano->id}}">{{$plano->nome}}</option>
                          @endforeach 
                         </select>
                       </div> 
                      </div>
                    <div class="form-group">
                          <label class="col-sm-4 control-label require" for="inputEmail3">Preco</label>

                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="valor" value="" id="valor">
                          </div>
                    </div>
                
                  <div class="form-group">
                       <label class="col-sm-4 control-label" for="inputEmail3">Inicio</label>
                       <div class="col-sm-8">
                          <input type="text" placeholder="data inicio" class="form-control" id="datepicker" name="data_inicio">
                       </div> 
                    </div>

                    <div class="form-group">
                     <label class="col-sm-4 control-label" for="inputEmail3">Fim</label>
                     <div class="col-sm-8">
                    <input type="text" placeholder="data fim" class="form-control" id="datepicker1" name="data_fim">
                     
                    </div> 
                    </div>

                     <div class="form-group">
                       <label class="col-sm-4 control-label" for="inputEmail3">Estado</label>
                       <div class="col-sm-8">
                        <select class="form-control select2" name="estado" id="estado">
                          <option value="activo">Activo</option>
                          <option value="desactivo">Desactivo</option>
                        </select>
                       </div> 
                    </div>



                  </div>
       
                </div>
              </div><br>
              </div>
                <div class="box-footer">
                  <a href="{{ url('subscrition') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                  <button class="btn btn-primary pull-right btn-flat" type="submit">Registar</button>
                </div>
                <!-- /.box-footer -->
              </form>
          
  </div>
        
  </section>
@endsection

@section('js')
  <script type="text/javascript">


    $('#customerAdd').validate({
        rules: {
            customer: {
                required: true
            },
            produto_id: {
                required: true
            },
            plano_id:{
                required: true
            },
            valor:{
                required: true
            },
           /* cliente_final_id: {
              required:'#r_:checked'
           }*/
          
        }
    });


    $('input[type=radio][name=r_tipoCliente]').change(function() {
          if (this.value == '0') {
             $('#loc_cliente_final').hide();
          }
          else if (this.value == '1') {
            $('#loc_cliente_final').show();
          }
      });




$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({});

    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
    //Date picker
    $('#datepicker1').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });

    $('#datepicker').datepicker('update', new Date());
   
});


$('document').ready(function() 
{
   // $("#Kind_customer").hide();

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      dateFormat: 'dd-MM-yyyy',
       //format: 'dd/mm/yyyy',
    })

     //Date picker
    $('#datepicker1').datepicker({
      autoclose: true,
      dateFormat: 'dd-MM-yyyy',
      // format: 'dd/mm/yyyy',
    })

});


$("#submit").click(function() {
  var val = $('input[name=q12_3]:checked').val();
  alert(val);
});




  $('#customer').change(function()
  {
    if ($('#customer').val()=="")
    {
       
    }

    else 
    {
      /*  
      var id=$('#customer').val();
      console.log("customer  "+id);
        $.ajax({
            url: '{{ URL::to('tipo_de_cliente')}}',
            data:{ 
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
              console.log("the kind of customers "+data.tipo_cliente);
              if(data.tipo_cliente!="normal"){
                $("#Kind_customer").show();
              }else{
                $("#Kind_customer").hide();
              }
              
               
            }
        });
        */


    }
  });


  //
  $('#plano_id').change(function()
  {
    if ($('#plano_id').val()=="")
    {
    }else 
    {
       var id=$('#plano_id').val();
       $.ajax({
            url: '{{ URL::to('valor_plano')}}',
            data:{ 
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
              
                $('#valor').val(data.valor);
               
            }
        });

    }
  });

</script>
@endsection
@extends('layouts.app')


@section('content')

    <!-- Main content -->
    <section class="content">

      <div class="row">
      <div class="col-md-4">
        @include('layouts.includes.taxas_menu')
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar Taxa</h3>
            </div>
            
            <form action="{{ url('taxas/update') }}" method="post" id="conta" class="form-horizontal">
               <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
               <input type="hidden" value="{{$taxas->id}}" name="id" id="id">

            <div class="box-body">
                
                <div class="form-group">
                  <label for="input_name" class="col-sm-3 control-label">Data do Cambio<em class="text-danger">*</em></label>
                  <div class="col-sm-6">  
                   <input type="date" class="form-control col-md-6" value="<?php echo date("Y-m-d") ; ?>" name="data_cambio" id="data_cambio" required>
                     <span class="text-danger">{{ $errors->first('data_cambio') }}</span>
                  </div>
                </div>


                <div class="form-group">
                  <label for="input_display_name" class="col-sm-3 control-label">Moeda<em class="text-danger">*</em></label> 
                  <div class="col-sm-6">  
                                          <select class="form-control" name="moedas_id" id="moedas_id">
                                           <option value="">- Selecione -</option>
                                            @foreach($moedas as $moeda)
                                                @if($moeda->id==$taxas->moedas_id)
                                                    <option value="{{ $moeda->id }}" selected="selected">{{$moeda->nome}}</option>
                                                @else
                                                    <option value="{{ $moeda->id }}">{{$moeda->nome}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                    <span class="text-danger">{{ $errors->first('moedas_id') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="input_description" class="col-sm-3 control-label">Compra<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="compra" id="compra" value="{{$taxas->compra}}" placeholder="Ex: 61,2"  class="form-control">
                    <span class="text-danger">{{ $errors->first('compra') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="input_description" class="col-sm-3 control-label">Venda<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="venda" id="venda" value="{{$taxas->venda}}" placeholder="Ex: 62,42"  class="form-control">
                    <span class="text-danger">{{ $errors->first('venda') }}</span>
                  </div>
                </div>
               

                 

              </div>

              <div class="box-footer">
                <a href="{{ url('taxas') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
               
                <button class="btn btn-primary btn-flat pull-right" type="submit">{{ trans('message.form.submit') }}</button>
               
              </div>
            </form>
          </div>
      </div>
    </section>
    @include('layouts.includes.message_boxes')
@endsection

@section('js')
    <script type="text/javascript">
      $(document).ready(function(){
       $('#addRole').validate({
            rules: {
                name: {
                    required: true
                },
                symbol: {
                    required: true
                }                 
            }
        });
      });
    </script>
@endsection
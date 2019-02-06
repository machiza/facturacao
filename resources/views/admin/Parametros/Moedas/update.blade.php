@extends('layouts.app')


@section('content')

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Adicionar Moeda</h3>
            </div>
            
            <form action="{{ url('cambio/update') }}" method="post" id="conta" class="form-horizontal">
               <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
               <input type="hidden" value="{{$moedas->id}}" name="id" id="id">

            <div class="box-body">
                <div class="form-group">
                  <label for="input_name" class="col-sm-3 control-label">Nome da Moeda<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="nome" value="{{$moedas->nome}}" placeholder="Ex: MZN" id="nome" class="form-control">
                    <span class="text-danger">{{ $errors->first('nome') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_display_name" class="col-sm-3 control-label">Singular<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="singular" value="{{$moedas->singular}}" placeholder="Ex: Metical" id="singular" class="form-control">
                    <span class="text-danger">{{ $errors->first('singular') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_description" class="col-sm-3 control-label">Plural<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="plural" value="{{$moedas->plural}}" placeholder="Ex: Meticais" id="plural" class="form-control">
                    <span class="text-danger">{{ $errors->first('plural') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="input_description" class="col-sm-3 control-label">Casa decimal Singular<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="casas_decimais_sing" value="{{$moedas->casas_decimais_sing}}" placeholder="Ex: Centavo" id="casas_decimais_sing" class="form-control">
                    <span class="text-danger">{{ $errors->first('casas_decimais_sing') }}</span>
                  </div>
                </div>
               

                <div class="form-group">
                  <label for="input_description" class="col-sm-3 control-label">Casa decimal Plural<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="casas_decimais_plu" value="{{$moedas->casas_decimais_plu}}" placeholder="Ex: Centavos" id="casas_decimais_plu" class="form-control">
                    <span class="text-danger">{{ $errors->first('casas_decimais_plu') }}</span>
                  </div>
                </div>
              </div>

              <div class="box-footer">
                <a href="{{ url('cambio') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
               
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
@extends('layouts.app')


@section('content')

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          @include('layouts.includes.company_menu')
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar a conta: {{$contas->nome}}</h3>
            </div>
            
            <form action="{{ url('bank_account/update') }}" method="post" id="conta" class="form-horizontal">
               <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
               <input type="hidden" value="{{$contas->id}}" name="id" id="id">

            <div class="box-body">
                <div class="form-group">
                  <label for="input_name" class="col-sm-3 control-label">Nome do Banco<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="nome" placeholder="Ex: Millennium bim" id="nome" value="{{$contas->nome}}" class="form-control">
                    <span class="text-danger">{{ $errors->first('nome') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_display_name" class="col-sm-3 control-label">Numero da Conta<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="nr_conta" placeholder="Ex: 271306285" id="nr_conta" value="{{$contas->nr_conta}}" class="form-control">
                    <span class="text-danger">{{ $errors->first('nr_conta') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_description" class="col-sm-3 control-label">Nib<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="nib" placeholder="Ex: 10001245487" id="nib" value="{{$contas->nib}}" class="form-control">
                    <span class="text-danger">{{ $errors->first('nib') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="input_description" class="col-sm-3 control-label">Swift<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="swift" placeholder="Ex: 322345648978654" id="swift" value="{{$contas->swift}}" class="form-control">
                    <span class="text-danger">{{ $errors->first('swift') }}</span>
                  </div>
                </div>
              </div>

              <div class="box-footer">
                <a href="{{ url('bank_account') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
               
                <button class="btn btn-primary btn-flat pull-right" type="submit">Actualizar</button>
               
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
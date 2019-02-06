@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
        
        <div class="row">
          
          <div class="col-md-12">
          
            <div class="box box-info">
            <div class="box-header with-border">
              <a href="{{ URL::to('customerdownloadCsv/sample') }}"><button class="btn btn-default btn-flat btn-border-info"><span class="fa fa-download"> &nbsp;</span>{{ trans('message.table.download_sampple') }}</button></a>
            </div>
            
            <div class="box-body">
            <div class="tab-content">
                <p>{{ trans('message.table.download_customer_csv_message') }}</p>
                
                <small class="text-red">{{ trans('message.table.duplicate_email_message') }}</small><br><br>
                <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    Nome  Email Contacto  Nuit  endereco  Cidade  provincia

                    <tr>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Contacto</th>
                      
                      <th>Nuit</th>
                      <th>Endereco</th>
                      <th>Cidade</th>
                      <th>Provincia</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                     
                      <td>Michel Jhon</td>
                      <td>test@test.com</td>
                      <td>844012345</td>
                      
                      <td>41212430</td>
                      <td>Av de Mocambique nr 3923</td>
                      <td>Cidade de Maputo</td>
                      <td>Maputo</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div><br/><br/>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('customerimportcsv') }}" method="post" id="myform1" class="form-horizontal" enctype="multipart/form-data">
            {!! csrf_field() !!}
                <div class="form-group">
                  <label class="col-sm-2 control-label require" for="inputEmail3">{{ trans('message.table.chose_xls_file') }}</label>

                  <div class="col-sm-5">
                    <input type="file" class="form-control valdation_check input-file-field" id="name" name="import_file">
                    <span id="val_name" style="color: red"></span>
                  </div>
                </div><br/><br/>
            
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{ url('item-category') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          </div>
          </div>
          
        </div>
        
        <!-- /.box-footer-->
      
      <!-- /.box -->

    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $('#myform1').on('submit',function(e) {
                var flag = 0;
                $('.valdation_check').each(function() {
                    var id = $(this).attr('id');
                    console.log($('#'+id).val());
                    if($('#'+id).val() == '')
                    {
                        $('#val_'+id).html("{{ trans('message.error.required') }}");
                        flag = 1;
                    }
                });
                $('.valdation_select').each(function() {
                    var id = $(this).attr('id');
                    //console.log($('#'+id).val());
                    if ($('#'+id).val() == '') {
                    
                        $('#val_'+id).html("{{ trans('message.error.required') }}");
                        flag = 1;
                        //console.log('country '+flag);
                    }
                });
                if (flag == 1) {
                    e.preventDefault();
                }
        });
        $(".valdation_check").on('keypress keyup',function() {
            var nm = $(this).attr("id");
            $('#val_'+nm).html("");
        });
        $(".valdation_select").on('click',function() {
            var nm = $(this).attr("id");
            $('#val_'+nm).html("");
        });
    </script>
@endsection

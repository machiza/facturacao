<!-- Profile Image -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Cambio do Dia </h3>
  </div>
  <div class="box-body no-padding" style="display: block;">
    <ul class="nav nav-pills nav-stacked">
    
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>  
                  <th>Moeda</th>
                  <th>Compra</th>
                  <th>Venda</th>  
                </tr>
                </thead>
                <tbody>
                @foreach($taxa as $data)
                <tr>  
                  <td>{{ $data->nome}}</td>
                  <td>{{ $data->compra}}</td> 
                  <td>{{ $data->venda}}</td>   
                </tr>
               @endforeach
                
              </table>
            
            <!-- /.box-body -->
          </div>
        <!-- /.col -->
    </ul>
  </div>
  <!-- /.box-body -->
</div>
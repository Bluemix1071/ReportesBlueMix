@extends("theme.$theme.layout")
@section('titulo')
    cargar orden de compra
@endsection

@section('contenido')

<div class="container-fluid">
    <h3 class="display-4">Stock De Productos Por area/Proveedor</h3>
    <div class="row">

      <div class="col-md-12">
        <div class="container">
            <div class="card bg-light mt-3">
                <div class="card-header">
                    Seleccione la opcion
                </div>
                <div class="card-body">
                        <a href="{{route('areaproveedorfamilia')}}"  class="btn btn-success">Stock De Productos Por area/Proveedor "familia"</a>
                        <a href="" data-toggle="modal" data-target="#mimodalejemplo1" class="btn btn-info">info</a>
                </div>
            </div>
        </div>
      </div>
    </div>
    <br>
        <div class="col-md-12">
          <div class="container">
              <div class="card bg-light mt-3">
                  <div class="card-header">
                      Seleccione la opcion
                  </div>
                  <div class="card-body">
                    <a href=""  class="btn btn-success">Stock De Productos Por area/Proveedor "categoria"</a>
                        <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">info</a>
                  </div>
              </div>
          </div>
        </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Orden de Compra "Detalle"</h4>
            </div>
            <div class="modal-body">
               <div class="card-body">Descargue la plonsidere</div>
            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
           </div>
          </div>
        </div>
      </div>
       <!-- FIN Modal -->
       <!-- Modal -->
<div class="modal fade" id="mimodalejemplo1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Orden de Compra "Encabezado"</h4>
            </div>
            <div class="modal-body">
               <div class="card-body">Descargue la plantilla de ejemplo </div>
            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
           </div>
          </div>
        </div>
      </div>
       <!-- FIN Modal -->
@endsection

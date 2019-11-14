@extends("theme.$theme.layout")
@section('titulo')
    cargar orden de compra
@endsection

@section('contenido')

<div class="container-fluid">
    <h3 class="display-3">Cargar Ordenes de Compra</h3>
    <div class="row">

      <div class="col-md-12">
        <div class="container">
            <div class="card bg-light mt-3">
                <div class="card-header">
                    Seleccione el encabezado de la orden de compra que desee cargar.
                </div>
                <div class="card-body">
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" required name="file" class="form-control">
                        <br>
                        <button class="btn btn-success">Importar Orden De Compra 'Encabezado'</button>
                        <a class="btn btn-warning" href="{{ route('descargaencabezado') }}">Descargar plantilla de trabajo </a>
                        <a href="" data-toggle="modal" data-target="#mimodalejemplo1" class="btn btn-info">info</a>

                    </form>
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
                      Seleccione el detalle de orden de compra que desee cargar.
                  </div>
                  <div class="card-body">
                      <form action="{{ route('importdetalle') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <input type="file" name="file" required class="form-control">
                          <br>
                          <button class="btn btn-success">Importar Orden De Compra 'Detalle'</button>
                          <a href="{{route('descargadetalle')}}"class="btn btn-warning">
                            Descargar plantilla de trabajo
                            </a>
                            <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">info</a>

                      </form>
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
               <div class="card-body">Descargue la plantilla de ejemplo para construir el detalle de la orden de compra,
                    recuerde eliminar el encabezado del archivo para cargar la orden de compra al sistema. además, considere que el "N° orden de Compra"
                tiene que ser el mismo en cada fila y el mismo del encabezado ante mente cargado y el "número de tupla" deberá iniciar desde el "0"</div>
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
               <div class="card-body">Descargue la plantilla de ejemplo para construir el encabezado de la orden de compra,
                    recuerde eliminar el encabezado del archivo para cargar la orden de compra al sistema. además, considere que el "estado" tiene que ser "creada"
                así como la fecha con un formato de "año-mes-día", recomendación seguir la estructura de la plantilla</div>
            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
           </div>
          </div>
        </div>
      </div>
       <!-- FIN Modal -->
@endsection

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
                        <input type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-success">Importar Orden De Compra 'Encabezado'</button>
                        <a class="btn btn-warning" href="{{ route('export') }}">Exportar plantilla de trabajo </a>
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
                          <input type="file" name="file" class="form-control">
                          <br>
                          <button class="btn btn-success">Importar Orden De Compra 'Detalle'</button>
                          <a download="../public/descargadocumentos/plantilla orden de compra (detalle).xlsx" class="btn btn-warning">
                            Exportar plantilla de trabajo
                            </a>
                      </form>
                  </div>
              </div>
          </div>
        </div>
</div>
@endsection

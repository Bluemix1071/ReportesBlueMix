@extends("theme.$theme.layout")
@section('titulo')
    Informacion
@endsection

@section('contenido')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detalles Del Proyecto</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
<div class="card-body" style="display: block;">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        <div class="row">
          <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
              <div class="info-box-content">
                <span class="info-box-text text-center text-muted">Presupuestos estimados</span>
                <span class="info-box-number text-center text-muted mb-0">Consultas</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
              <div class="info-box-content">
                <span class="info-box-text text-center text-muted">Stock de Productos</span>
                <span class="info-box-number text-center text-muted mb-0">Gestion de Inventario</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="info-box bg-light">
              <div class="info-box-content">
                <span class="info-box-text text-center text-muted">Graficos</span>
                <span class="info-box-number text-center text-muted mb-0">Mandos de control<span>
              </span></span></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h4>Control De Usuarios</h4>
              <div class="post">
                <div class="user-block">
                  <img class="img-circle img-bordered-sm" src="{{asset("assets/$theme/dist/img/user1-128x128.jpg")}}" alt="user image">
                  <span class="username">
                    <a href="#">Roberto cid Jr.</a>
                  </span>
                  <span class="description">
                    Compartido públicamente - 7:45 hoy</span>
                </div>
                <!-- /.user-block -->
                <p>
                    Se Tendrá el control total de los usuarios, pudiendo asignando sus privilegios para así poder acceder a diferentes funciones del sistema
                </p>

                <p>
                  <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i>Ejemplo V1</a>
                </p>
              </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> Blue Mix</h3>
        <p class="text-muted">Software dedicado principalmente para la generación de consultas a los sistemas informáticos de la empresa, con opciones como las de exportaciones en PDF, Excel y controles de Usuarios.</p>
        <br>
        <div class="text-muted">
          <p class="text-sm">Felipe Martinez
            <b class="d-block">Alumno Practicante</b>
          </p>
          <p class="text-sm">Leandro Sepulveda
            <b class="d-block">Alumno Practicante</b>
          </p>
        </div>

        <h5 class="mt-5 text-muted">
            Archivos de proyecto</h5>
        <ul class="list-unstyled">
          <li>
            <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Exportaciones de Archivos.docx</a>
          </li>
          <li>
            <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> Exportaciones de Archivos.pdf</a>
          </li>
          <li>
            <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-envelope"></i>Consultas De reportabilidad</a>
          </li>
          <li>
            <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-image "></i> Archivos.png</a>
          </li>
          <li>
            <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Generaciones de DTE.doc</a>
          </li>
        </ul>
        <div class="text-center mt-5 mb-3">
          <a href="{{route('Publico')}}" class="btn btn-sm btn-primary">Inicio</a>
          <a href="{{route('chart')}}" class="btn btn-sm btn-warning">Reportes</a>
        </div>
      </div>
    </div>
  </div>
@endsection


<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('Publico') }}" class="nav-link">Menu Principal</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('informacion') }}" class="nav-link">Información</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://www.libreriabluemix.cl" class="nav-link">BlueMix.cl</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://www.bluemixempresas.cl" class="nav-link">BlueMix Empresas</a>
        </li>

    </ul>



    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                @if (empty($conteo1))
                    <span class="badge badge-danger navbar-badge">0</span>
                @else
                    <span class="badge badge-danger navbar-badge">{{ $conteo1 }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @if (empty($mensaje))

                @else
                    <!-- Message Start -->
                    @foreach ($mensaje as $item)
                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#mimodalejemplo5"
                            data-id='{{ $item->id }}' data-estado='{{ $item->estado }}'
                            data-created_at='{{ $item->created_at }}' data-name='{{ $item->name }}'
                            data-body='{{ $item->body }}'>
                            <div class="media">
                                <img src="{{ asset("assets/$theme/dist/img/images.png") }}" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        {{ $item->name }}
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">
                                        {{ $item->body }}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                                        Fecha: {{ $item->created_at }}</p>
                                </div>
                            </div>
                    @endforeach
                    <!-- Message End -->
                @endif
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">
                    Ver todos los mensajes</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notificaciones</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 nuevos mensajes
                    <span class="float-right text-muted text-sm">3 minutos</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8
                    peticiones de amistad
                    <span class="float-right text-muted text-sm">12 horas</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 nuevos reportes
                    <span class="float-right text-muted text-sm">2 dias</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">
                    Ver todas las notificaciones</a>
            </div>
        </li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('Publico') }}" class="brand-link">
        <img src="{{ asset("assets/$theme/dist/img/AdminLTELogo.png") }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Bluemix</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset("assets/$theme/dist/img/user2-160x160.png") }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> hola, {{ session()->get('nombre') }} </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!--  Agregar items de giftcard -->

                @can('RolesYPermisos')

                    <li class="nav-item has-treeview">
                        <a href="" class="nav-link">
                            <i class="fas fa-user-edit"></i>
                            <p>
                                Informatica
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('Roles') }}" class="nav-link {{ setActive('indexGiftCard') }} ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles Y Permisos</p>
                                </a>
                            </li>

                            @can('ListarUsers')

                                <li class="nav-item">
                                    <a href="{{ route('ListarUser') }}" class="nav-link {{ setActive('ListarUser') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Control De Usuarios</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('ListarUserCombo') }}"
                                        class="nav-link {{ setActive('ListarUserCOMBO') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Control Usuarios COMBO</p>
                                    </a>
                                </li>
                            @endcan


                            @can('ControlDeFolios')

                                <li class="nav-item">
                                    <a href="{{ route('ControlDeFolios') }}"
                                        class="nav-link {{ setActive('ControlDeFolios') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Control De Folios</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ControlIpMac')

                                <li class="nav-item">
                                    <a href="{{ route('controlipmac') }}"
                                        class="nav-link {{ setActive('controlipmac') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Control IP Mac</p>
                                    </a>
                                </li>
                            @endcan

                            @can('AnulacionDocs')

                                <li class="nav-item">
                                    <a href="{{ route('AnulacionDocs') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Anulacion Docs
                                        </p>
                                    </a>
                                </li>
                            @endcan


                            @can('movimientoinventario')

                                <li class="nav-item">
                                    <a href="{{ route('movimientoinventario') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Inventario
                                        </p>
                                    </a>
                                </li>

                            @endcan


                            @can('CargaOrdenCompra')

                                <li class="nav-item">
                                    <a href="{{ route('cargaroc') }}" class="nav-link {{ setActive('cargaroc') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cargar Orden De Compra</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('GiftCard')

                    @if (session()->get('tipo_usuario') == 'adminGiftCard')
                        <li class="nav-item has-treeview">

                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-credit-card"></i>
                                <p>
                                    Gift Card
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                @can('CrearFolios')

                                    <li class="nav-item">
                                        <a href="{{ route('indexGiftCard') }}"
                                            class="nav-link {{ setActive('indexGiftCard') }}">
                                            <i class="fas fa-cog"></i>
                                            <p>Creacion Folios GiftCard</p>
                                        </a>
                                    </li>
                                @endcan


                                @can('ActivacionGiftcard')

                                    <li class="nav-item">
                                        <a href="{{ route('Activacion3.0') }}"
                                            class="nav-link {{ setActive('Activacion3.0') }}">
                                            <i class="fas fa-cog"></i>
                                            <p>Activacion Giftcard</p>
                                        </a>
                                    </li>

                                @endcan

                                {{-- <li class="nav-item">
                          <a href="{{route('indexVentas')}}" class="nav-link">
                              <i class="fas fa-search-dollar"></i>
                            <p>Ventas GiftCards Sala</p>
                          </a>
                      </li> --}}

                                @can('VentaGiftcardEmpresa')

                                    <li class="nav-item">
                                        <a href="{{ route('VentaEmpresa') }}"
                                            class="nav-link {{ setActive('VentaEmpresa') }}">
                                            <i class="fas fa-book"></i>
                                            <p>Venta GiftCard Empresas</p>
                                        </a>
                                    </li>
                                @endcan

                                @can('BloqueoGiftCard')

                                    <li class="nav-item">
                                        <a href="{{ route('Bloqueo') }}" class="nav-link {{ setActive('Bloqueo') }}">
                                            <i class="far fa-times-circle"></i>
                                            <p>Bloqueo Gift Cards</p>
                                        </a>
                                    </li>
                                @endcan

                                @can('ConsumoGiftCard')

                                    <li class="nav-item">
                                        <a href="{{ route('consumotarj') }}"
                                            class="nav-link {{ setActive('consumotarj') }}">
                                            <i class="fas fa-book"></i>
                                            <p>Consumo De GiftCard</p>
                                        </a>
                                    </li>
                                @endcan



                            </ul>
                        </li>
                    @endif
                @endcan




                <!-- Agregar items de administrador -->
                @if (session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard')

                    @can('Administrador')

                        <li class="nav-item has-treeview ">
                            <a href="" class="nav-link ">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>
                                    Administrador
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('MantencionClientes') }}"
                                        class="nav-link {{ setActive('MantencionClientes') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mantencion Clientes</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('MantencionClientesCredito') }}"
                                        class="nav-link {{ setActive('MantencionClientesCredito') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mantencion Clientes Credito</p>
                                    </a>
                                </li>

                                @can('Admindiseno')

                                    <li class="nav-item">
                                        <a href="{{ route('ListarOrdenesDiseño') }}"
                                            class="nav-link {{ setActive('ListarOrdenesDiseño') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Admin Ordenes Diseño</p>
                                        </a>
                                    </li>
                                @endcan


                                @can('Admindiseno')
{{--
                                <li class="nav-item">
                                    <a href="{{ route('GastosInternosDiseño') }}"
                                        class="nav-link {{ setActive('GastosInternosDiseño') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Gastos Internos Diseño</p>
                                    </a>
                                </li> --}}
                            @endcan

                            @can('Admindiseno')

                            <li class="nav-item">
                                <a href="{{ route('ReporteGastosInternosDiseño') }}"
                                    class="nav-link {{ setActive('ReporteGastosInternosDiseño') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Reportes Gastos Diseño</p>
                                </a>
                            </li>
                        @endcan


                                @can('ComprasProveedor')
                                    <li class="nav-item">
                                        <a href="{{ route('comprassegunprov') }}"
                                            class="nav-link {{ setActive('comprassegunprov') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ordenes Segun Proveedor
                                            </p>
                                        </a>
                                    </li>
                                @endcan

                                @can('OrdenesDeCompra')
                                    <li class="nav-item">
                                        <a href="{{ route('ordenesdecompra') }}"
                                            class="nav-link {{ setActive('ordenesdecompra') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ordenes De Compra</p>
                                        </a>
                                    </li>
                                @endcan

                                <li class="nav-item">
                                    <a href="{{ route('VentasPorRut') }}"
                                        class="nav-link {{ setActive('VentasPorRut') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ventas Por Rut</p>
                                    </a>
                                </li>

                                @can('ventasCategoria')

                                    <li class="nav-item">
                                        <a href="{{ route('ventasCategoria') }}"
                                            class="nav-link {{ setActive('ventasCategoria') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ventas Por Categoría</p>
                                        </a>
                                    </li>
                                @endcan

                                <li class="nav-item">
                                    <a href="{{ route('VentasPorVendedor') }}"
                                        class="nav-link {{ setActive('VentasPorVendedor') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ventas Por Vendedor</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('ComprasPorHoraIndex') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ventas Por Hora</p>
                                    </a>
                                </li>

                                @can('VentaProducto')

                                    <li class="nav-item">
                                        <a href="{{ route('ventaProd') }}" class="nav-link {{ setActive('ventaProd') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Venta Productos
                                            </p>
                                        </a>
                                    </li>
                                @endcan


                                    <li class="nav-item">
                                        <a href="{{ route('VentaProductosPorDia') }}" class="nav-link {{ setActive('VentaProductosPorDia') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Venta Productos Por Dia
                                            </p>
                                        </a>
                                    </li>

                                @can('CompraProductos')
                                    <li class="nav-item">
                                        <a href="{{ route('compraProd') }}"
                                            class="nav-link {{ setActive('compraProd') }}">
                                            <i  class="far fa-circle nav-icon"></i>
                                            <p>Compra Productos

                                            </p>
                                        </a>
                                    </li>

                                @endcan

                                {{-- @can('ProyeccionCompra')

                                    <li class="nav-item">
                                        <a href="{{ route('proyeccion') }}"
                                            class="nav-link {{ setActive('proyeccion') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Proyeccion De Compras
                                            </p>
                                        </a>
                                    </li>
                                @endcan --}}

                                @can('ProductoPorMarca')
                                    <li class="nav-item">
                                        <a href="{{ route('ProductosPorMarca') }}"
                                            class="nav-link {{ setActive('ProductosPorMarca') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Producto Por Marca</p>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('IngresosPorAnio')

                                    <li class="nav-item">
                                        <a href="{{ route('chart') }}" class="nav-link {{ setActive('chart') }} ">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ingresos Por Año
                                            </p>
                                        </a>
                                    </li>
                                @endcan

                                <li class="nav-item">
                                    <a href="{{route('porcentaje')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Desviacion
                                    </p>
                                    </a>
                                </li> --}}


                                {{-- @can('Cupones')

                                <li class="nav-item">
                                    <a href="{{ route('cuponesescolares') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cupones Escolares
                                        </p>
                                    </a>
                                </li>
                                @endcan --}}
                                {{-- @can('MantenedorProductos')

                                <li class="nav-item">
                                    <a href="{{ route('MantenedorProducto') }}" class="nav-link {{ setActive('MantenedorProducto') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mantenedor Productos
                                        </p>
                                    </a>
                                </li>

                                @endcan --}}

                                @can('Productos')

                                    <li class="nav-item">
                                        <a href="{{ route('productos') }}" class="nav-link {{ setActive('productos') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado Productos
                                            </p>
                                        </a>
                                    </li>
                                @endcan


                                <li class="nav-item">
                                    <a href="{{ route('CompraAgil') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Compras Ágiles
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('stocktiemporeal') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Stock Tiempo Real
                                        </p>
                                    </a>
                                </li>
{{--
                                <li class="nav-item">
                                    <a href="{{ route('InformeExistencia') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Informe Existencia
                                        </p>
                                    </a>
                                </li> --}}

                                {{-- <li class="nav-item">
                                    <a href="{{ route('ResumenDeVenta') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Resumen De Venta
                                        </p>
                                    </a>
                                </li> --}}

                                <li class="nav-item">
                                    <a href="{{ route('InformeUtilidades') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Informe Utilidades
                                        </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ route('AvanceAnualMensual') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Avance Mensual Anual
                                        </p>
                                    </a>
                                </li>

                                @can('LibroVentas')
                                    <li class="nav-item">
                                        <a href="{{ route('consultafacturaboleta') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Libro De Ventas Diario
                                            </p>
                                        </a>
                                    </li>
                                @endcan

                                {{--
                                <li class="nav-item">
                                   <a href="{{ route('AvanceAnualMensual') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Avance Mensual Anual
                                      </p>
                                  </a>
                                </li>
                                --}}

                                {{--@can('ArqueoC')--}}
                                <li class="nav-item">
                                       <a href="{{ route('ArqueoC') }}" class="nav-link">
                                           <i class="far fa-circle nav-icon"></i>
                                           <p>Arqueo Caja
                                           </p>
                                       </a>
                                </li>
                                {{--@endcan--}}


                                @can('Costos')
                                    <li class="nav-item">
                                        <a href="" class="nav-link ">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>Costos
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('costos') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Costos
                                                    </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('costosdetalle') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Detalle Costos
                                                    </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('CostoHistoricoPorProducto') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Costos Historicos
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan

                                @can('Contratos')
                                    <li class="nav-item">
                                        <a href="" class="nav-link ">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>Contratos
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('MantenedorContrato') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Mantenedor De Contratos
                                                    </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('ListadoContratos') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Listado Contratos
                                                    </p>
                                                </a>
                                            <li class="nav-item">
                                                <a href="{{ route('ListadoProductosContrato') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Listado Productos
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan
                                    {{--AQUI! --}}
                                @can('Contratos')
                                    <li class="nav-item">
                                        <a href="" class="nav-link ">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>Cotizaciones
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('ListaEscolar') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Lista Escolar
                                                    </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Municipal(pronto)
                                                    </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Otros(pronto)
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan
                                    {{--AQUI! --}}
                                @can('Jumpseller')
                                    <li class="nav-item">
                                        <a href="" class="nav-link ">

                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>Jumpseller
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            {{-- inicio bluemix empresas --}}
                                            @can('BluemixEmpresas')

                                                <li class="nav-item">
                                                    <a href="" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Bluemix Empresas</p>
                                                        <i class="right fas fa-angle-left"></i>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        {{-- Sincronizacion productos --}}
                                                        @can('Sincronizar')

                                                            <li class="nav-item">
                                                                <a href="{{ route('index.jumpsellerEmpresas') }}"
                                                                    class="nav-link {{ setActive('jumpsellerEmpresas') }}">
                                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                                    <p>Sincronizar Productos</p>
                                                                </a>
                                                            </li>

                                                        @endcan
                                                        {{-- Fin Sincronizacion productos --}}

                                                        {{-- generar carrito --}}
                                                        @can('GenerarCarrito')
                                                            <li class="nav-item">
                                                                <a href="{{ route('CreacionCarrito.index') }}" class="nav-link">
                                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                                    <p>
                                                                        Generar Carrito
                                                                    </p>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        {{-- Fin generar carrito --}}

                                                        {{-- Actualizar Stock 
                                                        @can('ActualizarStock')
                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link">
                                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                                    <p>
                                                                        Actualizar Stock
                                                                    </p>
                                                                </a>
                                                            </li>
                                                        @endcan --}}
                                                        <li class="nav-item">
                                                                <a href="{{ route('ProductosFaltantes') }}"
                                                                    class="nav-link {{ setActive('ProductosFaltantes') }}">
                                                                    <i class="far fa-circle nav-icon"></i>
                                                                    <p>Productos Sin Subir Empresas</p>
                                                                </a>
                                                         </li>
                                                        {{-- Fin Actualizar Stock --}}
                                                    </ul>
                                                </li>
                                                {{-- fin bluemix empresas --}}
                                            @endcan

                                            {{-- Bluemix.cl --}}
                                            @can('Bluemix.cl')
                                                <li class="nav-item">
                                                    <a href="" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Bluemix.cl</p>
                                                        <i class="right fas fa-angle-left"></i>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        {{-- Sincronizacion productos --}}
                                                        @can('Sincronizarweb')

                                                            <li class="nav-item">
                                                                <a href="{{ route('index.jumpsellerWeb') }}"
                                                                    class="nav-link {{ setActive('Sincronizarweb') }}">
                                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                                    <p>Sincronizar Productos Web</p>
                                                                </a>
                                                            </li>
                                                        @endcan

                                                        {{-- Fin Sincronizacion productos --}}

                                                        {{-- Actualizar Stock 
                                                        @can('ActualizarStockweb')
                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link">
                                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                                    <p>
                                                                        Actualizar Stock web
                                                                    </p>
                                                                </a>
                                                            </li>
                                                        @endcan --}}
                                                        <li class="nav-item">
                                                                <a href="{{ route('ProductosFaltantesWeb') }}"
                                                                    class="nav-link {{ setActive('ProductosFaltantesWeb') }}">
                                                                    <i class="far fa-circle nav-icon"></i>
                                                                    <p>Productos Sin Subir Web</p>
                                                                </a>
                                                            </li>
                                                        {{-- Fin Actualizar Stock --}}
                                                    </ul>
                                                </li>
                                            @endcan
                                            {{-- Fin Bluemix.cl --}}


                                        </ul>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endcan
                @endif

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Publico
                            <i class="fas fa-angle-left right"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ConsultaSaldo') }}"
                                class="nav-link {{ setActive('ConsultaSaldo') }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Saldo Gift Card</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ConsultaPrecio') }}"
                                class="nav-link {{ setActive('ConsultaPrecio') }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Consulta Precio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ProductosNegativos') }}"
                                class="nav-link {{ setActive('ProductosNegativos') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Productos Negativos</p>
                            </a>
                        </li>

                        @can('SistemaNuevo')
                            <li class="nav-item">
                                <a href="{{ route('apiReact') }}" class="nav-link {{ setActive('apiReact') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sistema nuevo</p>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>

                @can('Sala')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-search-dollar"></i>
                            <p>
                                Sala
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @can('VentaGiftCard')

                                <li class="nav-item">
                                    <a href="{{ route('CargaTarjetasCaja') }}"
                                        class="nav-link {{ setActive('CargaTarjetasCaja') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Venta GiftCard</p>
                                    </a>
                                </li>
                            @endcan

                            @can('CambioPrecios')

                                <li class="nav-item">
                                    <a href="{{ route('cambiodeprecios') }}"
                                        class="nav-link {{ setActive('cambiodeprecios') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cambio de Precios</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ordenesdiseno')

                                <li class="nav-item">
                                    <a href="{{ route('OrdenesDeDiseño') }}"
                                        class="nav-link {{ setActive('OrdenesDeDiseño') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ordenes De Diseño</p>
                                    </a>
                                </li>
                            @endcan

                             @can('ordenesdiseno')

                                    <li class="nav-item">
                                        <a href="{{ route('ListarOrdenesDiseñoSala') }}"
                                            class="nav-link {{ setActive('ListarOrdenesDiseñoSala') }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Admin Ordenes Diseño</p>
                                        </a>
                                    </li>
                                @endcan

                                @can('Sala')

                                <li class="nav-item">
                                    <a href="{{ route('RequerimientoCompra') }}"
                                        class="nav-link {{ setActive('RequerimientoCompra') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Requerimientos de Compra</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                @can('Administrador')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-money-bill-alt"></i>
                            <p>
                                Compras
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @can('VentaGiftCard')

                                <li class="nav-item">
                                    <a href="{{ route('ComprasProveedores') }}"
                                        class="nav-link {{ setActive('ComprasProveedores') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingreso Documentos</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('ListarCompras') }}"
                                        class="nav-link {{ setActive('ListarCompras') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Editar Documentos</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('NotasCreditoProveedores') }}"
                                        class="nav-link {{ setActive('NotasCreditoProveedores') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>NC. Proveedores</p>
                                    </a>
                                </li>
                            @endcan

                                <li class="nav-item">
                                    <a href="{{ route('EstadoFacturas') }}"
                                        class="nav-link {{ setActive('EstadoFacturas') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Estado Facturas</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('ConsultaDocumentos') }}"
                                        class="nav-link {{ setActive('ConsultaDocumentos') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Consulta Documentos</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('LibroDeComprasDiario') }}"
                                        class="nav-link {{ setActive('LibroDeComprasDiario') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Libro De Compras Diario</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('VerificacionDocumentos') }}"
                                        class="nav-link {{ setActive('VerificacionDocumentos') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Verificacion De Documentos</p>
                                    </a>
                                </li>
                        </ul>
                    </li>
                @endcan


                @can('Bodega')


                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                Bodega
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">


                            <li class="nav-item">
                                <a href="{{ route('ListarIngresos') }}" class="nav-link {{ setActive('ListarIngresos') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rectificación Ingreso</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('ConteoInventarioBodega') }}" class="nav-link {{ setActive('ConteoInventarioBodega') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Conteo Inventario</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('ConsolidacionInventarioBodega') }}" class="nav-link {{ setActive('ConsolidacionInventario') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Consolidación Inventario</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../UI/sliders.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Consulta</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../UI/modals.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Consulta</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../UI/navbar.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Consulta</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../UI/timeline.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Consulta</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Consulta</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<div class="modal fade" id="mimodalejemplo5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('updatemensaje') }}">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <h3>Envía</h3>
                        <input type="text" disabled name="name" id="name">
                    </div>
                    <div class="card-body">
                        <h6>Mensaje</h6>
                        <textarea name="body" id="body" disabled cols="57" rows="5"></textarea>
                    </div>
                    <div class="card-body">
                        <h6>Fecha</h6>
                        <input type="text" disabled name="created_at" id="created_at">
                    </div>
                    <input type="hidden" name='estado' id='estado'>
                    <input type="hidden" name='id' id='id'>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Eliminar Mensaje</button>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- FIN Modal -->

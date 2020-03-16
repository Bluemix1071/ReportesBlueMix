<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('Publico')}}" class="nav-link">Menu Principal</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('informacion')}}" class="nav-link">Información</a>
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
          <span class="badge badge-danger navbar-badge">{{$conteo1}}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @if (empty($mensaje))

            @else
            <!-- Message Start -->      
            @foreach ($mensaje as $item)
          <a href="" class="dropdown-item" data-toggle="modal" data-target="#mimodalejemplo5"  data-id='{{$item->id}}' data-estado='{{$item->estado}}' data-created_at='{{$item->created_at}}' data-name='{{$item->name}}' data-body='{{$item->body}}'>    
            <div class="media">
              <img src="{{asset("assets/$theme/dist/img/images.png")}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                    {{$item->name}}
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">
                    {{$item->body}}</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 
                  Fecha: {{$item->created_at}}</p>
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
    <a href="{{route('Publico')}}" class="brand-link">
      <img src="{{asset("assets/$theme/dist/img/AdminLTELogo.png")}}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Bluemix</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset("assets/$theme/dist/img/user2-160x160.png")}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> hola, {{session()->get('nombre')}} </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library
              Agregar items de giftcard -->

              @can('RolesYPermisos')
                
                  <li class="nav-item has-treeview">
                  <a href="" class="nav-link">
                      <i class="fas fa-user-tag"></i>
                      <p>
                        Roles Y Permisos
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      
                      <li class="nav-item">
                        <a href="{{route('Roles')}}" class="nav-link {{setActive('indexGiftCard')}} ">
                          <i class="fas fa-cog"></i>
                          <p>Roles</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="#" class="nav-link ">
                          <i class="fas fa-cog"></i>
                          <p>Permisos</p>
                        </a>
                      </li>

                    </ul>
                  </li>
              @endcan





              @can('GiftCard')
                    
                
                  @if (session()->get('tipo_usuario') == 'adminGiftCard' )
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
                        <a href="{{route('indexGiftCard')}}" class="nav-link {{setActive('indexGiftCard')}}">
                          <i class="fas fa-cog"></i>
                          <p>Creacion Folios GiftCard</p>
                        </a>
                      </li>
                    

                      @endcan


                      @can('ActivacionGiftcard')

                      <li class="nav-item">
                        <a href="{{route('Activacion3.0')}}" class="nav-link {{setActive('Activacion3.0')}}">
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
                          <a href="{{route('VentaEmpresa')}}" class="nav-link {{setActive('VentaEmpresa')}}">
                            <i class="fas fa-book"></i>
                            <p>Venta GiftCard Empresas</p>
                          </a>
                        </li>
                      @endcan


                      <li class="nav-item">
                        <a href="{{route('Bloqueo')}}" class="nav-link {{setActive('Bloqueo')}}">
                          <i class="far fa-times-circle"></i>
                          <p>Bloqueo Gift Cards</p>
                        </a>
                      </li>
                      
                      <li class="nav-item">
                          <a href="{{route('consumotarj')}}" class="nav-link {{setActive('consumotarj')}}">
                            <i class="fas fa-book"></i>
                            <p>Consumo De GiftCard</p>
                          </a>
                      </li>

                  

                    </ul>   
                  </li>
                  @endif
              @endcan




              <!-- Agregar items de administrador -->
               @if (session()->get('tipo_usuario')=='admin'|| session()->get('tipo_usuario') == 'adminGiftCard' )

               <li class="nav-item has-treeview " >
                <a href="" class="nav-link ">
                  <i class="nav-icon fas fa-user-lock"></i>
                  <p>
                    Administrador
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>

                <ul class="nav nav-treeview">

                @can('ListarUsers')
                  
                  <li class="nav-item">
                    <a href="{{route('ListarUser')}}" class="nav-link {{setActive('ListarUser')}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Control De Usuarios </p>
                    </a>
                  </li>
                @endcan

                @can('ProductoPorMarca')
                  
                  <li class="nav-item">
                  <a href="{{route('ProductosPorMarca')}}" class="nav-link {{setActive('ProductosPorMarca')}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Producto Por Marca</p>
                    </a>
                  </li>
                @endcan


                  <li class="nav-item">
                    <a href="{{route('ordenesdecompra')}}" class="nav-link {{setActive('ordenesdecompra')}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ordenes De Compra</p>
                    </a>
                  </li>
                 
                   <li class="nav-item">
                   <a href="{{route('chart')}}" class="nav-link {{setActive('chart')}} ">
                      <i class="nav-icon fas fa-chart-pie"></i>
                      <p>Ingresos Por Año
                      </p>
                    </a>
                  </li>

                  {{-- <li class="nav-item">
                    <a href="{{route('porcentaje')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Desviacion
                       </p>
                     </a>
                   </li> --}}

                   <li class="nav-item">
                    <a href="{{route('productos')}}" class="nav-link {{setActive('productos')}}">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Productos
                       </p>
                     </a>
                   </li>

                   <li class="nav-item">
                    <a href="{{route('cargaroc')}}" class="nav-link {{setActive('cargaroc')}}">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Cargar Orden De Compra</p>
                    </a>
                   </li>

                   <li class="nav-item">
                    <a href="{{route('ventaProd')}}" class="nav-link {{setActive('ventaProd')}}">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Venta Productos
                       
                       </p>
                     </a>
                   </li>
                   <li class="nav-item">
                    <a href="{{route('compraProd')}}" class="nav-link {{setActive('compraProd')}}">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Compra Productos
                       
                       </p>
                     </a>
                   </li>

                   {{-- <li class="nav-item">
                    <a href="{{route('ComprasPorHoraIndex')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Ventas Por Hora
                       
                       </p>
                     </a>
                   </li> --}}

                   <li class="nav-item">
                    <a href="{{route('proyeccion')}}" class="nav-link {{setActive('proyeccion')}}">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Proyeccion De Compras
                        </p>
                      </a>
                    </li>


                    <li class="nav-item">
                    <a href="{{route('comprassegunprov')}}" class="nav-link {{setActive('comprassegunprov')}}">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Compras Segun Proveedor
                       </p>
                     </a>
                   </li>

                   {{-- <li class="nav-item">
                    <a href="{{route('movimientoinventario')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Movimiento Mercaderia
                       </p>
                     </a>
                   </li> --}}
                   <li class="nav-item">
                    <a href="{{route('consultafacturaboleta')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                       <p>Consulta Factura Boleta
                       </p>
                     </a>
                   </li>
                  
                </ul>
              </li>
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
              <a href="{{route('ConsultaSaldo')}}" class="nav-link {{setActive('ConsultaSaldo')}} ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Saldo Gift Card</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ProductosNegativos')}}" class="nav-link {{setActive('ProductosNegativos')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos Negativos</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search-dollar"></i>
              <p>
                Sala
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('cambiodeprecios') }}" class="nav-link {{setActive('cambiodeprecios')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cambio de Precios</p>
                </a>
              </li>
              {{-- <li class="nav-item">
              <a href="{{route('GiftCardVenta')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Venta GiftCard</p>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="{{route('CargaTarjetasCaja')}}" class="nav-link {{setActive('CargaTarjetasCaja')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Venta GiftCard</p>
                </a>
              </li>
            </ul>
          </li>
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
                <a href="../UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consulta</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/buttons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consulta</p>
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
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <div class="modal fade" id="mimodalejemplo5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
              <form method="POST" action="{{route('updatemensaje')}}">
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
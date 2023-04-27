@extends("theme.$theme.layout")
@section('titulo')
Compra Agil
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container">
        <h3 class="display-4">Compra Agil</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <div class="card card-primary">
                            {{-- <div class="card-header">
                                <h2 class="card-title">Detalles del Curso</h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                    <!--  <i class="fas fa-times"></i> -->
                                    </button>
                                </div>
                                <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" >Agregar <i class="fas fa-plus"></i></button> -->
                            </div> --}}

                            <div class="card-body collapse hide">

                            {{-- <div class="callout callout-success row">

                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Colegio:</strong> {{ $colegio->colegio}} <br>
                                    <input type="text" value="{{ $colegio->colegio}}" id="colegio" hidden>
                                    <strong>Curso:</strong> {{ $curso->nombre_curso }} <br>
                                    <input type="text" value="{{ $curso->nombre_curso }}" id="curso" hidden>
                                    <strong>Subcurso:</strong> {{ $curso->letra }} <br>
                                    <input type="text" value="{{ $curso->letra }}" id="subcurso" hidden>
                                    <input type="text" value="{{ date('d-m-Y') }}" id="fecha" hidden>
                                    <input type="text" value="{{ count($listas) }}" id="total" hidden>
                                </div>

                            </div> --}}

                            </div>
                        </div>
                            <div class="container">

                                    <div class="form-group row">
                                        <div class="col-1" style="text-algin:left">
                                        <a href="" class="btn btn-success d-flex justify-content-start">Volver</a>
                                        </div>

                                        <div class="col-md-5" style="text-algin:right">
                                            <a href="" title="Cargar Cotizacion" data-toggle="modal" data-target="#modalcotizacion"
                                            class="btn btn-info">(+)Cotización</a>
                                        </div>
                                    </div>

                                    <hr>
                                <div class="form-group row">
                                    <form action="" method="post" enctype="multipart/form-data" id="agregaritem">
                                        <input type="text" value="" name="id_colegio" hidden>
                                    <div class="row">
                                        <input type="text" class="form-control" placeholder="ID CURSO" name="idcurso" required id="idcurso" value="" style="display: none">
                                        &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col-2" value=""/>
                                        &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-6" value=""/>
                                        &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col" value=""/>
                                        &nbsp;<input type="number" id="cantidad" placeholder="Cantidad" required name="cantidad" class="form-control col" value="" min="1" max="99999999"/>
                                    </div>
                                     </form>
                                     <div class="col">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success" >Agregar Item</button>
                                    </div>

                            </div>
                                </div>
                                    <hr>
                                    <br>
                            </div>

                        <br>
            <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">ID_Compra</th>
                                    <th scope="col" style="text-align:left">Rut</th>
                                    <th scope="col" style="text-align:left">Razon Social</th>
                                    <th scope="col" style="text-align:left">Ciudad</th>
                                    <th scope="col" style="text-align:left">Adjudicada</th>
                                    <th scope="col" style="text-align:left">Departamento</th>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Stock Sala</th>
                                    <th scope="col" style="text-align:left">Stock Bodega</th>
                                    <th scope="col" style="text-align:left">Costo C/U</th>
                                    <th scope="col" style="text-align:left">Costo Total</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:left">1</td>
                                    <td style="text-align:left">2</td>
                                    <td style="text-align:left">3</td>
                                    <td style="text-align:left">4</td>
                                    <td style="text-align:left">5</td>
                                    <td style="text-align:left">6</td>
                                    <td style="text-align:left">7</td>
                                    <td style="text-align:left">8</td>
                                    <td style="text-align:left">9</td>
                                    <td style="text-align:left">10</td>
                                    <td style="text-align:left">11</td>
                                    <td style="text-align:left">12</td>
                                    <td style="text-align:left">13</td>
                                    <td style="text-align:left">14</td>
                                    <td style="text-align:left">Botones</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                {{-- <tr>
                                    <td colspan="8"><strong>Total</strong> </td>
                                    @if (empty($total))
                                        <td><span class="price text-success">$</span></td>
                                    @else
                                        <td style="text-align:right"><span
                                                class="price text-success">${{ number_format($total, 0, ',', '.') }}</span>
                                                <input type="text" value="{{ number_format($total, 0, ',', '.') }}" id="montosubtotal" hidden>
                                                <input type="text" value="{{ number_format(($total-($total*0.10)), 0, ',', '.') }}" id="montototal" hidden>
                                        </td>
                                    @endif
                                </tr> --}}
                            </tfoot>

                    </table>
                </div>
            </div>
          </div>
        </div>
</div>
@endsection

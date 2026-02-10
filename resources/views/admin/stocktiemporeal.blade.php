@extends("theme.$theme.layout")
@section('titulo')
    Stock Tiempo Real
@endsection
@section('styles')

    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h3 class="display-3">Stock Tiempo Real</h3>
            </div>
            <div class="col md-6">
                {{-- algo al lado del titulo --}}

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <strong>Tip:</strong> Para copiar o exportar todos los registros (más de 27.000), utiliza el botón
                    <strong>Excel</strong>. Es mucho más rápido y seguro para grandes cantidades de datos.
                </div>
                <table id="productos" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Stock Sala</th>
                            <th scope="col">Stock Bodega</th>
                            <th scope="col">Precio Detalle</th>
                            <th scope="col">Precio Mayor</th>
                            <th scope="col">Neto</th>
                            <th scope="col">Cambio Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            $('#productos thead tr').clone(true).appendTo('#productos thead');
            $('#productos thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Buscar ' + title + '" />');

                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table = $('#productos').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('stocktiemporeal') }}",
                    type: 'GET'
                },
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                pageLength: 100,
                deferRender: true,
                columns: [
                    { data: 'codigo', name: 'bp.bpprod' },
                    { data: 'descripcion', name: 'p.ARDESC' },
                    { data: 'marca', name: 'p.ARMARCA' },
                    { data: 'stock_sala', name: 'bp.bpsrea' },
                    { data: 'stock_bodega', name: 'sb.cantidad', searchable: false },
                    { data: 'precio_detalle', name: 'pr.PCPVDET' },
                    { data: 'precio_mayor', name: 'pr.PCPVMAY' },
                    { data: 'neto', name: 'pr.PCCOSTOREA', searchable: false },
                    { data: 'FechaCambioPrecio', name: 'pr.FechaCambioPrecio' }
                ],
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: 'Copiar',
                        action: function (e, dt, node, config) {
                            var self = this;

                            Swal.fire({
                                title: 'Copiando registros...',
                                text: 'Esto puede tardar unos segundos para los más de 27.000 registros.',
                                allowOutsideClick: false,
                                onOpen: () => {
                                    Swal.showLoading()
                                }
                            });

                            $.ajax({
                                url: "{{ route('stocktiemporeal') }}",
                                type: 'GET',
                                timeout: 120000, // 2 minutos de espera
                                data: {
                                    draw: 1,
                                    start: 0,
                                    length: -1, // Obtener todos
                                    search: {
                                        value: dt.search()
                                    }
                                },
                                success: function (json) {
                                    var output = "Codigo\tDescripcion\tMarca\tStock Sala\tStock Bodega\tPrecio Detalle\tPrecio Mayor\tNeto\tCambio Precio\n";

                                    output += json.data.map(function (row) {
                                        return (row.codigo || '') + "\t" +
                                            (row.descripcion || '') + "\t" +
                                            (row.marca || '') + "\t" +
                                            (row.stock_sala || 0) + "\t" +
                                            (row.stock_bodega || 0) + "\t" +
                                            (row.precio_detalle || '') + "\t" +
                                            (row.precio_mayor || '') + "\t" +
                                            (row.neto || '') + "\t" +
                                            (row.FechaCambioPrecio || '');
                                    }).join('\n');

                                    // Intentar usar la API moderna de portapapeles
                                    if (navigator.clipboard && window.isSecureContext) {
                                        navigator.clipboard.writeText(output).then(function () {
                                            Swal.close();
                                            Swal.fire('¡Copiado!', 'Se han copiado ' + json.data.length + ' registros al portapapeles.', 'success');
                                        }, function (err) {
                                            console.error('Error al copiar: ', err);
                                            fallbackCopyTextToClipboard(output, json.data.length);
                                        });
                                    } else {
                                        fallbackCopyTextToClipboard(output, json.data.length);
                                    }

                                    function fallbackCopyTextToClipboard(text, count) {
                                        var textArea = document.createElement("textarea");
                                        textArea.value = text;
                                        textArea.style.position = "fixed";  // Evitar scroll
                                        document.body.appendChild(textArea);
                                        textArea.focus();
                                        textArea.select();

                                        try {
                                            var successful = document.execCommand('copy');
                                            if (successful) {
                                                Swal.close();
                                                Swal.fire('¡Copiado!', 'Se han copiado ' + count + ' registros al portapapeles.', 'success');
                                            } else {
                                                throw new Error('execCommand falló');
                                            }
                                        } catch (err) {
                                            Swal.close();
                                            Swal.fire({
                                                title: 'Error de Seguridad',
                                                text: 'El navegador bloqueó el copiado automático. Por favor, usa el botón Excel para descargar los datos.',
                                                icon: 'warning'
                                            });
                                        }
                                        document.body.removeChild(textArea);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    Swal.close();
                                    if (textStatus === 'timeout') {
                                        Swal.fire('Error', 'El servidor tardó demasiado en responder. Intenta usar el botón Excel.', 'error');
                                    } else {
                                        Swal.fire('Error', 'No se pudo obtener la información para copiar.', 'error');
                                    }
                                }
                            });
                        }
                    },
                    {
                        text: 'Excel',
                        action: function (e, dt, node, config) {
                            window.location.href = "{{ route('exportExcelStockTiempoReal') }}";
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    }
                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior",

                    },
                    "loadingRecords": "Cargando registros...",
                    "processing": "Procesando...",
                    "emptyTable": "No hay resultados",
                    "zeroRecords": "No hay coincidencias",
                    "infoEmpty": "",
                    "infoFiltered": ""
                },
                orderCellsTop: true,
                fixedHeader: true
            });

        });
    </script>
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
    {{--
    <link rel="stylesheet" href="{{ asset(" assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}"> --}}
    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>



    <script src="{{ asset('js/ajaxProductosNegativos.js') }}"></script>


@endsection

              <table id="productos" class="table table-bordered table-hover dataTable">
                  <thead>
                    <tr>
                      <th scope="col">Nro De Orden</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($productos as $item)
                    <tr>
                        <td>{{$item->nombre_del_proveedor}}</td>
                      <th >{{$item->numero_de_orden_de_compra}}</th>
                      <td>{{$item->fecha}}</td>
                      <td>{{$item->total}}</td>
                      @if ($item->estado =='Autorizada')
                      <td><font color="Lime">Autorizada</font></td>
                      @elseif ($item->estado =='creada')
                      <td><font color="Blue">Creada</font></td>
                      @else
                      <td><font color="red">Nula</font></td>
                      @endif
      
                    </tr>
                      @endforeach
                    </tbody>
                </table>

      
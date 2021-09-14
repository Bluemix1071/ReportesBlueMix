<table id="productos" class="table table-bordered table-hover dataTable">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Ubicacion</th>
            <th scope="col">Codigo</th>
            <th scope="col">Stock Bodega</th>
            <th scope="col">Stock Sala</th>
          </tr>
        </thead>
        <tbody id="res">
        @foreach($productos as $item)
          <tr>
            <th >{{$item->nombre}}</th>
            <td>{{$item->ubicacion}}</td>
            <td>{{$item->codigo}}</td>
            <td>{{$item->bodega_stock}}</td>
            <td>{{$item->sala_stock}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{$productos->render()}}

<table>
    <thead>
      <tr>
        <th >Nombre Del Producto</th>
        <th >Codigo</th>
        <th >Marca</th>
        <th >Stock Bodega</th>
        <th >Stock Sala</th>
        <th >Precio Costo Neto</th>
        <th >Total Costo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($Productos_x_Marca as $item)
        <tr>
          <th >{{$item->nombre_del_producto}}</th>
          <td>{{$item->codigo_producto}}</td>
          <td>{{$item->MARCA_DEL_PRODUCTO}}</td>
          <td>{{$item->cantidad_en_bodega}}</td>
          <td>{{$item->cantidad_en_sala}}</td>
          <td>{{$item->precio_costo_neto}}</td>
          <td>{{$item->total_costo}}</td>
        </tr>
        @endforeach
      </tbody>
 
  </table>
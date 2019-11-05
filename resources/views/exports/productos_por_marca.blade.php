<table>
    <thead>
        <tr>
            <th scope="col" colspan="3" style="color:#F4F6F9"></th>
            
            <th scope="col" colspan="3" style="text-align:center">Stock</th>
            <th  style="color:#F4F6F9" colspan="2" ></th>
           
        </tr>
      <tr>
        <th  >Nombre Del Producto</th>
        <th style="text-align:center" >Codigo</th>
        <th style="text-align:center" >Marca</th>
        <th style="text-align:center" > Bodega</th>
        <th style="text-align:center" > Sala</th>
        <th style="text-align:center" > Total</th>
        <th style="text-align:center" >Precio Costo Neto</th>
        <th style="text-align:center" >Total Costo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($Productos_x_Marca as $item)
      <tr>
          <th >{{$item->nombre_del_producto}}</th>
          <td style="text-align:center">{{$item->codigo_producto}}</td>
          <td style="text-align:center">{{$item->MARCA_DEL_PRODUCTO}}</td>
          <td style="text-align:center">{{$item->cantidad_en_bodega}}</td>
          <td style="text-align:center">{{$item->cantidad_en_sala}}</td>
          <td style="text-align:center">{{$item->cantidad_en_bodega+$item->cantidad_en_sala}}</td>
          <td style="text-align:center">{{$item->precio_costo_neto}}</td>
          <td style="text-align:center">{{$item->total_costo}}</td>
        </tr>
        @endforeach
      </tbody>
 
  </table>
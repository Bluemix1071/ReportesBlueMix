<table>
    <thead>
        <tr>
          <th >Nr° Orden De Compra</th>
          <th >Rut Proveedor</th>
          <th >Nombre Proveedor</th>
          <th >Fecha</th>
        </tr>
      </thead>
      <tbody>
     
          <tr>
            <td>{{$ordendecompra[0]->numero_de_orden_de_compra}}</td>
            <th>{{$ordendecompra[0]->RutProveedor}}</th>
            <td >{{$ordendecompra[0]->NombreProveedor}}</td>
            <td >{{$ordendecompra[0]->fecha}}</td>
           
          </tr>
      
        </tbody>
</table>


<table >
    <thead>
      <tr >
        <th >Cód prov.</th>
        <th >Descripción</th>
        <th >Marca</th>
        <th >Unidad</th>
        <th >Neto</th>
        <th >Cantidad</th>
        <th >Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($ordendecompradetalle as $item)
        <tr>
          <th>{{$item->CodProveedor,}}</th>
          <td>{{$item->Descripcion}}</td>
          <td >{{$item->Marca}}</td>
          <td >{{$item->Unidad}}</td>
          <td>{{$item->Precio}}</td>
          <td >{{$item->cantidad}}</td>
          <td>{{$item->Total}}</td>
        </tr>
        @endforeach
      </tbody>
  </table>
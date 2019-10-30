<table>
    <thead>
    <tr>
        <th >Fecha</th>
        <th >Código</th>
        <th >Descripción</th>
        <th >Marca</th>
        <th >Mayor</th>
        <th >Detalle</th>
    </tr>
    </thead>
    <tbody>
    @foreach($desviacion as $xd)
        <tr>
                     <td>{{$xd->FechaCambioPrecio}}</td>
                    <th >{{$xd->codigo}}</th>
                    <td>{{$xd->descripcion}}</td>
                    <td>{{$xd->marca}}</td>
                    <td>{{$xd->mayor}}</td>
                    <td>{{$xd->detalle}}</td>
         
        </tr>
    @endforeach
    </tbody>
</table>
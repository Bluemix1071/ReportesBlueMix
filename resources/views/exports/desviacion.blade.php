<table>
    <thead>
    <tr>
        <th >Codigo</th>
        <th >Descripcion</th>
        <th >% Desviacion</th>
        <th >Diferencia</th>
        <th >Ultima Fecha</th>
        <th >Penultima Fecha</th>
    </tr>
    </thead>
    <tbody>
    @foreach($desviacion as $xd)
        <tr>
                     <td>{{$item->codigo}}</td>
                    <th >{{$item->descripcion}}</th>
                    <td>{{$item->desv}}</td>
                    <td>{{$item->diferencia}}</td>
                    <td>{{$item->ultima_fecha}}</td>
                    <td>{{$item->penultima_fecha}}</td>
         
        </tr>
    @endforeach
    </tbody>
</table>
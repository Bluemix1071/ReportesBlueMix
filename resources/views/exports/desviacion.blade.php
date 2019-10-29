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
                     <td>{{$xd->codigo}}</td>
                    <th >{{$xd->descripcion}}</th>
                    <td>{{$xd->desv}}</td>
                    <td>{{$xd->diferencia}}</td>
                    <td>{{$xd->ultima_fecha}}</td>
                    <td>{{$xd->penultima_fecha}}</td>
         
        </tr>
    @endforeach
    </tbody>
</table>
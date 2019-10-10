<table>
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Ubicacion</th>
        <th>Codigo</th>
        <th>Bodega stock</th>
        <th>Sala stock</th>
    </tr>
    </thead>
    <tbody>
    @foreach($productos_negativos as $xd)
        <tr>
            <td>{{ $xd->nombre }}</td>
            <td>{{ $xd->ubicacion }}</td>
            <td>{{ $xd->codigo }}</td>
            <td>{{ $xd->bodega_stock }}</td>
            <td>{{ $xd->sala_stock }}</td>
         
        </tr>
    @endforeach
    </tbody>
</table>
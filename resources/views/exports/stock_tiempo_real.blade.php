<table>
    <thead>
    <tr>
        <th>Código</th>
        <th>Descripción</th>
        <th>Marca</th>
        <th>Stock Sala</th>
        <th>Stock Bodega</th>
        <th>Precio Detalle</th>
        <th>Precio Mayor</th>
        <th>Neto</th>
        <th>Fecha Cambio Precio</th>
    </tr>
    </thead>
    <tbody>
    @foreach($productos as $producto)
        <tr>
            <td>{{ $producto->codigo }}</td>
            <td>{{ $producto->descripcion }}</td>
            <td>{{ $producto->marca }}</td>
            <td>{{ $producto->stock_sala }}</td>
            <td>{{ $producto->stock_bodega }}</td>
            <td>{{ $producto->precio_detalle }}</td>
            <td>{{ $producto->precio_mayor }}</td>
            <td>{{ $producto->neto }}</td>
            <td>{{ $producto->FechaCambioPrecio }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

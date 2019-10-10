<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>ajdjasjdadj</th>
    </tr>
    </thead>
    <tbody>
    @foreach($productos_negativos as $xd)
        <tr>
            <td>{{ $xd->nombre }}</td>
         
        </tr>
    @endforeach
    </tbody>
</table>
import React, { Fragment } from 'react';


const TablaProductosReIngreso = (props) => {
    return (
        <Fragment>
            <table className="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Codigo barra</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Cantidad</th>

                    </tr>
                </thead>
                <tbody>


                    {
                        props.Productos.length > 0 ?
                            props.Productos.map((item, index) => (
                                <tr key={item.codigo_producto}>
                                    <th scope="row">{item.codigo_producto}</th>
                                    <th>{item.codigoBarra}</th>
                                    <th>{item.descripcion}</th>
                                    <th>{item.cantidad}</th>

                                </tr>
                            )) : (

                                <tr>
                                    <td colSpan={4} >No hay productos</td>
                                </tr>
                            )



                    }

                </tbody>
            </table>
        </Fragment>
      );
}

export default TablaProductosReIngreso;

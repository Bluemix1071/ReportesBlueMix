import React, { Fragment } from 'react';

const TablaMercaderia = (props) => {

    const Editar = (Product) => {

        console.log(Product);
        props.setEditProduct(true);
        props.setProductoEditar(Product);
    }

    return (
        <Fragment>
            <table className="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Codigo barra</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Acciones</th>
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
                                    <th> {item.cantidad} </th>
                                    <th>
                                        <button
                                            className="btn btn-danger mr-2"
                                            onClick={() => { props.EliminarProducto(item.codigo_producto) }}

                                        ><i className="fas fa-trash-alt"></i>

                                        </button>
                                        <button className="btn btn-primary ml-2"
                                            onClick={() => { Editar(item) }}

                                        ><i className="fas fa-edit"></i>
                                        </button>
                                    </th>
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

export default TablaMercaderia;

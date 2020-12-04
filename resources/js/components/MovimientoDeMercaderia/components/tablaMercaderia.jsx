import React, { Fragment } from 'react';

const TablaMercaderia = (props) => {

    const Editar =(codigo,valor)=>{


    }

    return (
        <Fragment>
            <table class="table table-sm">
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
                                    <th> <input className="form-control" name="cantidad" type="number" defaultValue={item.cantidad} disabled
                                            onChange={
                                                (event)=>{
                                                    props.updateProduct(item.codigo_producto,event.target.value)
                                                }
                                            }
                                    /> </th>
                                    <th>
                                        <button
                                            className="btn btn-danger mr-2"
                                            onClick={() => { props.EliminarProducto(item.codigo_producto) }}

                                        ><i class="fas fa-trash-alt"></i>

                                        </button>
                                        <button className="btn btn-primary ml-2"


                                        ><i class="fas fa-edit"></i></button>
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

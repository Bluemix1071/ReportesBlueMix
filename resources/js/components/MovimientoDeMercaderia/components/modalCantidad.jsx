
import React, { Fragment, useEffect, useRef, useState } from 'react';

import { Button, Modal } from 'react-bootstrap';
import { useForm } from 'react-hook-form';
import { useSelector } from 'react-redux';

const ModalCantidad = (props) => {

    const { register, errors, handleSubmit } = useForm();
    const Buscador = useSelector(state => state.Buscador)
    const [Producto, setProducto] = useState([]);

    const onSubmit = (data, e) => {

        console.log(data.cantidad);
        const product = Buscador.producto[0].producto[0];
        Object.assign(product, { cantidad: data.cantidad })


        props.ingresoProducto(product);
        ocultar();

    }





    const mostrar = () => {
        props.mostarModal();
    }

    const ocultar = () => {
        props.ocultarModal();
    }

    return (
        <Fragment>
            <Modal show={props.show} onHide={ocultar} >
                <Modal.Header closeButton >




                </Modal.Header>

                <Modal.Body>




                    {Buscador.FETCH_PRODUCT_SUCCESS &&

                    <label> ingrese cantidad de : {Buscador.producto[0].producto[0].descripcion} </label >


                    }


                    <form onSubmit={handleSubmit(onSubmit)}>

                        <input type="number" className="form-control"   name="cantidad" placeholder="cantidad"

                            ref={

                                register({
                                    required: {
                                        pattern:"^[0-9]+",
                                        value: true,
                                        message: 'cantidad es requerido'
                                    }
                                })
                            } />

                    </form>

                </Modal.Body>
                <Modal.Footer>


                </Modal.Footer>
            </Modal>
        </Fragment>
    );
}

export default ModalCantidad;

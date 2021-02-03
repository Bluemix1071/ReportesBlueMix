
import React, { Fragment, useEffect, useRef, useState } from 'react';

import { Button, Modal } from 'react-bootstrap';
import { useForm } from 'react-hook-form';
import { useSelector } from 'react-redux';

const ModalEditar = (props) => {

    const { register, errors, handleSubmit } = useForm();
    const Buscador = useSelector(state => state.Buscador)

    const onSubmit = (data, e) => {
        const product =props.ProductoEditar;
        product.cantidad=data.cantidad;
        console.log(product);

        props.EditarProducto(product);



    }





    const mostrar = () => {
        props.mostarModal();
    }

    const ocultar = () => {
        props.setEditProduct(false);
    }

    return (
        <Fragment>
            <Modal show={props.EditProduct} onHide={ocultar} >
                <Modal.Header closeButton >


                Ingrese la nueva cantidad del producto

                </Modal.Header>

                <Modal.Body>




                    {props.ProductoEditar &&

                    <label> ingrese cantidad de : {props.ProductoEditar.descripcion} </label >


                    }


                    <form onSubmit={handleSubmit(onSubmit)}>

                        <input type="number" className="form-control" autoFocus={true}  name="cantidad" placeholder="cantidad"

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

export default ModalEditar;

import React, { Fragment } from 'react';
import { Modal } from 'react-bootstrap';
import { useForm } from 'react-hook-form';

const ModalConfirmarCaja = (props) => {

    const { register, errors, handleSubmit } = useForm();


    const onSubmit = (data, e) => {

        console.log(data);

        props.EnviarProductos(data);

    }


    const mostrar = () => {
        props.mostarModalConfirm();
    }

    const ocultar = () => {
        props.ocultarModalConfirm();
    }

    return (

        <Fragment>
            <Modal show={props.showModalConfirm} onHide={ocultar} >
                <Modal.Header closeButton>
                ¿La Mercaderia esta completa ?
                </Modal.Header>

                <Modal.Body>

                    <form onSubmit={handleSubmit(onSubmit)}>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="estado" id="inlineRadio1" value="Completado" defaultChecked
                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'marca una opcion es requerido'
                                    }
                                })
                            }



                            />
                                <label class="form-check-label" for="inlineRadio1">Si</label>
                        </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="estado" id="inlineRadio2" value="Pendiente"
                                 ref={
                                    register({
                                        required: {
                                            value: true,
                                            message: 'marca una opcion es requerido'
                                        }
                                    })
                                } />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                        <button className="btn btn-success ml-4" > Confirmar </button>
                </form>

            </Modal.Body>
                        <Modal.Footer>


                        </Modal.Footer>
        </Modal>
    </Fragment>
      );
}

export default ModalConfirmarCaja;

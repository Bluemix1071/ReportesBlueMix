
import React, { Fragment } from 'react';
import { Modal } from 'react-bootstrap';
import { useForm } from 'react-hook-form';


const ModalReIngreso = (props) => {


    const onSubmit = ()=>{
        console.log('modal');
    }

    const { register, errors, handleSubmit } = useForm();

    const mostrar = () => {
        props.mostarModal();
    }

    const ocultar = () => {
        props.ocultarModal();
    }

    const ReingresarCajaModal= ()=>{

    props.ReIngresarMercaderia(props.caja.id)
    }




    return (

        <Fragment>
            <Modal show={props.ModalReIngreso} onHide={ocultar} >
                <Modal.Header closeButton>
                    ¿Esta Seguro/a De ReIngresar la Mercaderia  {props.caja.id} ?
                </Modal.Header>

                <Modal.Body>



                        <button className="btn btn-success ml-4" onClick={()=>ReingresarCajaModal()}> Confirmar </button>
                        <button className="btn btn-danger ml-4" onClick={()=>ocultar()} > Cancelar </button>


                </Modal.Body>
                <Modal.Footer>


                </Modal.Footer>
            </Modal>
        </Fragment>

    );
}

export default ModalReIngreso;

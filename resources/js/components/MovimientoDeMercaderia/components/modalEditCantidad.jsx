import React from 'react';

const ModalEditCantidad = (props) => {


    const { register, errors, handleSubmit } = useForm();

    const onSubmit = (data, e) => {

        console.log(data);

    }

    return (

        <Fragment>
        <Modal show={props.showEdit} onHide={ props.showEdit == true ? false : true} >
            <Modal.Header closeButton>

            </Modal.Header>

            <Modal.Body>

                <form onSubmit={handleSubmit(onSubmit)}>

                    <input type="number" className="form-control"   name="cantidadEdit" placeholder="cantidad"

                        ref={

                            register({
                                required: {
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

export default ModalEditCantidad;

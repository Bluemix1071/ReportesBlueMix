import React, { Fragment } from 'react';

import { Modal } from 'react-bootstrap';

const ModalCupon = (props) => {


    const ocultar = () => {

        props.ocultarModalCupon();

    }



    return (
<Fragment>
            <Modal show={props.showModal} onHide={ocultar} >
                <Modal.Header closeButton>
                <h1> Numero De Cupon  </h1>
                </Modal.Header>

                <Modal.Body>
              <h1 className="text-center">{props.CuponEscolar.nro_cupon? props.CuponEscolar.nro_cupon: ''}</h1>


            </Modal.Body>
                        <Modal.Footer>


                        </Modal.Footer>
        </Modal>
    </Fragment>


     );
}

export default ModalCupon;

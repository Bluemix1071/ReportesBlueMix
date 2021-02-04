import React, { Fragment, useState } from 'react';

import { Accordion, Button, Card } from 'react-bootstrap';



const ListadosDeCajas = () => {
    const [open, setOpen] = useState(false);
    return (

        <Fragment>
            <div className="container my-4">
                <div className="row">
                    <div className="col md-6">
                        <h1>Listado de mercaderia</h1>


                    </div>
                </div>

                <div className="row">
                    <div className="col-md-12">

                        <Accordion >
                            <Card>
                                <Accordion.Toggle as={Card.Header} eventKey="0">
                                    Click me!
                                </Accordion.Toggle>
                                <Accordion.Collapse eventKey="0">
                                    <Card.Body>Hello! I'm the body</Card.Body>
                                </Accordion.Collapse>
                            </Card>
                            <Card>
                                <Accordion.Toggle as={Card.Header} eventKey="1">
                                    Click me!
                                 </Accordion.Toggle>
                                <Accordion.Collapse eventKey="1">
                                    <Card.Body>Hello! I'm another body</Card.Body>
                                </Accordion.Collapse>
                            </Card>
                        </Accordion>
                    </div>
                </div>
            </div>
        </Fragment>
    );
}

export default ListadosDeCajas;

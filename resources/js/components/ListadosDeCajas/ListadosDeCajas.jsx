import React, { Fragment, useState } from 'react';

// import { Accordion, Button, Card } from 'react-bootstrap';


//componentes
import TablaListadoCajas from './components/TablaListadoCajas';




const ListadosDeCajas = () => {
    return (

        <Fragment>
            <div className="container my-4">
                <div className="row">
                    <div className="col md-6">
                        <h1>Listado De Cajas</h1>


                    </div>
                </div>

                <div className="row">
                    <div className="col-md-12">
                     <form>

                    <div className="input-group flex-nowrap mt-5">

                        <div className="input-group-prepend">
                            <span className="input-group-text" id="addon-wrapping">Buscar</span>
                        </div>
                        <input type="number" className="form-control" name="caja" autoFocus placeholder="Mercaderia"

                        />
                    </div>

                    </form>

                    </div>
                </div>
                <hr/>
                <div className="row">
                    <div className="col-md-12">
                        {/* Tabla De Productos */}

                                <TablaListadoCajas/>
                    </div>


                </div>
            </div>
        </Fragment>
    );
}

export default ListadosDeCajas;

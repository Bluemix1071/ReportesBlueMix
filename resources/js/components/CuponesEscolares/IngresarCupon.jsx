import React, { useEffect, useState } from 'react';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bs-stepper/dist/css/bs-stepper.min.css';
import Stepper from 'bs-stepper'
import Step from '../stepper/components/step';
import FormApoderado from './components/FormApoderado';



const IngresoCupon = () => {

    const [stepperr, setstepperr] = useState();
    useEffect(() => {

        setstepperr(new Stepper(document.querySelector('#stepper1'), {
            linear: false,
            animation: true
        }))

    }, [])
    const steps = [
        { target: '#item1', number: 1, text: 'Datos Apoderado' },
        { target: '#item2', number: 2, text: 'Datos Alumno' },
    ]
    const stepLoad = (e) => {
        e.preventDefault();
    }


    return (
        <div className="container my-4">

            <div className="row mb-4">
                <div className="col-md-6">
                    <h1>Ingreso  Cupon</h1>
                </div>
                <div className="col-md-6">

                </div>
            </div>
            <div className="row">

                <div className="col-md-12">
                    <div id="stepper1" class="bs-stepper">
                        <div className="bs-stepper-header">
                            <Step steps={steps} />
                        </div>
                        <div className="bs-stepper-content">

                                <div id="item1" className="content">
                                    <FormApoderado />
                                    <button className="btn btn-primary" onClick={() => stepperr.next()}>Next</button>
                                </div>
                                <div id="item2" className="content">

                                        <h1>formulario alumno</h1>

                                        <button className="btn btn-primary" onClick={() => stepperr.previous()}>Next</button>
                                </div>

                        </div>
                    </div>





                </div>
            </div>


        </div >
    );
}

export default IngresoCupon;

import React, { useEffect, useState } from 'react';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bs-stepper/dist/css/bs-stepper.min.css';
import Stepper from 'bs-stepper'
import Step from '../stepper/components/step';
import FormApoderado from './components/FormApoderado';
import FormAlumno from './components/FormAlumno';
import { getComunas } from './services/getComunas';




const IngresoCupon = () => {

    const [stepperr, setstepperr] = useState();
    useEffect(() => {

        setstepperr(new Stepper(document.querySelector('#stepper1'), {
            linear: false,
            animation: true
        }))

    }, [])


    const [Comunas, setcomunas] = useState([]);
    const [SelectComunas, setSelectComunas] = useState([]);

    useEffect(() => {
        addComuna()
    }, []);

    useEffect(() => {
        const arreglo=[];
        for (let index = 0; index < Comunas.length; index++) {

            var item = Comunas[index];
            arreglo.push({
                "value": item.nombre,
                "label": item.nombre,
              })
            setSelectComunas(arreglo);
        }
    }, [Comunas])




    const addComuna = async (comuna) => {

        await getComunas()
            .then(resp => {
                setcomunas(resp.data);
            })
            .catch(error => {

            })
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
                    <div id="stepper1" className="bs-stepper">
                        <div className="bs-stepper-header">



                            <div className="step" data-target="#item1">
                                <button className="step-trigger">
                                    <span className="bs-stepper-circle">1</span>
                                    <span className="bs-stepper-label">Datos Apoderado</span>
                                </button>
                            </div>
                            <div className="line"></div>
                            <div className="step" data-target="#item2">
                                <button className="step-trigger">
                                    <span className="bs-stepper-circle">2</span>
                                    <span className="bs-stepper-label">Datos Alumno</span>
                                </button>
                            </div>





                        </div>
                        <div className="bs-stepper-content">

                            <div id="item1" className="content">
                                <FormApoderado SelectComunas={SelectComunas} />
                                <button className="btn btn-primary" onClick={() => stepperr.next()}>Next</button>
                            </div>
                            <div id="item2" className="content">

                                <FormAlumno />

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

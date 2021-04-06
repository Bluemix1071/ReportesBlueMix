import React, { useEffect, useRef, useState } from 'react';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bs-stepper/dist/css/bs-stepper.min.css';
import Stepper from 'bs-stepper'
import Step from '../stepper/components/step';
import FormApoderado from './components/FormApoderado';
import FormAlumno from './components/FormAlumno';
import { getComunas } from './services/getComunas';
import { getColegios } from './services/getColegios';

import ModalCupon from './components/ModalCupon';

import { GenerarCuponService } from './services/GenerarCuponServices';
import { useScrollTrigger } from '@material-ui/core';

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
    const [Colegios, setColegios] = useState([]);
    const [SelectColegios, setSelectColegios] = useState([]);
    const [CuponEscolar, setCuponEscolar] = useState([]);



    /*REset formularios  */
    const FormAlumnoRef = useRef(null);
    const FormApoderadoRef = useRef(null);

    useEffect(() => {
        console.log(FormAlumnoRef);
        console.log(FormApoderadoRef);

        console.log();

    }, []);
    /*fin REset formularios  */

    const [ValidaComunas, setValidaComunas] = useState(false);
    // datos

    const [Apoderado, setApoderado] = useState([]);
    const [Alumno, setAlumno] = useState([]);

    // modal cupon
    const [showModal, setShowModal] = useState(false);

    const ocultarModalCupon = () => {
        setShowModal(false);

    }


    const [EnvioCupon, setEnvioCupon] = useState(false);
    const AddApoderado = (apoderado) => {
        //console.log(apoderado)
        setApoderado(apoderado)

        //console.log(Apoderado)
    }




    useEffect(() => {
        addComuna();
        addColegios();
    }, []);

    useEffect(() => {
        const arreglo = [];
        for (let index = 0; index < Comunas.length; index++) {

            var item = Comunas[index];
            arreglo.push({
                "value": item.nombre,
                "label": item.nombre,
            })
            setSelectComunas(arreglo);
        }
    }, [Comunas])

    useEffect(() => {
        const arreglo = [];
        for (let index = 0; index < Colegios.length; index++) {

            var item = Colegios[index];
            arreglo.push({
                "value": item.TAGLOS,
                "label": item.TAGLOS,
            })

            setSelectColegios(arreglo);
        }
    }, [Colegios])


    useEffect(() => {
        if (EnvioCupon) {
            GenerarCupon();
        }


    }, [EnvioCupon])


    const addComuna = async (comuna) => {

        await getComunas()
            .then(resp => {

                setcomunas(resp.data);
            })
            .catch(error => {
                setValidaComunas(true);
                console.log(error)
            })
    }

    const addColegios = async (colegios) => {

        await getColegios()
            .then(resp => {
                console.log(resp);
                setColegios(resp.data);



            })
            .catch(error => {
                console.log(error)
            })
    }


    const AddAlumno = (alumno) => {
        setAlumno(alumno);
        setEnvioCupon(true);


    }


    const GenerarCupon = async () => {

        const alumn = JSON.stringify(Alumno);
        const apod = JSON.stringify(Apoderado);

        await GenerarCuponService({ alumn, apod })
            .then(resp => {

                setEnvioCupon(false);
                console.log(resp.data);
                setCuponEscolar(resp.data.Cupon);
                setApoderado([]);
                setAlumno([]);

                FormAlumnoRef.current.reset();
                FormApoderadoRef.current.reset();
                setShowModal(true);
                stepperr.previous()



            })
            .catch(error => {
                console.log(error)
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



                            <div className="step" data-target="#item1" >
                                <button className="step-trigger" disabled>
                                    <span className="bs-stepper-circle">1</span>
                                    <span className="bs-stepper-label">Datos Apoderado</span>
                                </button>
                            </div>
                            <div className="line"></div>
                            <div className="step" data-target="#item2" >
                                <button className="step-trigger" disabled>
                                    <span className="bs-stepper-circle">2</span>
                                    <span className="bs-stepper-label">Datos Alumno</span>
                                </button>
                            </div>





                        </div>
                        <div className="bs-stepper-content">

                            <div id="item1" className="content">
                                <FormApoderado SelectComunas={SelectComunas}
                                    stepperr={stepperr}
                                    AddApoderado={AddApoderado}
                                    ValidaComunas={ValidaComunas}
                                    Apoderado={Apoderado}
                                    FormApoderadoRef={FormApoderadoRef} />

                            </div>
                            <div id="item2" className="content">

                                <FormAlumno SelectColegios={SelectColegios}
                                    stepperr={stepperr}
                                    Apoderado={Apoderado}
                                    GenerarCupon={GenerarCupon}
                                    AddAlumno={AddAlumno}
                                    Alumno={Alumno}
                                    FormAlumnoRef={FormAlumnoRef} />

                                <button className="btn btn-primary" onClick={() => stepperr.previous()}>Anterior</button>


                            </div>



                                <ModalCupon
                                showModal={showModal}
                                ocultarModalCupon={ocultarModalCupon}
                                 CuponEscolar={CuponEscolar} />

                        </div>
                    </div>





                </div>
            </div>


        </div >
    );
}

export default IngresoCupon;

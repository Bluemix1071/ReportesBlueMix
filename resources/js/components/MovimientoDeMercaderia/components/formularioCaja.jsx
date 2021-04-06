import React, { Fragment, useEffect, useRef, useState } from 'react';
import { useForm } from 'react-hook-form';

const FormularioCaja = (props) => {

    const { register, errors, handleSubmit } = useForm({

            defaultValues: props.Caja ? props.Caja : {}



    });





    const onSubmit = (data, e) => {

        console.log(data);
        //props.ocultarForm();
        props.EnviarCaja(data);
        props.stepperr.next();



    }


    return (
        <Fragment>
            <form onSubmit={handleSubmit(onSubmit)} ref={props.myForm} className="needs-validation" >
                <div className="form-row">
                    <div className="col-md-4 mb-3">
                        <label >usuario</label>
                        <input type="hidden" className="form-control" name="id" id="idcaja" required
                            ref={
                                register({
                                    required: {
                                        value: false,

                                    }
                                })
                            }

                        />
                        <input type="text" className="form-control" name="usuario" id="validationCustom01" required
                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'usuario es requerido'
                                    }
                                })
                            }

                        />
                        <div className="valid-feedback">
                            {errors?.usuario?.message}
                        </div>
                    </div>

                    <div className="col-md-4 mb-3">
                    <label >Documento</label>
                    <select className="custom-select" name="documento"  required
                            ref={
                                register({
                                    required: true
                                })
                            }>
                            <option ></option>
                            <option>Guia Despacho</option>
                            <option>Venta Web</option>
                            <option>Cotizacion</option>
                        </select>
                    </div>
                    <div className="col-md-4 mb-3">
                    <label >Nro Documento</label>
                        <input type="number" className="form-control" name="nro_documento"  required

                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'nro_documento es requerido'
                                    }
                                })
                            }
                            />
                    </div>
                </div>
                <div className="form-row">
                    <div className="col-md-6 mb-3">
                        <label > Ubicacion</label>
                        <select className="custom-select" name="ubicacion" required
                            ref={
                                register({
                                    required: true
                                })
                            }>
                            <option ></option>
                            <option>Sala De Listas</option>
                            <option>Facturacion</option>
                            <option>Ventas Web</option>
                        </select>
                        <div className="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                    <div className="col-md-6 mb-3">
                        <label > Rack</label>
                        <input type="text" className="form-control" name="rack"  required
                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'rack es requerido'
                                    }
                                })
                            }/>

                        <div className="invalid-feedback">
                            Please select a valid state.
                        </div>

                    </div>
                    </div>
                    <div className="form-row">
                    {/* text area observaciones cuadro grande XD */}
                    <div className="col-md-12 mb-3">
                        <label>Observacion</label>
                        <textarea className="form-control" name="observacion" placeholder="Observaciones" required
                            ref={
                                register({
                                    required: true ,minLength:2})
                            }> </textarea>
                        <div className="invalid-feedback">
                            Please provide a valid zip.
                        </div>
                    </div>
                </div>

                <button className="btn btn-primary" type="submit">Siguiente</button>
            </form>

        </Fragment>

    );
}
export default FormularioCaja;

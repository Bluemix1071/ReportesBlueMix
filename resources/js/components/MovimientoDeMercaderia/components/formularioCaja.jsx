import React, { Fragment, useState } from 'react';
import { useForm } from 'react-hook-form';

const FormularioCaja = (props) => {

    const { register, errors, handleSubmit } = useForm({

            defaultValues: props.Caja ? props.Caja : {}



    });



    const onSubmit = (data, e) => {

       // console.log(data);
        props.ocultarForm();
        props.EnviarCaja(data);



    }


    return (
        <Fragment>
            <form onSubmit={handleSubmit(onSubmit)} className="needs-validation" >
                <div className="form-row">
                    <div className="col-md-6 mb-3">
                        <label for="validationCustom01">usuario</label>
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
                    <div className="col-md-6 mb-3">
                        <label for="validationCustom02">descripcion</label>
                        <input type="text" className="form-control" name="descripcion"  required

                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'descripcion es requerido'
                                    }
                                })
                            }

                        />
                        <div className="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <div className="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom03"> Ubicacion</label>
                        <select className="custom-select" name="ubicacion"  required
                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'ubicacion es requerido'
                                    }
                                })
                            }>
                            <option  >...</option>
                            <option>Sala De Listas</option>
                            <option>Facturacion</option>
                        </select>
                        <div className="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                    <div className="col-md-3 mb-3">
                        <label for="validationCustom04"> Rack</label>
                        <select className="custom-select" name="rack" id="validationCustom04" required
                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'rack es requerido'
                                    }
                                })
                            }>
                            <option >Choose...</option>
                            <option>...</option>
                        </select>
                        <div className="invalid-feedback">
                            Please select a valid state.
                        </div>

                    </div>
                    <div className="col-md-3 mb-3">
                        <label for="validationCustom05">Referencia</label>
                        <input type="text" className="form-control" name="referencia" id="validationCustom05" required
                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'referencia es requerido'
                                    }
                                })
                            } />
                        <div className="invalid-feedback">
                            Please provide a valid zip.
                        </div>
                    </div>
                </div>

                <button className="btn btn-success" type="submit">enviar</button>
            </form>

        </Fragment>

    );
}
export default FormularioCaja;

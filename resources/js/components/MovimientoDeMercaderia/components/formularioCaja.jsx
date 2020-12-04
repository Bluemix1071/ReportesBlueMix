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
                    <div className="col-md-4 mb-3">
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

                    <div className="col-md-4 mb-3">
                    <label for="validationCustom02">Documento</label>
                    <select className="custom-select" name="documento"  required
                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'Documento es requerido'
                                    }
                                })
                            }>
                            <option >...</option>
                            <option>Factura</option>
                            <option>Guia Despacho</option>
                            <option>Venta Web</option>
                            <option>Cotizacion</option>
                        </select>
                    </div>
                    <div className="col-md-4 mb-3">
                    <label for="validationCustom02">Nro Documento</label>
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
                            <option>Ventas Web</option>
                        </select>
                        <div className="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                    <div className="col-md-6 mb-3">
                        <label for="validationCustom04"> Rack</label>
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
                        <label for="validationCustom05">Observacion</label>
                        <textarea class="form-control" name="observacion" placeholder="Observaciones" required
                            ref={
                                register({
                                    required: {
                                        value: true,
                                        message: 'observacion es requerido'
                                    }
                                })
                            }> </textarea>
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

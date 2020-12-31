import React, { useState } from 'react';
import { Fragment } from 'react';
import { useForm } from 'react-hook-form';
import Select from 'react-select';


const FormAlumno = (props) => {



    const { register, errors, handleSubmit } = useForm({
        defaultValues: props.Alumno ? props.Alumno : {}
    });

    const [ValorSelect, setValorSelect] = useState("");


    const onSubmit=(data,e)=>{

        Object.assign(data, {colegio:ValorSelect});

        //console.log(data,'form alumno');

        props.AddAlumno(data);



    }





    return (
        <Fragment>
        <form onSubmit={handleSubmit(onSubmit)} ref={props.FormAlumnoRef} className="needs-validation">

            <hr />
            <div className="form-row">
                <div className="form-group col-md-4">
                    <label htmlFor="inputEmail4">Nombres</label>
                    <input type="text" className="form-control" name="nombresAlumno" required
                      ref={
                        register({
                            required: {
                                value: false,

                            }
                        })
                    }  />
                </div>
                <div className="form-group col-md-4">
                    <label htmlFor="inputPassword4">Apellido Paterno</label>
                    <input type="text" className="form-control" name="apellidoPaternoAlumno" required
                     ref={
                        register({
                            required: {
                                value: false,

                            }
                        })
                    }  />
                </div>
                <div className="form-group col-md-4">
                    <label htmlFor="inputAddress">Apellido Materno</label>
                    <input type="text" className="form-control"  name="apellidoMaternoAlumno" required
                    ref={
                        register({
                            required: {
                                value: false,

                            }
                        })
                    }

                    />
                </div>
            </div>

            <div className="form-row">
                <div className="form-group col-md-6">
                    <label htmlFor="inputAddress2">Colegio</label>
                    < Select
                            className="basic-single"
                            classNamePrefix="select"
                            defaultValue={props.SelectColegios[0]}
                            isDisabled={false}
                            isLoading={false}
                            isClearable={true}
                            isRtl={false}
                            isSearchable={true}
                            name="color"
                            options={props.SelectColegios}
                            onChange={
                                (event) => {
                                    setValorSelect(event.value);
                                }
                            }
                        />
                </div>
                <div className="form-group col-md-6">
                    <label htmlFor="inputCity">curso</label>
                    <input type="text" className="form-control" name="curso" required
                     ref={
                        register({
                            required: {
                                value: false,

                            }
                        })
                    }


                    />
                </div>
            </div>

            <button className="btn btn-success float-right"  disabled={props.Apoderado.length< 0 } > GenerarCupon </button>



        </form>
        </Fragment>
     );
}

export default FormAlumno;

import React, { useEffect, useState } from 'react';
import Select from 'react-select';
import { getComunas } from '../services/getComunas';
import PlacesAutoComplete, { geocodeByAddress, getLatLng } from 'react-places-autocomplete';
import { Fragment } from 'react';
import { useForm } from 'react-hook-form';


const FormApoderado = (props) => {


    // const [address, setaddress] = useState("")

    // const handleSelect = async value =>{};

    const { register, errors, handleSubmit } = useForm({
        defaultValues: props.Apoderado ? props.Apoderado : {}
    });

    const [ValorSelect, setValorSelect] = useState("");




    const onSubmit = (data, e) => {


        Object.assign(data, { comuna: ValorSelect });
        console.log(data)
        props.AddApoderado(data);
        props.stepperr.next()

    }





    return (
        <Fragment>

            {/* <PlacesAutoComplete
                value={address}
                onChange={setaddress}
                onSelect={handleSelect}>


            {({getInputProps, suggestions, getSuggestionItemProps, loading})=>(
            <div>


                <input {...getInputProps({placeholder:"direccion"})}/>

                <div>
                    {loading ? <div> ... cargando </div>:null}

                    <div>
                        {suggestions.map((suggestion)=>{

                             <div> {suggestion.description}</div>

                        })}
                    </div>
                </div>
            </div>

            )}



            </PlacesAutoComplete> */}

            <form onSubmit={handleSubmit(onSubmit)} ref={props.FormApoderadoRef} className="needs-validation">



                <hr />
                <div className="form-row">
                    <div className="form-group col-md-4">
                        <label >Nombres</label>
                        <input type="text" className="form-control" name="nombres" required
                            ref={
                                register({
                                    required: {
                                        value: false,

                                    }
                                })
                            }



                        />
                    </div>
                    <div className="form-group col-md-4">
                        <label >Apellido Paterno</label>
                        <input type="text" className="form-control" name="apellidoPaterno" required
                            ref={
                                register({
                                    required: {
                                        value: false,

                                    }
                                })
                            }


                        />
                    </div>
                    <div className="form-group col-md-4">
                        <label htmlFor="inputAddress">Apellido Materno</label>
                        <input type="text" className="form-control" name="apellidoMaterno" required
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
                        <label htmlFor="inputAddress2">Correo</label>
                        <input type="email" className="form-control" name="correo" required
                            ref={
                                register({
                                    required: {
                                        value: false,

                                    }
                                })
                            }

                        />
                    </div>
                    <div className="form-group col-md-6">
                        <label htmlFor="inputCity">Telefono</label>
                        <input type="number" className="form-control" name="telefono" required
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
                    <div className="form-group col-md-4">
                        <label htmlFor="inputState">Comuna</label>

                        {props.ValidaComunas ? (
                            <input type="text" className="form-control" name="comuna" required
                            onChange={
                                (event) => {
                                    setValorSelect(event.target.value);
                                }
                            }
                                ref={
                                    register({
                                        required: {
                                            value: false,

                                        }
                                    })
                                }

                            />

                        ) : (
                                < Select required
                                    className="basic-single"
                                    classNamePrefix="select"
                                    defaultValue={props.SelectComunas[0]}
                                    isDisabled={false}
                                    isLoading={false}
                                    isClearable={true}
                                    isRtl={false}
                                    isSearchable={true}
                                    name="comuna"
                                    options={props.SelectComunas}
                                    onChange={
                                        (event) => {
                                            setValorSelect(event.value);
                                        }
                                    }
                                />


                            )

                        }












                    </div>
                    <div className="form-group col-md-8">
                        <label htmlFor="inputZip">Direccion</label>
                        <input type="text" className="form-control" name="direccion" required

                            ref={
                                register({
                                    required: {
                                        value: false,

                                    }
                                })
                            } />
                    </div>

                </div>
                <div className="row">
                    <div className="col-md-12">

                        <button type="submit" className="btn btn-primary" disabled={ValorSelect.length == ""} > siguientee</button>


                    </div>
                </div>


            </form>
        </Fragment>
    );
}

export default FormApoderado;

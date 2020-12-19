import React, { useEffect, useState } from 'react';
import Select from 'react-select';
import { getComunas } from '../services/getComunas';
import PlacesAutoComplete, { geocodeByAddress, getLatLng } from 'react-places-autocomplete';
import { Fragment } from 'react';


const FormApoderado = (props) => {


const [address, setaddress] = useState("")

const handleSelect = async value =>{};
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

            <form>



                <hr />
                <div className="form-row">
                    <div className="form-group col-md-4">
                        <label >Nombres</label>
                        <input type="text" className="form-control" />
                    </div>
                    <div className="form-group col-md-4">
                        <label >Apellido Paterno</label>
                        <input type="text" className="form-control" />
                    </div>
                    <div className="form-group col-md-4">
                        <label htmlFor="inputAddress">Apellido Materno</label>
                        <input type="text" className="form-control" />
                    </div>
                </div>

                <div className="form-row">
                    <div className="form-group col-md-6">
                        <label htmlFor="inputAddress2">Correo</label>
                        <input type="email" className="form-control" />
                    </div>
                    <div className="form-group col-md-6">
                        <label htmlFor="inputCity">Telefono</label>
                        <input type="number" className="form-control" />
                    </div>
                </div>

                <div className="form-row">
                    <div className="form-group col-md-4">
                        <label htmlFor="inputState">Comuna</label>

                        < Select
                            className="basic-single"
                            classNamePrefix="select"
                            defaultValue={props.SelectComunas[0]}
                            isDisabled={false}
                            isLoading={false}
                            isClearable={true}
                            isRtl={false}
                            isSearchable={true}
                            name="color"
                            options={props.SelectComunas}
                        />



                    </div>
                    <div className="form-group col-md-8">
                        <label htmlFor="inputZip">Direccion</label>
                        <input type="text" className="form-control" id="inputZip" />
                    </div>

                </div>


            </form>
        </Fragment>
    );
}

export default FormApoderado;

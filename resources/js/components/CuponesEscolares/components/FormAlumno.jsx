import React from 'react';
import { Fragment } from 'react';


const FormAlumno = () => {
    return (
        <Fragment>
        <form>

            <hr />
            <div className="form-row">
                <div className="form-group col-md-4">
                    <label htmlFor="inputEmail4">Nombres</label>
                    <input type="text" className="form-control"  />
                </div>
                <div className="form-group col-md-4">
                    <label htmlFor="inputPassword4">Apellido Paterno</label>
                    <input type="text" className="form-control"  />
                </div>
                <div className="form-group col-md-4">
                    <label htmlFor="inputAddress">Apellido Materno</label>
                    <input type="text" className="form-control"   />
                </div>
            </div>

            <div className="form-row">
                <div className="form-group col-md-6">
                    <label htmlFor="inputAddress2">Colegio</label>
                    <input type="email" className="form-control"   />
                </div>
                <div className="form-group col-md-6">
                    <label htmlFor="inputCity">curso</label>
                    <input type="number" className="form-control"/>
                </div>
            </div>




        </form>
        </Fragment>
     );
}

export default FormAlumno;

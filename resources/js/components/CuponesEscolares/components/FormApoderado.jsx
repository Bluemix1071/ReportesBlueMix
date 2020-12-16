import React from 'react';

const FormApoderado = () => {
    return (
        <form>

            <hr />
            <div className="form-row">
                <div className="form-group col-md-4">
                    <label htmlFor="inputEmail4">Nombres</label>
                    <input type="email" className="form-control" id="inputEmail4" />
                </div>
                <div className="form-group col-md-4">
                    <label htmlFor="inputPassword4">Apellido Paterno</label>
                    <input type="password" className="form-control" id="inputPassword4" />
                </div>
                <div className="form-group col-md-4">
                    <label htmlFor="inputAddress">Apellido Materno</label>
                    <input type="text" className="form-control" id="inputAddress" placeholder="1234 Main St" />
                </div>
            </div>

            <div className="form-row">
                <div className="form-group col-md-6">
                    <label htmlFor="inputAddress2">Correo</label>
                    <input type="email" className="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" />
                </div>
                <div className="form-group col-md-6">
                    <label htmlFor="inputCity">Telefono</label>
                    <input type="number" className="form-control" id="inputCity" />
                </div>
            </div>

            <div className="form-row">
                <div className="form-group col-md-4">
                    <label htmlFor="inputState">Comuna</label>
                    <select id="inputState" className="form-control">
                        <option defaultValue >select...</option>
                        <option>...</option>
                    </select>
                </div>
                <div className="form-group col-md-8">
                    <label htmlFor="inputZip">Direccion</label>
                    <input type="text" className="form-control" id="inputZip" />
                </div>

            </div>


        </form>

    );
}

export default FormApoderado;

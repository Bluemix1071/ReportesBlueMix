import React, { Fragment } from 'react';


const TablaListadoCajas = (props) => {
    return (
        <Fragment>
            <table className="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Codigo barra</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <th scope="row">1</th>
                     <th>2</th>
                     <th>2</th>
                    <th>2</th>
                </tbody>
            </table>
        </Fragment>
      );
}

export default TablaListadoCajas;

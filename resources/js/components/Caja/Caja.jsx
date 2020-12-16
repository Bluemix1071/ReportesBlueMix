import React, { Fragment, useEffect, useState } from 'react';
import { useParams, useRouteMatch } from 'react-router-dom';

import { getCajaService } from './services/getCajaServices';

const Caja = () => {
    let { id } = useParams();
    const [Caja, setCaja] = useState([]);
    const [Productos, setProductos] = useState([]);



    useEffect(() => {
        getCaja(id);


    }, []);

    const getCaja = async (id) => {

        const caja = await getCajaService(id);

        console.log(caja.data.productos_en_trancito);
        setCaja(caja.data);
        setProductos(caja.data.productos_en_trancito);

    }


    return (
        <Fragment>
        <ul>
            {Caja.id}
        </ul>
        {
             Productos.map(producto =>(
                <li key={producto.id}>
                    {producto.id} - {producto.codigo_producto}- {producto.descripcion} - {producto.codigo_barra}  -{producto.cantidad}
                </li>
             ))
        }

        <ul>

        </ul>
        </Fragment>
    );
}

export default Caja;

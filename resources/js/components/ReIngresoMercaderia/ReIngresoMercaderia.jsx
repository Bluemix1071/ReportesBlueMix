import React, { Fragment, useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import { Provider, useDispatch, useSelector } from 'react-redux';
import TablaMercaderia from '../MovimientoDeMercaderia/components/tablaMercaderia';
import TablaProductosReIngreso from './components/TablaProductos';
import {fetchMercaderia, fetchMercaderiaReset} from '../redux/actions/buscadorMercaderia';
const ReIngresoMercaderia = () => {
    const dispatch = useDispatch();
    const { register, errors, handleSubmit } = useForm();
    const [BuscadorMerc, setBuscadorMerc] = useState("")

    const [Productos, setProductos] = useState([]);
    const [Caja, setCaja] = useState([]);

    const BuscadorMercaderia= useSelector(state => state.BuscadorMercaderia);
    const onSubmit = (data, e) => {

        dispatch(fetchMercaderia(BuscadorMerc))
        console.log( BuscadorMercaderia);
    }

    useEffect(() => {

        if (BuscadorMercaderia.FETCH_MERCADERIA_SUCCESS) {
             console.log( BuscadorMercaderia.mercaderia)
        }

    }, [BuscadorMercaderia.FETCH_MERCADERIA_SUCCESS]);


    // useEffect(() => {
    //     return ()=>{
    //         dispatch(fetchMercaderiaReset());
    //     }
    // },[]);





    return (
        <Fragment>
            <div className="container my-4">

                <div className="row">
                    <div className="col md-6">
                        <h1>ReIngreso De Mercaderia</h1>
                    </div>
                    <div className="col md-6">

                    </div>
                </div>

                <div className="row">
                    <div className="col-md-12">
                        {/* Buscador */}
                        <form onSubmit={handleSubmit(onSubmit)}>

                            <div className="input-group flex-nowrap mt-5">

                                <div className="input-group-prepend">
                                    <span class="input-group-text" id="addon-wrapping">Buscar</span>
                                </div>
                                <input type="number" className="form-control" name="caja" autoFocus placeholder="Mercaderia" value={BuscadorMerc}
                                    onChange={
                                        (event) => {
                                            setBuscadorMerc(event.target.value);
                                        }
                                    }

                                />
                            </div>

                        </form>

                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        {/* Tabla De Productos */}

                        <TablaProductosReIngreso
                        Productos={Productos}/>
                    </div>
                </div>

            </div>
        </Fragment>
    );
}

export default ReIngresoMercaderia;

import React, { Fragment, useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import { Provider, useDispatch, useSelector } from 'react-redux';
import { fetchMercaderia } from '../redux/actions/buscadorMercaderia';
import { getMercaderiaService } from './services/getMercaderiaServices';
import { ReIngresoMercaderiaService } from './services/ReIngresoMercaderiaService';


//componentes
import TablaProductosReIngreso from './components/TablaProductos';
import ModalReIngreso from './components/ModalReIngreso';


const ReIngresoMercaderia = () => {


    const dispatch = useDispatch();
    const { register, errors, handleSubmit } = useForm();
    const [BuscadorMerc, setBuscadorMerc] = useState("");
    const [ModalReIngresoShow, setModalReIngreso] = useState(false);
    const [ErrorBuscador, setErrorBuscador] = useState(false);
    const [ErrorReIngreso, setErrorReIngreso] = useState(false);
    const [SuccessMeraderia, setSuccessMeraderia] = useState(false);
    const [Productos, setProductos] = useState([]);
    const [Caja, setCaja] = useState([]);

    const BuscadorMercaderia = useSelector(state => state.BuscadorMercaderia);
    const onSubmit = (data, e) => {

        //dispatch(fetchMercaderia(BuscadorMerc))
        const caja = getMercaderiaService(BuscadorMerc)
            .then(function (response) {
                // handle success
                setErrorBuscador(false);
                setSuccessMeraderia(false);
                setErrorReIngreso(false);
                console.log(response.data.caja.productos_en_trancito);
                setProductos(response.data.caja.productos_en_trancito);
                setCaja(response.data.caja);
                setBuscadorMerc('');
            })
            .catch(function (error) {
                setSuccessMeraderia(false);
                setErrorReIngreso(false);
                setErrorBuscador(true);
                setProductos([]);
                // console.log(error);
            })

        //console.log(caja);

    }


    const mostarModal = () => {

        setModalReIngreso(true);

    }
    const ocultarModal = () => {

        setModalReIngreso(false);

    }

    const ReIngresarMercaderia=(id)=>{

        const ReIngreso = ReIngresoMercaderiaService(id)
        .then(function (response) {
            // handle success
            setErrorReIngreso(false);
            console.log(response)
            ocultarModal();
            setBuscadorMerc('');
            setSuccessMeraderia(true);
            setProductos([]);
        })
        .catch(function (error) {
            setErrorReIngreso(true);
            console.log(error);
            ocultarModal();
            setProductos([]);
            // console.log(error);
        })
    }


    return (

        <Fragment>
            <div className="container my-4">

                <div className="row">
                    <div className="col md-6">
                        <h1>ReIngreso De Mercaderia</h1>
                    </div>
                    <div className="col md-6">
                        {ErrorBuscador ? (
                            <div className="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>la mercaderia que buscas no se encuentra  :'C </strong>
                            </div>

                        ) : (
                                <h1></h1>
                            )


                        }
                        {ErrorReIngreso ? (
                                <div className="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>La Mercaderia ya fue ReIngresada </strong>
                                </div>

                            ) : (
                                    <h1></h1>
                                )


                            }

                            {SuccessMeraderia ? (
                                <div className="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>La Mercaderia Fue ReIngresa Correctamente</strong>
                                </div>

                            ) : (
                                    <h1></h1>
                                )


                            }

                    </div>
                </div>

                <div className="row">
                    <div className="col-md-12">
                        {/* Buscador */}
                        <form onSubmit={handleSubmit(onSubmit)}>

                            <div className="input-group flex-nowrap mt-5">

                                <div className="input-group-prepend">
                                    <span className="input-group-text" id="addon-wrapping">Buscar</span>
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
                            Productos={Productos} />

                    </div>


                </div>
                <div className="float-right">
                    <button className="btn btn-success" disabled={Productos.length < 1} onClick={()=>mostarModal()}> ReIngresar</button>


                </div>


                    <ModalReIngreso

                        ModalReIngreso={ModalReIngresoShow}
                        mostarModal={mostarModal}
                        ocultarModal={ocultarModal}
                        caja={Caja}
                        ReIngresarMercaderia={ReIngresarMercaderia}

                    />


            </div>
        </Fragment>
    );
}

export default ReIngresoMercaderia;

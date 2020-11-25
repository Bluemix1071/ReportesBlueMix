import React, { Fragment, useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { getProductoService } from './services/getProductoServices';

  import {EnvioMercaderia} from './services/EnvioMercaderiaTrancito';
import { Provider, useDispatch, useSelector } from 'react-redux';
import { useForm } from 'react-hook-form';
import fetchProduct from '../redux/actions/buscadorProductos';
// components
import ModalCantidad from './components/modalCantidad';
import TablaMercaderia from './components/tablaMercaderia';
import FormularioCaja from './components/formularioCaja';


const MovimientoDeMercaderia = () => {

    const dispatch = useDispatch();
    const { register, errors, handleSubmit } = useForm();
    const [show, setShow] = useState(false);
    const [showFormCaja, setShowFormCaja] = useState(true);
    const [buscadorProducto, setBuscadorProducto] = useState("");
    const [Productos, setProductos] = useState([]);
    const Buscador = useSelector(state => state.Buscador)
    const [Caja, setCaja] = useState([])


    const onSubmit = (data, e) => {

        if (buscadorProducto.length == 7) {

            dispatch(fetchProduct({ codigo: buscadorProducto }));
        }
        else if (buscadorProducto.length == 13) {
            dispatch(fetchProduct({ barra: buscadorProducto }));
        }
        else {
            dispatch(fetchProduct(buscadorProducto));
        }



        setBuscadorProducto('');
    }

    useEffect(() => {
        if (Buscador.FETCH_PRODUCT_SUCCESS) {
            mostarModal();
        }
    }, [Buscador.FETCH_PRODUCT_SUCCESS]);

    const updateProduct = (codi, cant) => {


        setProductos(Productos.map(Product => (Product.codigo === codi ? Product.cantidad = parseInt(cant) : Product)))

    }
    const ingresoProducto = async (product) => {

        if (Buscador.FETCH_PRODUCT_SUCCESS) {

            const result = Productos.find(p => p.codigo === product.codigo);

            if (result !== undefined) {

                setProductos(Productos.filter(Productos => Productos.codigo !== result.codigo))
                const newResult = result.cantidad = parseInt(result.cantidad) + parseInt(product.cantidad);
                // console.log( "result :"+ result.cantidad, "cantidad:"+product.cantidad);
                setProductos([...Productos, newResult])
                setProductos(Productos.filter(Productos => Productos.codigo !== undefined))

            } else {

                setProductos([...Productos, product]);
            }
        }
    }

    const mostarModal = () => {

        setShow(true);

    }
    const ocultarModal = () => {

        setShow(false);

    }


    const EnviarProductos = () => {
        console.log(JSON.stringify({caja:Caja}))
        console.log(  JSON.stringify( {productos:Productos}));

        const productos = {productos:JSON.stringify(Productos)}
        const caja ={caja:JSON.stringify(Caja)}


        const result = EnvioMercaderia( {productos,caja} );

        console.log(result);
    }

    const EliminarProducto = (codigo) => {
        // console.log(codigo)
        setProductos(Productos.filter(Productos => Productos.codigo !== codigo))
    }


    const mostrarForm = () => {
        setShowFormCaja(true);

    }
    const ocultarForm = () => {
        setShowFormCaja(false);

    }

    const EnviarCaja = (caja) => {

        setCaja(caja);

    }
    return (
        <Fragment>

            <div className="container my-4">
                <div className="col-md-6">
                    <h1 className="display-6">Movimiento De Mercaderia</h1>

                </div>



                <div className="col md-6">
                    {Buscador.FETCH_PRODUCT_FAILURE &&

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{Buscador.error}</strong>
                        </div>
                    }
                </div>
                <hr />
                <div className="row ">
                    <div className="col-md-12 mb-2">

                        {showFormCaja ? (

                            <FormularioCaja
                                ocultarForm={ocultarForm}
                                EnviarCaja={EnviarCaja}
                                Caja={Caja}


                            />

                        ) : (
                                <button className="btn btn-primary" onClick={mostrarForm}> Editar Campos </button>

                            )


                        }
                        <hr />
                    </div>
                </div>


                <form onSubmit={handleSubmit(onSubmit)}>

                    <div className="input-group flex-nowrap mt-5">

                        <div className="input-group-prepend">
                            <span class="input-group-text" id="addon-wrapping">Buscar</span>
                        </div>
                        <input type="text" className="form-control" name="barra" autoFocus placeholder="Productos" value={buscadorProducto}
                            onChange={
                                (event) => {
                                    setBuscadorProducto(event.target.value);
                                }
                            }

                        />
                    </div>

                </form>
                {

                    show &&
                    <ModalCantidad

                        show={show}
                        mostarModal={mostarModal}
                        ocultarModal={ocultarModal}
                        ingresoProducto={ingresoProducto}


                    />
                }

                <hr />
                <section className="content">
                    <div className="card">
                        <div className="card-header">
                            <h3 className="card-title mb-4">Articulos</h3>


                            <TablaMercaderia
                                Productos={Productos}
                                EliminarProducto={EliminarProducto}
                                updateProduct={updateProduct}

                            />
                        </div>
                        <div class="card-body">


                            <div className="row">
                                <div className="col-md-9">

                                </div>
                                <div className="col-md-3">

                                    <button className="btn btn-success" disabled={Productos.length < 1 || Caja.length <1}
                                        onClick={EnviarProductos}
                                    >
                                        Ingresar Productos
                                </button>

                                </div>

                            </div>
                        </div>

                    </div>
                </section>
            </div>

        </Fragment>
    );
};

export default MovimientoDeMercaderia;

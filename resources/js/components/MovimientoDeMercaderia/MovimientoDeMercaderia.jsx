import React, { Fragment, useEffect, useRef, useState } from 'react';
import { useParams } from 'react-router-dom';
import { getProductoService } from './services/getProductoServices';
import { EnvioMercaderia } from './services/EnvioMercaderiaTrancito';
import { Provider, useDispatch, useSelector } from 'react-redux';
import { useForm } from 'react-hook-form';
import { fetchReset } from '../redux/actions/buscadorProductos';
import { fetchProduct } from '../redux/actions/buscadorProductos';

// components
import ModalCantidad from './components/modalCantidad';
import TablaMercaderia from './components/tablaMercaderia';
import FormularioCaja from './components/formularioCaja';
import ModalConfirmarCaja from './components/ModalConfirmarCaja';

import ModalEditar from './components/ModalEditar'
// steppers
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bs-stepper/dist/css/bs-stepper.min.css';
import Stepper from 'bs-stepper'
import Step from '../stepper/components/step';

//import escpos from 'escpos';

const MovimientoDeMercaderia = () => {

    const dispatch = useDispatch();
    const { register, errors, handleSubmit } = useForm();
    const [show, setShow] = useState(false);
    const [showModalConfirm, setShowModalConfirm] = useState(false);
    const [showFormCaja, setShowFormCaja] = useState(true);

    // state editar producto
    const [EditProduct, setEditProduct] = useState(false);
    const [ProductoEditar, setProductoEditar] = useState({});

    const [ConfirmacionCaja, setConfirmacionCaja] = useState(false)
    const [buscadorProducto, setBuscadorProducto] = useState("");
    // estado de los produtos y caja
    const [Productos, setProductos] = useState([]);
    const [Caja, setCaja] = useState([]);
    // fin estado productos y cajs
    const Buscador = useSelector(state => state.Buscador);

    //stepper
    const [stepperr, setstepperr] = useState();
    useEffect(() => {

        setstepperr(new Stepper(document.querySelector('#stepper1'), {
            linear: false,
            animation: true
        }))

    }, [])


    const steps = [
        { target: '#item1', number: 1, text: 'Ingresar Caja' },
        { target: '#item2', number: 2, text: 'Ingreso Poductos' },
    ]


    //fin stepper



    const onSubmit = (data, e) => {
        setConfirmacionCaja(false);
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

    //reinicio formulario
    const myForm = useRef(null);

    useEffect(() => {
        console.log(myForm);

    }, []);
    // fin reinicio formularios


    useEffect(() => {
        if (Buscador.FETCH_PRODUCT_SUCCESS) {

            setConfirmacionCaja(false);
            mostarModal();

        }

    }, [Buscador.FETCH_PRODUCT_SUCCESS]);

    useEffect(() => {
        return ()=>{
            dispatch(fetchReset());
        }
    },[]);




    const ingresoProducto = async (product) => {

        if (Buscador.FETCH_PRODUCT_SUCCESS) {

            const result = Productos.find(p => p.codigo_producto === product.codigo_producto);

            if (result !== undefined) {

                setProductos(Productos.filter(Productos => Productos.codigo_producto !== result.codigo_producto))
                const newResult = result.cantidad = parseInt(result.cantidad) + parseInt(product.cantidad);
                // console.log( "result :"+ result.cantidad, "cantidad:"+product.cantidad);
                setProductos([...Productos, newResult])
                setProductos(Productos.filter(Productos => Productos.codigo_producto !== undefined))

            } else {

                setProductos([...Productos, product]);
            }
        }
    }

    const EditarProducto =  (product) => {

        const result = Productos.find(p => p.codigo_producto === product.codigo_producto);

        if (result !== undefined) {
            setProductos(Productos.map(Producto => (Producto.codigo_producto === product.codigo_producto ? product : Producto)))
            setEditProduct(false);
        } else {

        }
    }



    const mostarModal = () => {

        setShow(true);

    }
    const ocultarModal = () => {

        setShow(false);

    }

    const mostarModalConfirm = () => {

        setShowModalConfirm(true);

    }
    const ocultarModalConfirm = () => {

        setShowModalConfirm(false);

    }


    const EnviarProductos = (data) => {

        Object.assign(Caja, data);

        console.log(Caja);
        const productos = JSON.stringify(Productos);
        const caja = JSON.stringify(Caja);
        const result = EnvioMercaderia({ productos, caja })
            .then(resp => {

                setProductos([]);
                setCaja({});
                setBuscadorProducto('');
                dispatch(fetchReset());
                ocultarModalConfirm();
                setShowFormCaja(true);
                stepperr.previous();
                setConfirmacionCaja(true);
                myForm.current.reset();



            })
            .catch(error => {
                console.log(error);
            })


        console.log(result);
    }

    const EliminarProducto = (codigo) => {
        // console.log(codigo)
        setProductos(Productos.filter(Productos => Productos.codigo_producto !== codigo))
    }


    const mostrarForm = () => {
        setShowFormCaja(true);

    }
    const ocultarForm = () => {
        setShowFormCaja(false);

    }

    const EnviarCaja = (caja) => {
        console.log(caja);
        //setConfirmacionCaja(false);
        setCaja(caja);

    }

    const ResetForm = () => {

    }
    return (
        <Fragment>

            <div className="container my-4">
                {/* titulo */}
                <div className="col-md-6">
                    <h1 className="display-6">Movimiento De Mercaderia</h1>
                </div>


                {/* mostrar error en busqueda producto */}
                <div className="col md-6">
                    {Buscador.FETCH_PRODUCT_FAILURE &&

                        <div className="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{Buscador.error}</strong>
                        </div>
                    }

                    {ConfirmacionCaja? (
                        <div className="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>la mercaderia se ingreso correctamente </strong>
                    </div>

                    ):(
                        <h1></h1>
                    )


                    }
                </div>
                <hr />



                <div id="stepper1" className="bs-stepper">
                    <div className="bs-stepper-header">
                        <Step steps={steps} />
                    </div>
                    <div className="bs-stepper-content">

                            <div id="item1" className="content">

                                {/* formulario caja */}
                                <div className="row ">
                                    <div className="col-md-12 mb-2">



                                            <FormularioCaja
                                               // ocultarForm={ocultarForm}
                                                EnviarCaja={EnviarCaja}
                                                Caja={Caja}
                                                stepperr={stepperr}
                                                myForm={myForm}
                                            />


                                        <hr />
                                    </div>
                                </div>

                                {/* fin caja */}
                                {/* <button className="btn btn-primary" onClick={() => stepperr.next()}>Next</button> */}
                            </div>

                            <div id="item2" className="content">
                                {/* buscador */}
                                <form onSubmit={handleSubmit(onSubmit)}>

                                    <div className="input-group flex-nowrap mt-5">

                                        <div className="input-group-prepend">
                                            <span className="input-group-text" id="addon-wrapping">Buscar</span>
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

                                <ModalConfirmarCaja
                                    showModalConfirm={showModalConfirm}
                                    mostarModalConfirm={mostarModalConfirm}
                                    ocultarModalConfirm={ocultarModalConfirm}
                                    EnviarProductos={EnviarProductos}
                                />

                                <ModalEditar
                                EditProduct={EditProduct}
                                setEditProduct={setEditProduct}
                                ProductoEditar={ProductoEditar}
                                EditarProducto={EditarProducto}
                                />


                                <hr />
                                {/* tabla con prouductos */}



                                {/* <h3 className="card-title mb-4">Articulos</h3> */}

                                <TablaMercaderia
                                    Productos={Productos}
                                    EliminarProducto={EliminarProducto}
                                    setEditProduct={setEditProduct}
                                    setProductoEditar={setProductoEditar}

                                />





                                <button className="btn btn-primary mr-4" onClick={() => stepperr.previous()}>previus</button>
                                <button className="btn btn-success ml-4" disabled={Productos.length < 1 || Caja.length < 1}
                                    onClick={() => mostarModalConfirm()}
                                >
                                    Ingresar Productos </button>
                            </div>


                    </div>
                </div>

            </div>

        </Fragment>
    );
};

export default MovimientoDeMercaderia;

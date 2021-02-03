import React, { Fragment, useEffect, useRef } from 'react';
import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { useDispatch, useSelector } from 'react-redux';
import FormularioCaja from '../MovimientoDeMercaderia/components/formularioCaja';
import ModalCantidad from '../MovimientoDeMercaderia/components/modalCantidad';
import TablaMercaderia from '../MovimientoDeMercaderia/components/tablaMercaderia';
import fetchProduct, { fetchReset } from '../redux/actions/buscadorProductos';
import { getMercaderiaService } from './services/getMercaderiaServices';
import { EnvioMercaderiaModificada } from './services/EnvioMercaderiaModificada';
import Step from '../stepper/components/step';

//stepper
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bs-stepper/dist/css/bs-stepper.min.css';
import Stepper from 'bs-stepper'
import FormularioCajaModificacion from './components/FormularioCajaModificacion';
import ModalEditar from '../MovimientoDeMercaderia/components/ModalEditar';


const ModificarMercaderia = () => {
    const dispatch = useDispatch();
    const { register, errors, handleSubmit } = useForm();
    const [Productos, setProductos] = useState([]);
    const [Caja, setCaja] = useState([]);
    const [BuscadorMerc, setBuscadorMerc] = useState("");
    const [BucadorProducto, setBucadorProducto] = useState("");
    const Buscador = useSelector(state => state.Buscador);
    const [show, setShow] = useState(false);
    const [ocultarBusqueda, setocultarBusqueda] = useState(true);
    const [ConfirmacionCaja, setConfirmacionCaja] = useState(false);
    const [EstadoCaja, setEstadoCaja] = useState(false);
    const [EstadoBoton, setEstadoBoton] = useState(true);

    //editar producto
    const [EditProduct, setEditProduct] = useState(false);
    const [ProductoEditar, setProductoEditar] = useState({});


    //stepper
    const steps = [
        { target: '#item1', number: 1, text: 'Modificar Caja' },
        { target: '#item2', number: 2, text: 'Modificar Poductos' },
    ]
    const [stepperr, setstepperr] = useState();
    useEffect(() => {

        setstepperr(new Stepper(document.querySelector('#stepper1'), {
            linear: false,
            animation: true
        }))

    }, [])

    useEffect(() => {
        return () => {
            dispatch(fetchReset());
        }
    }, []);
    // fin stepper
    const onSubmitMercaderia = (data, e) => {
        setEstadoCaja(false);
        setConfirmacionCaja(false);
        // console.log(BuscadorMerc);
        // console.log(data);
        getMercaderiaService(BuscadorMerc)
            .then(function (response) {
                const data = response.data;
                console.log(data, 'data')
                if (data.caja.estado === 'ReIngresado') {

                    setEstadoCaja(true);


                } else {
                    //console.log(data.caja)
                    const product = data.caja.productos_en_trancito;
                    console.log(product);
                    product.map((pro, index) => {
                        delete pro.codigos_cajas_id
                        delete pro.created_at
                        delete pro.created_at
                        delete pro.id
                        delete pro.updated_at

                    });

                    setProductos(product);
                    // delete data.caja.productos_en_trancito;
                    console.log(data)
                    setCaja(data.caja);
                    // console.log(Caja);
                    setocultarBusqueda(false);
                }
            })
            .catch(function (error) {
                console.log(error);
            })

    }

    //reinicio formulario
    const myForm = useRef(null);
    const step1 = useRef(null);
    const step2 = useRef(null);
    useEffect(() => {
        console.log(step1.current.classList.value.includes('active'))
        console.log(step2.current.classList.value.includes('active'))
    }, [])
    // fin reinicio formularios



    const onSubmitProducto = () => {

        //setConfirmacionCaja(false);
        if (BucadorProducto.length == 7) {

            dispatch(fetchProduct({ codigo: BucadorProducto }));
        }
        else if (BucadorProducto.length == 13) {
            dispatch(fetchProduct({ barra: BucadorProducto }));
        }
        else {
            dispatch(fetchProduct(BucadorProducto));
        }



        setBucadorProducto('');

    }

    useEffect(() => {
        if (Buscador.FETCH_PRODUCT_SUCCESS) {

            //setConfirmacionCaja(false);
            mostarModal();

        }

    }, [Buscador.FETCH_PRODUCT_SUCCESS]);


    const mostarModal = () => {

        setShow(true);

    }
    const ocultarModal = () => {

        setShow(false);

    }

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

    const EliminarProducto = (codigo) => {
        console.log(codigo)
        console.log(Productos.filter(Producto => Producto.codigo_producto !== codigo))
        setProductos(Productos.filter(Producto => Producto.codigo_producto !== codigo))
    }

    const EditarProducto = (product) => {

        const result = Productos.find(p => p.codigo_producto === product.codigo_producto);

        if (result !== undefined) {
            setProductos(Productos.map(Producto => (Producto.codigo_producto === product.codigo_producto ? product : Producto)))
            setEditProduct(false);
        } else {

        }
    }

    const CancelarModificacion = () => {

        setocultarBusqueda(true);
        setProductos([]);
        setCaja([]);
        console.log(Caja.length)
        myForm.current.reset();
        stepperr.previous();

    }

    const EnviarCaja = (caja) => {
        console.log(caja);
        setCaja(caja);

    }
    const estadoBoton = (data) => {

        setEstadoBoton(data);

    }

    const ModificarMercaderia = () => {

        //console.log(Productos);
        //console.log(Caja.id);
        delete Caja.productos_en_trancito;
        const productos = JSON.stringify(Productos);
        const caja = JSON.stringify(Caja);
        const result = EnvioMercaderiaModificada(Caja.id, { productos, caja })
            .then(function (response) {

                //console.log(response);
                setProductos([]);
                setCaja([]);
                setocultarBusqueda(true);
                setBuscadorMerc("");
                stepperr.previous();
                setConfirmacionCaja(true);
                myForm.current.reset();

                // setocultarBusqueda(true);

            })
            .catch(function (error) {
                console.log(error);

            })


    }

    const deshabilitarBoton = () => {
        setEstadoBoton(true);
        stepperr.previous();

    }



    return (
        <Fragment>

            <div className="container my-4">
                <div className="row">

                    <div className="col-md-6">
                        <h1>Modificar Mercaderia</h1>
                    </div>

                    <div className="col-md-6">
                        {Buscador.FETCH_PRODUCT_FAILURE &&

                            <div className="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{Buscador.error}</strong>
                            </div>
                        }

                        {ConfirmacionCaja ? (
                            <div className="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>la mercaderia se Modifico Correctamente </strong>
                            </div>

                        ) : (
                                <h1></h1>
                            )


                        }
                        {
                            EstadoCaja ? (
                                <div className="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>la mercaderia ya fue ReIngresada </strong>
                                </div>
                            ) : (
                                    <h1></h1>
                                )




                        }
                    </div>

                </div>

                <div className="row mb-5">
                    <div className="col-md-12">

                        <div id="stepper1" className="bs-stepper">
                            <div className="bs-stepper-header" >
                                <Step steps={steps} />
                            </div>
                            <div className="bs-stepper-content">

                                <div id="item1" className="content" ref={step1}>

                                    {ocultarBusqueda &&
                                        <form onSubmit={handleSubmit(onSubmitMercaderia)} id="buscadorMercaderia">
                                            <div className="input-group flex-nowrap mt-5">

                                                <div className="input-group-prepend">
                                                    <span className="input-group-text" id="addon-wrapping">Buscar</span>
                                                </div>
                                                <input type="text" className="form-control" name="mercaderia" autoFocus placeholder="Mercaderia" value={BuscadorMerc}
                                                    onChange={
                                                        (event) => {
                                                            setBuscadorMerc(event.target.value);
                                                        }
                                                    }

                                                />
                                            </div>
                                        </form>
                                    }



                                    {Caja.id &&

                                        <FormularioCajaModificacion

                                            // ocultarForm={ocultarForm}
                                            EnviarCaja={EnviarCaja}
                                            Caja={Caja}
                                            stepperr={stepperr}
                                            myForm={myForm}
                                            estadoBoton={estadoBoton}
                                        />




                                    }

                                    {/* <button class="btn btn-primary mr-4" onClick={() => stepperr.next()}>next</button> */}
                                </div>
                                <div id="item2" className="content" ref={step2}>


                                    {!ocultarBusqueda &&

                                        <form onSubmit={handleSubmit(onSubmitProducto)} id="buscadorProducto">

                                            <div className="input-group flex-nowrap mt-5">

                                                <div className="input-group-prepend">
                                                    <span className="input-group-text" id="addon-wrapping">Buscar</span>
                                                </div>
                                                <input type="text" className="form-control" name="barra" autoFocus placeholder="Productos" value={BucadorProducto}
                                                    onChange={
                                                        (event) => {
                                                            setBucadorProducto(event.target.value);
                                                        }
                                                    }

                                                />
                                            </div>
                                        </form>
                                    }
                                    <ModalEditar
                                        EditProduct={EditProduct}
                                        setEditProduct={setEditProduct}
                                        ProductoEditar={ProductoEditar}
                                        EditarProducto={EditarProducto}
                                    />

                                    <TablaMercaderia
                                        Productos={Productos}
                                        setEditProduct={setEditProduct}
                                        EliminarProducto={EliminarProducto}
                                        setProductoEditar={setProductoEditar}


                                    />

                                    <ModalCantidad

                                        show={show}
                                        mostarModal={mostarModal}
                                        ocultarModal={ocultarModal}
                                        ingresoProducto={ingresoProducto}


                                    />

                                    <button className="btn btn-primary mr-4" onClick={() => deshabilitarBoton()}>previus</button>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>



                <div className="row">
                    <div className="col-md-12">
                        <div className="float-right">
                            <button className="btn btn-danger my-3 mx-3"
                                onClick={() => CancelarModificacion()}
                                disabled={ocultarBusqueda}
                            >Cancelar</button>

                            <button className="btn btn-success my-3 mx-3" disabled={EstadoBoton || Productos.length < 1 || Caja.length < 1}
                                onClick={() => ModificarMercaderia()}

                            > Modificar </button>
                        </div>


                    </div>
                </div>

            </div >


        </Fragment >
    );
}

export default ModificarMercaderia;

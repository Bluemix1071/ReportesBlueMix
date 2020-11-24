import React, { Fragment, useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { getProductoService } from './services/getProductoServices';
import { Provider, useDispatch, useSelector } from 'react-redux';
import { useForm } from 'react-hook-form';
import fetchProduct from '../redux/actions/buscadorProductos';
// components
import ModalCantidad from './components/modalCantidad';
import TablaMercaderia from './components/tablaMercaderia';


const MovimientoDeMercaderia = () => {

    const dispatch = useDispatch();
    const { register, errors, handleSubmit } = useForm();
    const [show, setShow] = useState(false);
    const [showEdit, setShowEdit] = useState(false);
    const [buscadorProducto, setBuscadorProducto] = useState("");



    const [Productos, setProductos] = useState([]);

    const onSubmit = (data, e) => {
        //e.preventDefault();

        dispatch(fetchProduct(buscadorProducto));
        setBuscadorProducto('');


            mostarModal();

    }

    const Buscador = useSelector(state => state.Buscador)

    // useEffect(() => {

    //     mostarModal();

    // }, [show])

    const updateProduct = (codi, cant) => {


        setProductos(Productos.map(Product => (Product.codigo === codi ? Product.cantidad = parseInt(cant) : Product)))

    }



    const ingresoProducto = async (product) => {

        if (Buscador.FETCH_PRODUCT_SUCCESS) {

            const result = Productos.find(p => p.codigo === product.codigo);

            if (result !== undefined) {

                setProductos(Productos.filter(Productos => Productos.codigo !== result.codigo))
                 const newResult = result.cantidad = parseInt(result.cantidad) + parseInt(product.cantidad);
                 console.log( "result :"+ result.cantidad, "cantidad:"+product.cantidad);
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





    const EliminarProducto = (codigo) => {
        // console.log(codigo)
        setProductos(Productos.filter(Productos => Productos.codigo !== codigo))
    }


    return (
        <Fragment>

            <div className="container my-4">
                <h1 className="display-6">Movimiento De Mercaderia</h1>
                <hr />

                <form onSubmit={handleSubmit(onSubmit)}>

                    <div class="input-group flex-nowrap">

                        <div class="input-group-prepend">
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
                            <div id="jsGrid1"></div>

                        </div>
                    </div>
                </section>
            </div>

        </Fragment>
    );
};

export default MovimientoDeMercaderia;

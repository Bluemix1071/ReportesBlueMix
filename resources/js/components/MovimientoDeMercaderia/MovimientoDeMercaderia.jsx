import React, { Fragment, useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { getProductoService } from './services/getProductoServices';
import { Provider, useDispatch, useSelector } from 'react-redux';
import { useForm } from 'react-hook-form';
import fetchProduct from '../redux/actions/buscadorProductos';
// components

import TablaMercaderia from './components/tablaMercaderia';


const MovimientoDeMercaderia = () => {

    const dispatch = useDispatch();
    const { register, errors, handleSubmit } = useForm();

    const [buscadorProducto, setBuscadorProducto] = useState("");

    const [Productos, setProductos] = useState([]);

    const onSubmit = (data, e) => {
        //e.preventDefault();

        dispatch(fetchProduct(buscadorProducto));
        setBuscadorProducto('');

    }

    const Buscador = useSelector(state => state.Buscador)

    useEffect(() => {

        ingresoProducto();

    }, [Buscador])


    const ingresoProducto = async () => {

        if (Buscador.FETCH_PRODUCT_SUCCESS) {
            const product = Buscador.producto[0].producto[0]
            Object.assign(product, { cantidad: 1 })

            const result = Productos.find(p => p.codigo === product.codigo);
            // console.log(result);
            if (result !== undefined) {
                setProductos(Productos.filter(Productos => Productos.codigo !== result.codigo))
                const newResult = result.cantidad = result.cantidad + 1;
                setProductos([...Productos, newResult])
                setProductos(Productos.filter(Productos => Productos.codigo !== undefined))
            } else {

                setProductos([...Productos, product]);
            }
        }


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
                        <input type="text" className="form-control" name="barra" placeholder="Productos" value={buscadorProducto}
                            onChange={
                                (event) => {
                                    setBuscadorProducto(event.target.value);
                                }
                            }

                        />
                    </div>
                </form>

                <hr />
                <section className="content">
                    <div className="card">
                        <div className="card-header">
                            <h3 className="card-title mb-4">Articulos</h3>


                            <TablaMercaderia
                                Productos={Productos}
                                EliminarProducto={EliminarProducto}
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

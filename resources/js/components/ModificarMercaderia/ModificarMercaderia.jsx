import React, { Fragment, useEffect } from 'react';
import { useState } from 'react';
import { useForm } from 'react-hook-form';
import TablaMercaderia from '../MovimientoDeMercaderia/components/tablaMercaderia';
import { getMercaderiaService } from './services/getMercaderiaServices';


const ModificarMercaderia = () => {
    const { register, errors, handleSubmit } = useForm();
    const [Productos, setProductos] = useState([]);
    const [Caja, setCaja] = useState([]);
    const [BuscadorMerc, setBuscadorMerc] = useState("");


    useEffect(() => {

    }, [])

    const onSubmit = (data, e) => {
       // console.log(BuscadorMerc);
       // console.log(data);
        const caja = getMercaderiaService(BuscadorMerc)
            .then(function (response) {
                // handle success
                //console.log(response.data.caja.productos_en_trancito);
                setProductos(response.data.caja.productos_en_trancito)
            })
            .catch(function (error) {
                console.log(error);
            })

    }

    const EliminarProducto = (codigo) => {
         console.log(codigo)
         console.log(Productos.filter(Producto => Producto.codigo !== codigo))
        setProductos(Productos.filter(Productos => Productos.codigo !== codigo))
    }

    return (
        <Fragment>

            <div className="container my-4">
                <div className="row">

                    <div className="col-md-6">
                        <h1>Modificar Mercaderia</h1>
                    </div>

                    <div className="col-md-6">

                    </div>

                </div>

                <div className="row mb-5">
                    <div className="col-md-12">

                        <form onSubmit={handleSubmit(onSubmit)}>
                            <div className="input-group flex-nowrap mt-5">

                                <div className="input-group-prepend">
                                    <span class="input-group-text" id="addon-wrapping">Buscar</span>
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
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        <TablaMercaderia
                            Productos={Productos}
                            EliminarProducto={EliminarProducto}


                        />
                    </div>
                </div>


            </div>









        </Fragment>
    );
}

export default ModificarMercaderia;

import React, { Fragment } from 'react';
import ReactDOM, { browserHistory } from 'react-dom';
import {
    BrowserRouter,
    Switch,
    Route,
    useHistory,
    useLocation,
    useParams,
    Redirect

} from "react-router-dom";
import Footer from './components/Footer/Footer';
import Nav from './components/Nav/Nav';

// import Caja from './components/Caja/Caja';

import MovimientoDeMercaderia from './components/MovimientoDeMercaderia/MovimientoDeMercaderia';
import Home from './components/Home/Home';
import { createBrowserHistory } from "history";
import { Provider } from 'react-redux';
import store from './components/redux/store';
import 'bootstrap/dist/css/bootstrap.min.css';

import ReIngresoMercaderia from './components/ReIngresoMercaderia/ReIngresoMercaderia';
import IngresoCupon from './components/CuponesEscolares/IngresarCupon';
import ModificarMercaderia from './components/ModificarMercaderia/ModificarMercaderia';
import ListadosDeCajas from './components/ListadosDeCajas/ListadosDeCajas';
require('./bootstrap');


if (document.getElementById('example')) {
    const history = createBrowserHistory();
    ReactDOM.render(

        <Fragment>
            <Provider store={store}>
                <BrowserRouter >
                    <div className="wrapper">
                        <Nav />
                        <div className="content-wrapper">
                            <section className="content">
                                <Switch>
                                    <Route path="/" component={Home} exact={true} />
                                    <Route path="/api/IngresarMercaderia" exact={true}> <MovimientoDeMercaderia /> </Route>
                                    <Route path="/api/ModificarMercaderia/" exact={true}> <ModificarMercaderia/> </Route>
                                    <Route path="/api/ReIngresoMercaderia" exact={true}> <ReIngresoMercaderia/> </Route>
                                    <Route path="/api/ListadosDeCajas" exact={true}> <ListadosDeCajas/> </Route>
                                    <Route path="/api/IngresoCupon" exact={true}> <IngresoCupon/> </Route>
                                    <Route path="*" />

                                </Switch>



                            </section>
                        </div>
                        <Footer />
                        <aside className="control-sidebar control-sidebar-dark"></aside>
                    </div>

                </BrowserRouter>
            </Provider>
        </Fragment>





        , document.getElementById('example'));
}

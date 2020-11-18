import React, { Fragment } from 'react';
import ReactDOM,{browserHistory} from 'react-dom';
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
import Caja from './components/Caja/Caja';
import MovimientoDeMercaderia from './components/MovimientoDeMercaderia';
import Home from './components/Home/Home';
import { createBrowserHistory } from "history";

require('./bootstrap');


if (document.getElementById('example')) {
    const history = createBrowserHistory();
    ReactDOM.render(


        <Fragment>
            <BrowserRouter >
                <div className="wrapper">
                    <Nav />
                    <div className="content-wrapper">
                        <section className="content">
                            <Switch>
                            <Route path="/"  component={Home} exact={true} />
                                <Route path="/api/IngresarMercaderia"  exact={true}> <MovimientoDeMercaderia /> </Route>
                                <Route path="/api/Caja/:id" exact={true}> <Caja /> </Route>
                                <Route path="*" />

                            </Switch>



                        </section>
                    </div>
                    <Footer />
                    <aside className="control-sidebar control-sidebar-dark"></aside>
                </div>

            </BrowserRouter>
        </Fragment>






        , document.getElementById('example'));
}

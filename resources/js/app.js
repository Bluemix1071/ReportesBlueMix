import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter as Router,
    Switch,
    Route,
    useHistory,
    useLocation,
    useParams
} from "react-router-dom";
import Footer from './components/Footer/Footer';
import Nav from './components/Nav/Nav';
import MovimientoDeMercaderia from './components/MovimientoDeMercaderia';
import Caja from './components/Caja/Caja';

require('./bootstrap');

if (document.getElementById('example')) {
    ReactDOM.render(


        <Fragment>
            <Router>
                <div className="wrapper">
                    <Nav />
                    <div className="content-wrapper">
                        <section className="content">
                            <Switch>
                                <Route path="/IngresarMercaderia" exact={true} component={MovimientoDeMercaderia} />
                                <Route path="/Caja/:id" exact={true} component={Caja} />
                                <Route path="*" />
                            </Switch>
                    </section>
                </div>
                <Footer />
                <aside className="control-sidebar control-sidebar-dark"></aside>
            </div>
            </Router>

        </Fragment>






        , document.getElementById('example'));
}

import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import Footer from './components/Footer';
import Nav from './components/Nav';
import MovimientoDeMercaderia from './components/MovimientoDeMercaderia';

require('./bootstrap');

if (document.getElementById('example')) {
    ReactDOM.render(


        <Fragment>

            <div className="wrapper">
                <Nav />
                <div className="content-wrapper">
                    <section className="content">
                        <MovimientoDeMercaderia/>
                    </section>
                </div>
                <Footer />
                <aside className="control-sidebar control-sidebar-dark"></aside>
            </div>

        </Fragment>






        , document.getElementById('example'));
}

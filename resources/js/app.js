import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';


require('./bootstrap');


import Ejemplo from './components/Ejemplo';
import Dashboard from './components/Dashboard/Dashboard';
//xd
if (document.getElementById('example')) {
    ReactDOM.render(
    <Fragment>

      <Dashboard>

      </Dashboard>
    </Fragment>






    , document.getElementById('example'));
}

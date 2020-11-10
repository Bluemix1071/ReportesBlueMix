import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';


require('./bootstrap');


import Ejemplo from './components/Ejemplo';

//xd
if (document.getElementById('example')) {
    ReactDOM.render(
    <Fragment>

      <Ejemplo/>
    </Fragment>






    , document.getElementById('example'));
}

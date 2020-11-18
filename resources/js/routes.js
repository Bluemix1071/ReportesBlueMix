
import React from 'react';

import Home from './components/Home/Home';
import MovimientoDeMercaderia from './components/MovimientoDeMercaderia';
import Caja from './components/Caja/Caja';

const routes = [
    {
      path: 'publicos/api',
      element: <Home />,
      children: [
        { path: 'IngresarMercaderia',   element: <MovimientoDeMercaderia /> },
        { path: 'Caja/:id',  element: <Caja /> },

      ]
    }
]
export default routes;

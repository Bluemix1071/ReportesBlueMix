import React from 'react';
import { Route, Switch, useRouteMatch } from 'react-router-dom';
import IngresoCupon from '../components/CuponesEscolares/IngresarCupon';
import Home from '../components/Home/Home';
import ModificarMercaderia from '../components/ModificarMercaderia/ModificarMercaderia';
import MovimientoDeMercaderia from '../components/MovimientoDeMercaderia/MovimientoDeMercaderia';
import ReIngresoMercaderia from '../components/ReIngresoMercaderia/ReIngresoMercaderia';
import { PrivateRoute } from './HelperRoutes';

const Routes = () => {
    const {path} = useRouteMatch();
    return (
        <Switch>
            <Route path={path} component={Home} exact={true} />
            <Route path="/api/IngresarMercaderia" exact={true}> <MovimientoDeMercaderia /> </Route>
            <Route path="/api/ModificarMercaderia/" exact={true}> <ModificarMercaderia /> </Route>
            <Route path="/api/ReIngresoMercaderia" exact={true}> <ReIngresoMercaderia /> </Route>
            <PrivateRoute path="/api/IngresoCupon" exact={true} component={IngresoCupon} />
            <Route path="*" />
        </Switch>

    );
}

export default Routes;

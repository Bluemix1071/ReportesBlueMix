import React, { Fragment, useState, useEffect } from "react";
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link,
    NavLink,
    useRouteMatch
} from "react-router-dom";

import AdminLTELogo from '../../../../public/assets/lte/dist/img/AdminLTELogo.png';
import { LoginService } from './services/AurhServices';


const Nav = () => {

    const [User, setUser] = useState();

    let { url } = useRouteMatch();
    useEffect(() => {
        getUser();
        console.log(url);
    }, []);


    const getUser = async () => {

        const user = await LoginService();
        console.log(user.data);

    }
    return (
        <Fragment>
            <nav className="main-header navbar navbar-expand navbar-white navbar-light">
                <ul className="navbar-nav">
                    <li className="nav-item">
                        <a className="nav-link" data-widget="pushmenu" href="#">
                            <i className="fas fa-bars"></i>
                        </a>
                    </li>
                    <li className="nav-item d-none d-sm-inline-block">
                        <a href="" className="nav-link">
                            Menu Principal
                        </a>
                    </li>
                    <li className="nav-item d-none d-sm-inline-block">
                        <a href="" className="nav-link">
                            Información
                        </a>
                    </li>
                </ul>

                <ul className="navbar-nav ml-auto">
                    <li className="nav-item dropdown">
                        <a className="nav-link" data-toggle="dropdown" href="#">
                            <i className="far fa-comments"></i>
                            <span className="badge badge-danger navbar-badge">
                                0
                            </span>
                        </a>
                        <div className="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a
                                href=""
                                className="dropdown-item"
                                data-toggle="modal"
                                data-target="#mimodalejemplo5"
                            >
                                <div className="media">
                                    {/* <img
                                        src=""
                                        alt="User Avatar"
                                        className="img-size-50 mr-3 img-circle"
                                    /> */}

                                    <div className="media-body">
                                        <h3 className="dropdown-item-title">
                                            <span className="float-right text-sm text-danger">
                                                <i className="fas fa-star"></i>
                                            </span>
                                        </h3>
                                        <p className="text-sm">hol</p>
                                        <p className="text-sm text-muted">
                                            <i className="far fa-clock mr-1"></i>
                                            Fecha:
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div className="dropdown-divider"></div>
                            <a href="#" className="dropdown-item dropdown-footer">
                                Ver todos los mensajes
                            </a>
                        </div>
                    </li>
                    <li className="nav-item dropdown">
                        <a className="nav-link" data-toggle="dropdown" href="#">
                            <i className="far fa-bell"></i>
                            <span className="badge badge-warning navbar-badge">
                                15
                            </span>
                        </a>
                        <div className="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span className="dropdown-item dropdown-header">
                                15 Notificaciones
                            </span>
                            <div className="dropdown-divider"></div>
                            <a href="#" className="dropdown-item">
                                <i className="fas fa-envelope mr-2"></i> 4 nuevos
                                mensajes
                                <span className="float-right text-muted text-sm">
                                    3 minutos
                                </span>
                            </a>
                            <div className="dropdown-divider"></div>
                            <a href="#" className="dropdown-item">
                                <i className="fas fa-users mr-2"></i> 8 peticiones
                                de amistad
                                <span className="float-right text-muted text-sm">
                                    12 horas
                                </span>
                            </a>
                            <div className="dropdown-divider"></div>
                            <a href="#" className="dropdown-item">
                                <i className="fas fa-file mr-2"></i> 3 nuevos
                                reportes
                                <span className="float-right text-muted text-sm">
                                    2 dias
                                </span>
                            </a>
                            <div className="dropdown-divider"></div>
                            <a href="#" className="dropdown-item dropdown-footer">
                                Ver todas las notificaciones
                            </a>
                        </div>
                    </li>
                    <li className="nav-item">
                        <a href="" className="nav-link">
                            <i className="fas fa-sign-out-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <aside className="main-sidebar sidebar-dark-primary elevation-4">
                <a href="" className="brand-link">
                    {/* <img
                        src=""
                        alt="AdminLTE Logo"
                        className="brand-image img-circle elevation-3"
                        style="opacity: .8"
                    /> */}

                    <img src={AdminLTELogo}
                        alt="AdminLTE Logo"
                        className="brand-image img-circle elevation-3"
                    />

                    <span className="brand-text font-weight-light">Bluemix</span>
                </a>

                <nav className="mt-2">
                    <ul
                        className="nav nav-pills nav-sidebar flex-column"
                        data-widget="treeview"
                        role="menu"
                        data-accordion="false"
                    >
                        <li className="nav-item has-treeview">
                            <a href="#" className="nav-link">
                                <i className="nav-icon fas fa-users"></i>
                                <p>
                                    Productos En Trancito
                                    <i className="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul className="nav nav-treeview">
                                <li className="nav-item">
                                    <NavLink to={`${url}api/IngresarMercaderia`} className="nav-link ">
                                        <i className="far fa-circle nav-icon"></i>
                                        <p>Ingresar </p>
                                    </NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink to={`${url}api/Caja`} className="nav-link ">
                                        <i className="far fa-circle nav-icon"></i>
                                        <p>Mostrar</p>
                                    </NavLink>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </aside>
        </Fragment>
    );
};

export default Nav;

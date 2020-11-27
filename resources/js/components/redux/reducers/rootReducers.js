import {combineReducers} from 'redux';
import Buscador from './buscadorReducer';
import BuscadorMercaderia from './BuscadorMercaderiaReducer';

const rootReducers = combineReducers({
    Buscador,BuscadorMercaderia,
});

export default rootReducers;

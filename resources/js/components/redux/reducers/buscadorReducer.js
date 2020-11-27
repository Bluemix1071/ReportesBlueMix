
import { FETCH_PRODUCT_FAILURE, FETCH_PRODUCT_REQUEST, FETCH_PRODUCT_SUCCESS, FETCH_RESET } from '../actions/buscadorProductos';


const inicial = {
    loading: false,
    producto: [],
    error: ''
}


const Buscador = (state = inicial, action) => {

    switch (action.type) {
        case FETCH_PRODUCT_REQUEST:

            return {
                ...state,
                loading: true,
                error: '',
                FETCH_PRODUCT_SUCCESS: false
            }

        case FETCH_PRODUCT_SUCCESS:
            return {
                loading: false,
                producto: action.payload,
                error: '',
                FETCH_PRODUCT_SUCCESS: true
            }

        case FETCH_PRODUCT_FAILURE:
            return {
                loading: false,
                producto: [],
                error: action.payload,
                FETCH_PRODUCT_SUCCESS: false,
                FETCH_PRODUCT_FAILURE: true
            }

        case FETCH_RESET:
            return {
                loading: false,
                producto: [],

            }




        default: return state;
    }
}

export default Buscador;

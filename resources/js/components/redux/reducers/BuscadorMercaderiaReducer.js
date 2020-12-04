import { FETCH_MERCADERIA_REQUEST, FETCH_MERCADERIA_SUCCESS, FETCH_MERCADERIA_FAILURE, FETCH_MERCADERIA_RESET } from '../actions/buscadorMercaderia';


const inicial = {
    loading: false,
    mercaderia: [],
    error: ''
}

const BuscadorMercaderia = (state = inicial, action) => {

    switch (action.type) {

        case FETCH_MERCADERIA_REQUEST:
            return {
                ...state,
                loading: true,
                error: '',
                FETCH_MERCADERIA_SUCCESS: false
            }

        case FETCH_MERCADERIA_SUCCESS:
            return {
                loading: false,
                mercaderia: action.payload,
                FETCH_MERCADERIA_SUCCESS: false
            }
        case FETCH_MERCADERIA_FAILURE:
            return {
                loading: false,
                mercaderia: [],
                error: action.payload,
                FETCH_MERCADERIA_SUCCESS: false,
                FETCH_MERCADERIA_FAILURE: true
            }

        case FETCH_MERCADERIA_RESET:
            return {
                loading: false,
                mercaderia: [],

            }

            default: return state;
    }


}
export default BuscadorMercaderia;

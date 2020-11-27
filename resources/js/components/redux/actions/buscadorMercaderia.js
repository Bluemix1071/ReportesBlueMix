import Axios from "axios";

export const FETCH_MERCADERIA_REQUEST = 'FETCH_MERCADERIA_REQUEST';
export const FETCH_MERCADERIA_SUCCESS = 'FETCH_MERCADERIA_SUCCESS';
export const FETCH_MERCADERIA_FAILURE = 'FETCH_MERCADERIA_FAILURE';
export const FETCH_MERCADERIA_RESET = 'FETCH_MERCADERIA_RESET';


export const fetchMercaderiaRequest =()=>{

    return {
        type: FETCH_MERCADERIA_REQUEST
    }
}

export const fetchMercaderiaSuccess =(mercaderia)=>{

    return {
        type: FETCH_MERCADERIA_SUCCESS,
        payload: mercaderia
    }
}

export const fetchMercaderiaFailure = (error) => {
    return {
        type: FETCH_MERCADERIA_FAILURE,
        payload: error
    }
}

export const fetchMercaderiaReset = () => {
    return {
        type: FETCH_MERCADERIA_RESET,

    }
}

export const fetchMercaderia = (entrada) => {
    return (dispatch)=>{
        dispatch(fetchMercaderiaRequest());

        Axios.get('GetCaja/'+entrada)
        .then(resp =>{

            console.log(resp);

            if ( resp.data && resp.data.caja.productos_en_trancito.length) {
                dispatch(fetchMercaderiaSuccess([resp.data.caja]));
            }else{
                dispatch(fetchMercaderiaFailure('no se encontro la mercaderia'));
            }



        })
        .catch(error=>{
            dispatch(fetchMercaderiaFailure('no se encontro la mercaderia'));
        })
    }
}

import Axios from "axios";

export const FETCH_PRODUCT_REQUEST = 'FETCH_PRODUCT_REQUEST';
export const FETCH_PRODUCT_SUCCESS = 'FETCH_PRODUCT_SUCCESS';
export const FETCH_PRODUCT_FAILURE = 'FETCH_PRODUCT_FAILURE';
export const FETCH_RESET = 'FETCH_RESET';



//ACTIONS

export const fetchProductRequest = () => {
    return {
        type: FETCH_PRODUCT_REQUEST
    }
}

export const fetchProductSuccess = (producto) => {
    return {
        type: FETCH_PRODUCT_SUCCESS,
        payload: producto
    }
}

export const fetchProductFailure = (error) => {
    return {
        type: FETCH_PRODUCT_FAILURE,
        payload: error
    }
}

export const fetchReset = () => {
    return {
        type: FETCH_RESET,

    }
}

export const fetchProduct = (entrada) => {
    return (dispatch)=>{
        dispatch(fetchProductRequest());

        Axios.post('getProductos',entrada)
        .then(resp =>{

            if ( resp.data.producto && resp.data.producto.length) {
                dispatch(fetchProductSuccess([resp.data]));
            }else{
                dispatch(fetchProductFailure('no se encontro el producto'));
            }



        })
        .catch(error=>{
            dispatch(fetchProductFailure('no se encontro el producto'));
        })
    }
}



export default fetchProduct;

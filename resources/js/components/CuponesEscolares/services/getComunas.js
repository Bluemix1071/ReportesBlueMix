export function getComunas(Productos,Caja) {
    try {
        const caja = axios.get("https://apis.digital.gob.cl/dpa/comunas");
        return caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

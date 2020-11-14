export function getCajaService(id) {
    try {
        const caja = axios.get("GetCaja/"+id);
        return caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

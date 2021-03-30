export function getMercaderiaService(data) {
    try {
        const Caja = axios.get("GetListadoCajas/"+data);
        return Caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

export function getMercaderiaService(data) {
    try {
        const Caja = axios.get("GetCaja/"+data);
        return Caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

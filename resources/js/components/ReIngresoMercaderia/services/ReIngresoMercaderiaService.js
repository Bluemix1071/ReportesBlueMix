export function ReIngresoMercaderiaService(data) {
    try {
        const Caja = axios.get("ReIngresarMercaderia/"+data);
        return Caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

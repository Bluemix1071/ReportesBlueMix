export function EnvioMercaderiaModificada(id,Productos,Caja) {
    try {
        const caja = axios.put("UpdateCaja/"+id,Productos,Caja);
        return caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

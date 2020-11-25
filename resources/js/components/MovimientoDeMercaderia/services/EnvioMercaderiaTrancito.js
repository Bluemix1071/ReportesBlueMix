export function EnvioMercaderia(Productos,Caja) {
    try {
        const caja = axios.post("GenerarProductosEnTrancito",Productos,Caja);
        return caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

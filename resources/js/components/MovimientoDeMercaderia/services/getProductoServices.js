export function getProductoService(data) {
    try {
        const Producto = axios.post("getProductos",data);
        return Producto;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

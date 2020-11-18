export function getProductoService() {
    try {
        const Producto = axios.get("getProductos/");
        return Producto;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

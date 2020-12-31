export function getColegios() {
    try {
        const caja = axios.get("GetColegios");
        return caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

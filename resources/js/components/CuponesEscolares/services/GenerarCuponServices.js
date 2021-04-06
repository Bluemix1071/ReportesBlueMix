export function GenerarCuponService(alumno,Apoderado) {
    try {
        const caja = axios.post("GenerarCupon",alumno,Apoderado);
        return caja;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

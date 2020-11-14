

export function LoginService() {
    try {
        const user = axios.get("getSession");
        return user;
    } catch (e) {
        console.log(e);
        return false;
    }

    return false;
}

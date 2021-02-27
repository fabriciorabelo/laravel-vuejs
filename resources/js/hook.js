import jwt from "jsonwebtoken";

export function forgotStorage() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
}

export function isAuthorized() {
    var token = localStorage.getItem("token");
    if (!!token) {
        try {
            const data = jwt.verify(
                token,
                "o9Tovt1M024PC0ep8zbggtGioLT2C1N70rCm7ZKf3aHTVdDFZj3QXnWNBFqeosR4"
            );
            const expires = new Date(data.exp * 1000);
            if (expires > new Date()) return true;
        } catch (e) {
            forgotStorage();
            return false;
        }
    }
    forgotStorage();
    return false;
}

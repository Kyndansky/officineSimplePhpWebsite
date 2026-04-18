document.addEventListener("DOMContentLoaded", main);

function main() {
    document.getElementById("loginButton").addEventListener("click", login);
}

async function login() {
    const email = document.getElementById("emailInput").value;
    const password = document.getElementById("passwordInput").value;

    const result = await customerLogin(email, password);
    if (result["successful"] === true) {
        setAuthInfo();
    }
}
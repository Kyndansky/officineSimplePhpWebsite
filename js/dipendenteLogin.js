document.addEventListener("DOMContentLoaded", main);

function main() {
    document.getElementById("loginButton").addEventListener("click", login);
}

async function login() {
    const username = document.getElementById("usernameInput").value;
    const password = document.getElementById("passwordInput").value;

    const result = await dipendenteLogin(username, password);
    console.log(result);
    if (result["successful"] === true) {
        setAuthInfo();
    }
}
document.addEventListener("DOMContentLoaded", main);

function main() {
    document.getElementById("registerButton").addEventListener("click", register);
}

async function register() {
    const name = document.getElementById("nameInput").value;
    const surname = document.getElementById("surnameInput").value;
    const password = document.getElementById("passwordInput").value;
    const email = document.getElementById("emailInput").value;
    const phone = document.getElementById("phoneNumberInput").value;
    const result = await customerRegister(password, name, surname, email, phone);
    console.log(result)
    if (result["successful"] === true) {
        setAuthInfo();
    }
}
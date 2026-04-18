document.addEventListener("DOMContentLoaded", main);

async function main() {
    setAuthInfo();
}

async function setAuthInfo() {
    const authInfo = await fetchAuthInfo();
    const authInfoDiv = document.getElementById("authInfo");
    if (authInfo["data"] == null) {
        authInfoDiv.innerText = "User is not authenticated";
    }
    else {
        authInfoDiv.innerText = "User is authenticated. Hello ";
        if (authInfo["data"]["ruolo"]) {
            authInfoDiv.innerText += authInfo["data"]["username"];
            authInfoDiv.innerText += " {" + authInfo["data"]["ruolo"] + "}";
        }
        else {
            authInfoDiv.innerText += authInfo["data"]["nome"];
        }
        let buttonLogout = document.createElement("button");
        buttonLogout.innerText = "Logout";
        buttonLogout.addEventListener("click", handleLogout);
        authInfoDiv.appendChild(buttonLogout);
    }
}

async function handleLogout() {
    const result = await logout();
    if (result["successful"] === true) {
        setAuthInfo();
    }
}
var baseEndPoint = "../api/";

//returns all officine (filtered by a pezzo or servizio or accessorio or all of them if given)
async function fetchAllOfficine(
  pezzoId = null,
  servizioId = null,
  accessorioId = null,
) {
  const data = new URLSearchParams({
    pezzoId: pezzoId,
    servizioId: servizioId,
    accessorioId: accessorioId,
  });

  const response = await fetch(baseEndPoint + "getOfficine.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  let json = JSON.parse(body);
  return json;
}

//returns all items given an item type ("Pezzi" | "Accessori" | "Servizi") from a certain officina
async function fetchAllItemsFromOfficina(itemType, officinaId) {
  const data = new URLSearchParams({
    officinaId: officinaId,
    itemType: itemType,
  });

  const response = await fetch(baseEndPoint + "getItemsOfficina.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  return JSON.parse(body);
}

//returns all items given an item type ("Pezzi" | "Accessori" | "Servizi")
async function fetchItems(itemType) {
  const data = new URLSearchParams({
    itemType: itemType,
  });
  const response = await fetch(baseEndPoint + "getItems.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function fetchAuthInfo() {
  const response = await fetch(baseEndPoint + "getAuthInfo.php", {
    method: "POST",
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function dipendenteLogin(username, password) {
  const data = new URLSearchParams({
    username: username,
    password: password,
  });
  const response = await fetch(baseEndPoint + "dipendenteLogin.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  console.log(body);
  return JSON.parse(body);
}


async function customerLogin(username, password) {
  const data = new URLSearchParams({
    username: username,
    password: password,
  });
  const response = await fetch(baseEndPoint + "customerLogin.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  console.log(body);
  return JSON.parse(body);
}

async function customerRegister(username, password, name, surname, email, phone) {
  const data = new URLSearchParams({
    username: username,
    password: password,
    name: name,
    surname: surname,
    email: email,
    phone: phone,
  });
  const response = await fetch(baseEndPoint + "customerRegister.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function logout() {
  const response = await fetch(baseEndPoint + "logout.php", {
    method: "GET",
  });
  let body = await response.text();
  return JSON.parse(body);
}
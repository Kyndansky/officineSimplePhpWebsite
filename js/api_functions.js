var baseEndpoint = "../api/";
var officineEndpoint = baseEndpoint + "officine/"
var authEndpoint = baseEndpoint + "auth/";
var itemsEndpoint = baseEndpoint + "items/";
var accessoriEndpoint = itemsEndpoint + "accessori/";
var pezziEndpoint = itemsEndpoint + "pezzi/";
var serviziEndpoint = itemsEndpoint + "servizi/";

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

  const response = await fetch(officineEndpoint + "getOfficine.php", {
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

  const response = await fetch(baseEndpoint + "getItemsOfficina.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  return JSON.parse(body);
}

//returns all items given an item type ("Pezzi" | "Accessori" | "Servizi")
// async function fetchItems(itemType) {
//   //we select the endpoint based on the parameter given
//   const endPoint = itemType === "Pezzi" ? pezziEndpoint + "getAllPezzi.php" : itemType === "Accessori" ? accessoriEndpoint + "getAllAccessori.php" : itemType === "Servizi" ? serviziEndpoint + "getAllServizi.php" : "";
//   const data = new URLSearchParams({
//     itemType: itemType,
//   });
//   const response = await fetch(endPoint, {
//     method: "POST",
//     body: data,
//   });
//   let body = await response.text();
//   return JSON.parse(body);
// }

async function fetchAllAccessori() {
  const response = await fetch(accessoriEndpoint + "getAllAccessori.php", {
    method: "POST",
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function fetchAllPezzi() {
  const response = await fetch(pezziEndpoint + "getAllPezzi.php", {
    method: "POST",
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function fetchAllServizi() {
  const response = await fetch(serviziEndpoint + "getAllServizi.php", {
    method: "POST",
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function fetchAuthInfo() {
  const response = await fetch(authEndpoint + "getAuthInfo.php", {
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
  const response = await fetch(authEndpoint + "dipendenteLogin.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function customerLogin(email, password) {
  const data = new URLSearchParams({
    email: email,
    password: password,
  });
  const response = await fetch(authEndpoint + "customerLogin.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function customerRegister(
  password,
  name,
  surname,
  email,
  phone,
) {
  const data = new URLSearchParams({
    password: password,
    name: name,
    surname: surname,
    email: email,
    phone: phone,
  });
  const response = await fetch(authEndpoint + "customerRegister.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function logout() {
  const response = await fetch(authEndpoint + "logout.php", {
    method: "GET",
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function addItem(itemType, name, description, price) {
  const data = new URLSearchParams({
    name: name,
    description: description,
    price: price,
  });
  const response = await fetch(baseEndpoint + "add" + itemType + ".php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  return JSON.parse(body);
}

async function addPezzo(name, description, price) {
  const data = new URLSearchParams({
    name: name,
    description: description,
    price: price,
  });
  const response = await fetch(pezziEndpoint + "addPezzo.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  console.log(body);
  return JSON.parse(body);
}


async function addAccessorio(name, description, price) {
  const data = new URLSearchParams({
    name: name,
    description: description,
    price: price,
  });
  const response = await fetch(accessoriEndpoint + "addAccessorio.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  console.log(body);
  return JSON.parse(body);
}

async function addServizio(name, description, price) {
  const data = new URLSearchParams({
    name: name,
    description: description,
    price: price,
  });
  const response = await fetch(serviziEndpoint + "addServizio.php", {
    method: "POST",
    body: data,
  });
  let body = await response.text();
  console.log(body);
  return JSON.parse(body);
}


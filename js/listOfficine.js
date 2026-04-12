document.addEventListener("DOMContentLoaded", main);

async function main() {
  const officineResult = await fetchAllOfficine();
  if (!officineResult.successful) return;
  populateOfficine(officineResult.data["officine"]);

  const pezziResult = await fetchItems("Pezzi");
  const accessoriResult = await fetchItems("Accessori");
  const serviziResult = await fetchItems("Servizi");

  if (!pezziResult || !accessoriResult || !serviziResult)
    return;

  populateFilters(pezziResult.data["pezzi"], accessoriResult.data["accessori"], serviziResult.data["servizi"]);
  document.getElementById("filterButton").addEventListener("click", searchFilteredOfficine);
}

async function searchFilteredOfficine() {
  const filterPezzoId = document.getElementById("selectPezzi").value;
  const filterAccessorioId = document.getElementById("selectAccessori").value;
  const filterServizioId = document.getElementById("selectServizi").value;

  const officineResult = await fetchAllOfficine(filterPezzoId, filterServizioId, filterAccessorioId);

  populateOfficine(officineResult.data["officine"]);
}

//populates the 3 filters selects
function populateFilters(pezzi, accessori, servizi) {
  const selectPezzi = document.getElementById("selectPezzi");
  const selectservizi = document.getElementById("selectServizi");
  const selectAccessori = document.getElementById("selectAccessori");

  populateFilterSelects(pezzi, "nome_pezzo", "codice_pezzo", selectPezzi);
  populateFilterSelects(accessori, "nome_accessorio", "codice_accessorio", selectAccessori);
  populateFilterSelects(servizi, "nome_servizio", "codice_servizio", selectservizi);
}

//populates a select with options given a certain collection and the value to be displayed for every option 
function populateFilterSelects(collection, displayedFieldName, valueFieldName, select) {
  collection.forEach(element => {
    const option = document.createElement("option");
    option.value = element[valueFieldName];
    option.innerText = element[displayedFieldName];
    select.appendChild(option);
  });

}

function populateOfficine(officine) {
  const officineDiv = document.getElementById("officine");

  //we remove all of the old content before populating the div (doing this to ensure that filtering doesn't only add but also overwrite old officine)
  officineDiv.innerHTML = "";

  officine.forEach((officina) => {
    const officinaDiv = document.createElement("div");
    officinaDiv.id = officina["codice_officina"];
    officinaDiv.className = "officina";
    const infoText = document.createElement("p");
    infoText.className = "officinaInfoParagraph";
    infoText.innerText = `${officina["codice_officina"]} | ${officina["denominazione"]} | ${officina["indirizzo"]}`;
    officinaDiv.appendChild(infoText);

    const btn = document.createElement("button");
    btn.className = "toggleInfoBtn";
    btn.innerText = "Show/Hide Info";
    btn.addEventListener("click", () => toggleOfficinaDetails(officina["codice_officina"], officinaDiv));
    officinaDiv.appendChild(btn);

    const detailsContainer = document.createElement("div");
    detailsContainer.className = "details-container";
    detailsContainer.hidden = true;
    officinaDiv.appendChild(detailsContainer);

    officineDiv.appendChild(officinaDiv);
  });
}

//toggles visibility of officina items and, if not present, fetches those items from the database
async function toggleOfficinaDetails(id, officinaDiv) {
  const detailsContainer = officinaDiv.querySelector(".details-container");

  if (detailsContainer.childElementCount > 0) {
    detailsContainer.hidden = !detailsContainer.hidden;
    return;
  }
  const itemsResult = await fetchAllItemsFromOfficina(null, id);

  if (itemsResult.successful) {
    detailsContainer.appendChild(createSectionDiv(itemsResult.data["servizi"], "nome_servizio", "servizi"));
    detailsContainer.appendChild(createSectionDiv(itemsResult.data["pezzi"], "nome_pezzo", "pezzi"));
    detailsContainer.appendChild(createSectionDiv(itemsResult.data["accessori"], "nome_accessorio", "accessori"));
  }
  detailsContainer.hidden = false;
}

//creates a div containing all of a collection items
function createSectionDiv(collection, fieldName, className) {
  const div = document.createElement("div");
  div.className = className;

  let content = "{ ";
  if (collection) {
    collection.forEach((item) => {
      content += "| ";
      content += item[fieldName];
    });
  }

  content += " | }";

  div.innerText = content;
  return div;
}
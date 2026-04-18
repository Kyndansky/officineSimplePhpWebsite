document.addEventListener("DOMContentLoaded", main);

function main() {
    //making button press call addItem function
    document
        .getElementById("addPezzoButton")
        .addEventListener("click", () => addItem("pezzo"));
    document
        .getElementById("addServizioButton")
        .addEventListener("click", () => addItem("servizio"));
    document
        .getElementById("addAccessorioButton")
        .addEventListener("click", () => addItem("accessorio"));
}

//handles everything for adding an item
async function addItem(itemType) {
    //return if itemType is not valid
    if (itemType !== "pezzo" && itemType !== "servizio" && itemType !== "accessorio") return;

    const itemNameValue = document.getElementById(itemType + "NameInput").value;
    const itemdescriptionValue = document.getElementById(
        itemType + "DescriptionInput",
    ).value;
    const itemPriceValue = document.getElementById(itemType + "PriceInput").value;

    if (itemNameValue === "" || itemdescriptionValue === "" || itemPriceValue === "")
        return;

    let result;
    if (itemType === "pezzo") result = await addPezzo(itemNameValue, itemdescriptionValue, itemPriceValue);
    if (itemType === "accessorio") result = await addAccessorio(itemNameValue, itemdescriptionValue, itemPriceValue);
    if (itemType === "servizio") result = await addServizio(itemNameValue, itemdescriptionValue, itemPriceValue);

    console.log(result);
    //todo add msg display or stuff
}

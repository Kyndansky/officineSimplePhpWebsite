<?php
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../config/globals.php";
require_once("./../classes/OfficineManager.php");
Header("Content-Type: application/json");

$officinaId = $_POST["officinaId"];

if (!isset($officinaId)) {
    echo error("officinaId is required to do this!");
    exit;
}
$itemType = isset($_POST["itemType"]) ? strtolower($_POST["itemType"]) : null;

$manager = new OfficineManager();
$data = [];

//if no itemType is given, everything is returned (pezzi, accessori and servizi)
if (is_null($itemType) || $itemType == "null") {
    $data["servizi"] = $manager->getAllServiziOfOfficina($officinaId);
    $data["pezzi"] = $manager->getAllPezziOfOfficina($officinaId);
    $data["accessori"] = $manager->getAllAccessoriOfOfficina($officinaId);
    echo ok("successfully retrieved pezzi, servizi and accessori of officina $officinaId", $data);
    exit;
}


//if the value of itemType is not valid, return error
if (!array_key_exists($itemType, ITEMTABLES)) {
    echo error("The item type is not valid!");
    exit;
}

//if the value of itemType is either Pezzi, Accessori or Servizi, those are fetched and returned
if ($itemType === "pezzi")
    $data["pezzi"] = $manager->getAllPezziOfOfficina($officinaId);
elseif ($itemType === "accessori")
    $data["accessori"] = $manager->getAllAccessoriOfOfficina($officinaId);
else
    $data["servizi"] = $manager->getAllServiziOfOfficina($officinaId);

echo ok("successfully retrieved data", $data);
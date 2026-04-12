<?php
require_once __DIR__ . "/../misc/functions.php";

Header("Content-Type: application/json");

require_once("./../classes/OfficineManager.php");
$itemType = isset($_POST["itemType"]) ? strtolower($_POST["itemType"]) : null;
$manager = new OfficineManager();
$data = [];

//if no itemType is given, everything is returned (pezzi, accessori and servizi)
if (is_null($itemType)) {
    $data["servizi"] = $manager->getAllServiziOfOfficina($officinaId);
    $data["pezzi"] = $manager->getAllPezziOfOfficina($officinaId);
    $data["accessori"] = $manager->getAllAccessoriOfOfficina($officinaId);
    echo ok("successfully retrieved pezzi, servizi and accessori of officina $officinaId", $data);
    exit;
}
require_once __DIR__ ."/../config/globals.php";
//if the value of itemType is not valid, return error
if (!array_key_exists($itemType, ITEMTABLES)) {
    echo error("The item type is not valid!");
    exit;
}

//if the value of itemType is either Pezzi, Accessori or Servizi, those are fetched and returned
$data[$itemType] = $manager->getAll(ITEMTABLES[$itemType]);
echo ok("successfully retrieved data", $data);

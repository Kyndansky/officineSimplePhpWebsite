<?php
require_once __DIR__ . "/../../misc/functions.php";
require_once __DIR__ . "/../../classes/OfficineManager.php";
$manager = new OfficineManager();

//checks if filtering ids where given, if not, we assign all of them to null so that we can use the non-filtering function.
$pezzoId = isset($_POST["pezzoId"]) && $_POST["pezzoId"] !== null && $_POST["pezzoId"] !== "null" ? $_POST["pezzoId"] : null;
$accessorioId = isset($_POST["accessorioId"]) && $_POST["accessorioId"] !== null && $_POST["accessorioId"] !== "null" ? $_POST["accessorioId"] : null;
$servizioId = isset($_POST["servizioId"]) && $_POST["servizioId"] !== null && $_POST["servizioId"] !== "null" ? $_POST["servizioId"] : null;

$officine = [];
if ($pezzoId !== null || $accessorioId !== null || $servizioId !== null)
	$officine = $manager->getAllOfficineFiltered($pezzoId, $accessorioId, $servizioId);
else
	$officine = $manager->getAll("officine");

if ($officine === false || $officine === null || !is_array($officine)) {
	echo error("erorr while retrieving officine from db");
	exit;
} else {
	echo ok("succcessfully retrieved all officine", ["officine" => $officine]);
}

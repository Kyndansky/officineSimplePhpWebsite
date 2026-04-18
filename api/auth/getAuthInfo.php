<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../../misc/functions.php";

if (!isset($_SESSION))
      session_start();

$data = isset($_SESSION["authData"]) ? $_SESSION["authData"] : null;
if ($data === null) {
      echo ok("user is not authenticated",  $data);
      exit;
}

echo ok("user is authenticated", $data);

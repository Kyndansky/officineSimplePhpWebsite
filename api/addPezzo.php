<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/AuthManager.php";

if(!isset($_SESSION))
      session_start();


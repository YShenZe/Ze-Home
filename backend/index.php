<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('#^/api/user$#', $uri) && isset($_GET['username'])) {
    require_once "./api/user.php";
} elseif (preg_match('#^/api/repos$#', $uri) && isset($_GET['username'])) {
    require_once "./api/repos.php";
} else {
    echo json_encode(["error" => "Invalid endpoint"]);
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
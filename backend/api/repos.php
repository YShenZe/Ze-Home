<?php
require_once './vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

if (!isset($_GET['username']) || empty($_GET['username'])) {
    echo json_encode(["error" => "Username is required"]);
    exit;
}

$username = htmlspecialchars($_GET['username']);
$token = $_ENV['GITHUB_TOKEN'];

$url = "https://api.github.com/users/$username/repos";

$options = [
    "http" => [
        "header" => [
            "User-Agent: PHP-App",
            "Authorization: token $token"
        ]
    ]
];

$context = stream_context_create($options);

$response = @file_get_contents($url, false, $context);

if ($response === false) {
    echo json_encode(["error" => "Failed to fetch repository data"]);
    exit;
}

echo $response;
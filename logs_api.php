<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$log_file = __DIR__ . '/logs.json';

if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    file_put_contents($log_file, json_encode([]));
    echo json_encode(["status" => "cleared"]);
    exit;
}

if (file_exists($log_file)) {
    echo file_get_contents($log_file);
} else {
    echo json_encode([]);
}
?>

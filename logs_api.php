<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Type: application/json");

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$log_file = __DIR__ . '/logs.json';

// Handle clear action via GET or POST
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if ($action === 'clear') {
    @file_put_contents($log_file, '[]', LOCK_EX);
    echo json_encode(["status" => "cleared", "logs" => []]);
    exit;
}

if (file_exists($log_file)) {
    $content = @file_get_contents($log_file);
    if ($content !== false && !empty(trim($content))) {
        echo $content;
        exit;
    }
}

echo json_encode([]);
?>

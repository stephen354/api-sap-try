<?php
require_once __DIR__ . '/config_api.php';

function getallheaders_custom() {
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
        if ($headers !== false) {
            return $headers;
        }
    }
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $header_name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
            $headers[$header_name] = $value;
        }
    }
    return $headers;
}

function parse_request_input() {
    $raw_input = file_get_contents('php://input');
    $decoded_json = json_decode($raw_input, true);
    
    $payload = null;
    if ($decoded_json !== null) {
        $payload = $decoded_json;
    } elseif (!empty($_POST)) {
        $payload = $_POST;
    } elseif (!empty(trim($raw_input))) {
        $payload = $raw_input;
    } else {
        $payload = "(Kosong / Empty)";
    }

    return [
        "payload" => $payload,
        "raw_body" => $raw_input
    ];
}

function add_log($endpoint, $method, $status, $input, $output) {
    $log_file = __DIR__ . '/logs.json';
    $logs = [];
    if (file_exists($log_file)) {
        $content = @file_get_contents($log_file);
        if ($content !== false) {
            $logs = json_decode($content, true) ?: [];
        }
    }

    $new_entry = [
        "id" => uniqid(),
        "time" => date("Y-m-d H:i:s"),
        "endpoint" => $endpoint,
        "method" => $method,
        "status" => $status,
        "token_required" => is_token_required(),
        "user_agent" => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown / SAP HTTP Client',
        "remote_ip" => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',
        "input" => $input,
        "output" => $output
    ];

    array_unshift($logs, $new_entry);
    // Keep last 50 entries
    $logs = array_slice($logs, 0, 50);

    @file_put_contents($log_file, json_encode($logs, JSON_PRETTY_PRINT), LOCK_EX);
}
?>

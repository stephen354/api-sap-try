<?php
// CORS Headers untuk pengujian browser
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');

require_once __DIR__ . '/log_helper.php';

// 1. Ambil kiriman REQ_JSON dari ABAP / Client (Tanpa Cek Header Authorization)
$parsed = parse_request_input();
$req_json = $parsed['raw_body'];
$data_dari_sap = $parsed['payload'];

$headers = getallheaders_custom();

$input_log_data = [
    "auth_header" => "(TIDAK DIBUTUHKAN / BYPASS)",
    "payload_json" => $data_dari_sap,
    "raw_body" => $req_json,
    "headers" => $headers,
    "query_params" => $_GET
];

// 2. Balas ke SAP (Menghasilkan RES_JSON)
$response = [
    "status" => "Sukses",
    "pesan"  => "Mantap bro, data JSON berhasil diterima tanpa perlu token!",
    "mode_api" => "TANPA HEADER TOKEN (api_no_header.php)",
    "data_kamu" => $data_dari_sap !== null ? $data_dari_sap : $req_json
];

http_response_code(201); // Set HTTP Status 201 Created

add_log("API TANPA HEADER (api_no_header.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 201, $input_log_data, $response);

echo json_encode($response);
?>

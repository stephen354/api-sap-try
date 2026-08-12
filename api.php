<?php
// CORS Headers for browser testing
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');

require_once __DIR__ . '/log_helper.php';

$token_required = is_token_required();

// 1. Ambil Header untuk ngecek Token
$headers = getallheaders_custom(); 
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';

// (Fallback jika server tidak pakai apache)
if (empty($auth_header) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $auth_header = $_SERVER['HTTP_AUTHORIZATION'];
}
if (empty($auth_header) && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
    $auth_header = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
}

// 3. Ambil kiriman REQ_JSON dari ABAP
$req_json = file_get_contents('php://input');
$data_dari_sap = json_decode($req_json, true);

// 2. Cek apakah Token yang dibawa sama dengan Token yang kita buat (Jika Token Auth AKTIF)
if ($token_required && $auth_header !== 'Bearer token_rahasia_12345') {
    http_response_code(401);
    $response = [
        "pesan" => "Akses Ditolak, Token tidak valid!",
        "token_mode" => "AKTIF (Wajib Token Valid)"
    ];
    add_log("API_URL (api.php)", $_SERVER['REQUEST_METHOD'], 401, [
        "auth_header" => $auth_header,
        "req_raw" => $req_json,
        "headers" => $headers
    ], $response);
    echo json_encode($response);
    exit;
}

// 4. Balas ke SAP (Ini yang akan jadi RES_JSON)
$response = [
    "status" => "Sukses",
    "pesan"  => $token_required 
        ? "Mantap bro, data JSON berhasil diterima di PHP!" 
        : "Mantap bro, data JSON berhasil diterima di PHP! (Token Auth: BYPASS / NONAKTIF)",
    "token_mode" => $token_required ? "AKTIF (Token Valid)" : "NONAKTIF (Bypass Token)",
    "data_kamu" => $data_dari_sap !== null ? $data_dari_sap : $req_json
];

http_response_code(201); // Set status 201 sesuai harapan di ABAP kamu
add_log("API_URL (api.php)", $_SERVER['REQUEST_METHOD'], 201, [
    "auth_header" => $auth_header ?: "(Tanpa Token / Bypass)",
    "req_json" => $data_dari_sap,
    "req_raw" => $req_json,
    "headers" => $headers
], $response);

echo json_encode($response);
?>

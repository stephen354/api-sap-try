<?php
// CORS Headers for browser testing
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');

require_once __DIR__ . '/log_helper.php';

// Check if token auth is bypassed via config OR via URL parameter (?bypass=1 or ?no_token=1)
$url_bypass = isset($_GET['bypass']) || isset($_GET['no_token']) || isset($_GET['bypass_token']);
$token_required = is_token_required() && !$url_bypass;

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

// 2. Cek apakah Token yang dibawa sama dengan Token yang kita buat (Jika Token Auth WAJIB)
if ($token_required && $auth_header !== 'Bearer token_rahasia_12345') {
    http_response_code(401);
    $response = [
        "status" => "Gagal",
        "pesan"  => "Akses Ditolak, Token tidak valid atau tidak dikirim!",
        "token_mode" => "AKTIF (Wajib Header 'Authorization: Bearer token_rahasia_12345')",
        "tips" => "Kamu bisa matikan Token Auth di Web UI, atau panggil URL dengan parameter api.php?bypass=1"
    ];
    add_log("API_URL (api.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 401, [
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
    "token_mode" => $token_required ? "AKTIF (Token Valid)" : "NONAKTIF (Bypass Mode)",
    "data_kamu" => $data_dari_sap !== null ? $data_dari_sap : $req_json
];

http_response_code(201); // Set status 201 sesuai harapan di ABAP kamu
add_log("API_URL (api.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 201, [
    "auth_header" => $auth_header ?: "(Tanpa Token / Bypass)",
    "req_json" => $data_dari_sap,
    "req_raw" => $req_json,
    "headers" => $headers
], $response);

echo json_encode($response);
?>

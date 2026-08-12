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

// 1. Ambil Header untuk ngecek Token secara fleksibel (Case-insensitive)
$headers = getallheaders_custom(); 
$auth_header = '';

foreach ($headers as $k => $v) {
    if (strtolower($k) === 'authorization') {
        $auth_header = trim($v);
        break;
    }
}

if (empty($auth_header) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $auth_header = trim($_SERVER['HTTP_AUTHORIZATION']);
}
if (empty($auth_header) && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
    $auth_header = trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
}

// 3. Tangkap dan parse data input dari ABAP / Client
$parsed = parse_request_input();
$req_json = $parsed['raw_body'];
$data_dari_sap = $parsed['payload'];

$input_log_data = [
    "auth_header" => !empty($auth_header) ? $auth_header : "(Tidak dikirim / Empty Auth Header)",
    "token_bypass" => !$token_required,
    "payload_json" => $data_dari_sap,
    "raw_body" => $req_json,
    "headers" => $headers,
    "query_params" => $_GET
];

// Cek kecocokan Token fleksibel (menerima 'Bearer token_rahasia_12345', 'bearer token_rahasia_12345', atau sekedar token string)
$is_valid_token = false;
if (!empty($auth_header)) {
    if (strcasecmp($auth_header, 'Bearer token_rahasia_12345') === 0 || strpos($auth_header, 'token_rahasia_12345') !== false) {
        $is_valid_token = true;
    }
}

// 2. Cek apakah Token yang dibawa valid (Jika Token Auth WAJIB)
if ($token_required && !$is_valid_token) {
    http_response_code(401);
    $response = [
        "status" => "Gagal",
        "pesan"  => "Akses Ditolak, Token tidak valid atau tidak dikirim!",
        "header_diterima" => !empty($auth_header) ? $auth_header : "(Kosong)",
        "format_header_seharusnya" => "Authorization: Bearer token_rahasia_12345",
        "kodingan_abap" => "lo_http_client->request->set_header_field( name = 'Authorization' value = 'Bearer token_rahasia_12345' ).",
        "tips" => "Kamu bisa matikan Token Auth di Web UI, atau panggil URL dengan parameter api.php?bypass=1"
    ];
    add_log("API_URL (api.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 401, $input_log_data, $response);
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
add_log("API_URL (api.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 201, $input_log_data, $response);

echo json_encode($response);
?>

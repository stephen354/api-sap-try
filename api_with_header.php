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

// 1. Ambil Header Authorization secara spesifik
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

// 2. Tangkap kiriman REQ_JSON dari ABAP
$parsed = parse_request_input();
$req_json = $parsed['raw_body'];
$data_dari_sap = $parsed['payload'];

$input_log_data = [
    "auth_header" => !empty($auth_header) ? $auth_header : "(TIDAK DIKIRIM / KOSONG)",
    "payload_json" => $data_dari_sap,
    "raw_body" => $req_json,
    "headers" => $headers,
    "query_params" => $_GET
];

// 3. Validasi Keberadaan dan Isi Token Header
$is_valid_token = false;
if (!empty($auth_header)) {
    if (strcasecmp($auth_header, 'Bearer token_rahasia_12345') === 0 || strpos($auth_header, 'token_rahasia_12345') !== false) {
        $is_valid_token = true;
    }
}

// Jika Token Salah atau Tidak Dikirim -> Kembalikan HTTP 401 Unauthorized
if (!$is_valid_token) {
    http_response_code(401);
    $response = [
        "status" => "Gagal",
        "pesan"  => "Akses Ditolak, Header Authorization atau Bearer Token salah!",
        "mode_api" => "WAJIB HEADER TOKEN (api_with_header.php)",
        "header_diterima" => !empty($auth_header) ? $auth_header : "(Kosong / Tidak Dikirim)",
        "format_header_seharusnya" => "Authorization: Bearer token_rahasia_12345",
        "kodingan_abap" => "lo_http_client->request->set_header_field( name = 'Authorization' value = 'Bearer token_rahasia_12345' )."
    ];
    add_log("API WAJIB HEADER (api_with_header.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 401, $input_log_data, $response);
    echo json_encode($response);
    exit;
}

// 4. Jika Token Valid -> Balas ke SAP (Menghasilkan RES_JSON Status 201)
$response = [
    "status" => "Sukses",
    "pesan"  => "Mantap bro, data JSON dan Header Token 'Bearer token_rahasia_12345' berhasil diterima!",
    "mode_api" => "WAJIB HEADER TOKEN (api_with_header.php)",
    "token_diterima" => $auth_header,
    "data_kamu" => $data_dari_sap !== null ? $data_dari_sap : $req_json
];

http_response_code(201); // Set HTTP Status 201 Created

add_log("API WAJIB HEADER (api_with_header.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 201, $input_log_data, $response);

echo json_encode($response);
?>

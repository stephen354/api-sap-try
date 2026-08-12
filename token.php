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

// =====================================================================
// 🔑 KONFIGURASI CLIENT ID & CLIENT SECRET (GANTI DI SINI JIKA PERLU)
// Nilai ini harus cocok dengan TOKEN_CLIENTID dan TOKEN_SECRET di SAP!
// =====================================================================
$valid_id = "sap_client";       // Nilai untuk TOKEN_CLIENTID di SAP GUI
$valid_secret = "sap_luar";     // Nilai untuk TOKEN_SECRET di SAP GUI

$url_bypass = isset($_GET['bypass']) || isset($_GET['no_token']) || isset($_GET['bypass_token']);
$token_required = is_token_required() && !$url_bypass;

// 1. Tangkap otentikasi Basic Auth (dikirim dari SET_AUTHORIZATION di ABAP)
$client_id = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
$client_secret = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';

// Fallback untuk server CGI/FPM atau manual Authorization header
if (empty($client_id) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
    if (preg_match('/Basic\s+(.*)$/i', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        $userpass = explode(':', base64_decode($matches[1]), 2);
        if (count($userpass) === 2) {
            $client_id = $userpass[0];
            $client_secret = $userpass[1];
        }
    }
}
if (empty($client_id) && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
    if (preg_match('/Basic\s+(.*)$/i', $_SERVER['REDIRECT_HTTP_AUTHORIZATION'], $matches)) {
        $userpass = explode(':', base64_decode($matches[1]), 2);
        if (count($userpass) === 2) {
            $client_id = $userpass[0];
            $client_secret = $userpass[1];
        }
    }
}

// 2. Tangkap grant_type (dikirim dari SET_FORM_FIELD di ABAP)
$grant_type = isset($_POST['grant_type']) ? $_POST['grant_type'] : '';

$parsed = parse_request_input();

if (empty($grant_type)) {
    $raw_input = $parsed['raw_body'];
    parse_str($raw_input, $post_data);
    if (isset($post_data['grant_type'])) {
        $grant_type = $post_data['grant_type'];
    } else {
        $json_data = json_decode($raw_input, true);
        if (isset($json_data['grant_type'])) {
            $grant_type = $json_data['grant_type'];
        }
    }
}

$headers_info = getallheaders_custom();

$input_log_data = [
    "client_id" => !empty($client_id) ? $client_id : "(Tidak Ada Basic Auth)",
    "grant_type" => !empty($grant_type) ? $grant_type : "(Kosong)",
    "payload" => $parsed['payload'],
    "headers" => $headers_info
];

// Cek kecocokan Auth (Jika Token Auth AKTIF)
if ($token_required && ($client_id !== $valid_id || $client_secret !== $valid_secret)) {
    http_response_code(401);
    $response = [
        "status" => "Gagal",
        "pesan" => "Gagal, Client ID atau Secret salah!",
        "client_id_diterima" => !empty($client_id) ? $client_id : "(Kosong)",
        "client_id_seharusnya" => $valid_id,
        "token_mode" => "AKTIF (Wajib Auth)"
    ];
    add_log("TOKEN_URL (token.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 401, $input_log_data, $response);
    echo json_encode($response);
    exit;
}

// Cek grant_type (Jika Token Auth AKTIF)
if ($token_required && $grant_type !== 'client_credentials') {
    http_response_code(400);
    $response = ["pesan" => "Gagal, grant_type salah!", "token_mode" => "AKTIF (Wajib Auth)"];
    add_log("TOKEN_URL (token.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 400, $input_log_data, $response);
    echo json_encode($response);
    exit;
}

// 3. Jika berhasil (atau jika Token Auth Nonaktif), berikan Token
$response = [
    "access_token" => "token_rahasia_12345",
    "token_type"   => "Bearer",
    "expires_in"   => 3600,
    "token_mode"   => $token_required ? "AKTIF" : "NONAKTIF (Bypass Mode)"
];

http_response_code(200);
add_log("TOKEN_URL (token.php)", isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'POST', 200, $input_log_data, $response);

echo json_encode($response);
?>

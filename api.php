<?php
require_once __DIR__ . '/config_api.php';

$url_bypass = isset($_GET['bypass']) || isset($_GET['no_token']) || isset($_GET['bypass_token']);
$token_required = is_token_required() && !$url_bypass;

if (!$token_required) {
    require __DIR__ . '/api_no_header.php';
} else {
    require __DIR__ . '/api_with_header.php';
}
?>

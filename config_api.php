<?php
$config_file = __DIR__ . '/config.json';

function get_config() {
    global $config_file;
    if (file_exists($config_file)) {
        $content = file_get_contents($config_file);
        $data = json_decode($content, true);
        if (is_array($data) && isset($data['require_token'])) {
            return $data;
        }
    }
    return ["require_token" => true];
}

function save_config($data) {
    global $config_file;
    file_put_contents($config_file, json_encode($data, JSON_PRETTY_PRINT));
}

function is_token_required() {
    $config = get_config();
    return (bool)$config['require_token'];
}

// Only execute endpoint logic when called directly, NOT when included by other files
$script_name = basename(isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '');
if ($script_name === 'config_api.php') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Content-Type: application/json");

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    if ((isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') || isset($_GET['action'])) {
        $current = get_config();
        if (isset($_GET['status'])) {
            $new_status = ($_GET['status'] === 'true' || $_GET['status'] === '1');
        } else {
            $raw = file_get_contents('php://input');
            $input = json_decode($raw, true);
            if (isset($input['require_token'])) {
                $new_status = (bool)$input['require_token'];
            } else {
                $new_status = !$current['require_token'];
            }
        }
        $current['require_token'] = $new_status;
        save_config($current);
        echo json_encode($current);
        exit;
    }

    echo json_encode(get_config());
    exit;
}
?>

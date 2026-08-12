<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAP ABAP REST API Tester & Live Inspector</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-body: #090d16;
            --bg-card: #131a2a;
            --bg-card-hover: #1a2338;
            --bg-input: #0d121f;
            --border: #232d42;
            --border-focus: #3b82f6;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent-blue: #3b82f6;
            --accent-cyan: #06b6d4;
            --accent-indigo: #6366f1;
            --accent-emerald: #10b981;
            --accent-rose: #f43f5e;
            --accent-amber: #f59e0b;
            --radius-lg: 16px;
            --radius-md: 10px;
            --radius-sm: 6px;
            --shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-primary);
            font-family: var(--font-sans);
            line-height: 1.5;
            min-height: 100vh;
            padding: 24px;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-cyan));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
            color: #fff;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.4);
        }

        .logo-text h1 {
            font-size: 20px;
            font-weight: 700;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-text p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .server-badge {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-family: var(--font-mono);
            color: var(--accent-cyan);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: var(--accent-emerald);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--accent-emerald);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.2); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* Nav Tabs */
        .tabs-nav {
            display: flex;
            gap: 8px;
            background: var(--bg-card);
            padding: 6px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            margin-bottom: 28px;
            width: fit-content;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.03);
        }

        .tab-btn.active {
            background: var(--accent-blue);
            color: #fff;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Main Layout Grid */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 900px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* Cards */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow);
            position: relative;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.2);
            color: var(--accent-blue);
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            color: var(--text-primary);
            font-size: 13px;
            font-family: var(--font-sans);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        textarea.form-control {
            font-family: var(--font-mono);
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* Buttons */
        .btn {
            background: var(--accent-blue);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-block {
            width: 100%;
        }

        .btn-emerald {
            background: var(--accent-emerald);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* JSON presets */
        .presets {
            display: flex;
            gap: 6px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .preset-chip {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 11px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.15s;
        }

        .preset-chip:hover {
            border-color: var(--accent-cyan);
            color: var(--accent-cyan);
        }

        /* Response Box */
        .response-box {
            margin-top: 20px;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 16px;
        }

        .response-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 700;
            font-family: var(--font-mono);
        }

        .status-badge.s200, .status-badge.s201 {
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent-emerald);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-badge.s400, .status-badge.s401, .status-badge.s500 {
            background: rgba(244, 63, 94, 0.15);
            color: var(--accent-rose);
            border: 1px solid rgba(244, 63, 94, 0.3);
        }

        .status-badge.idle {
            background: rgba(148, 163, 184, 0.1);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .time-taken {
            font-size: 11px;
            color: var(--text-muted);
            font-family: var(--font-mono);
        }

        pre {
            font-family: var(--font-mono);
            font-size: 12px;
            color: #38bdf8;
            white-space: pre-wrap;
            word-break: break-all;
            background: #060911;
            padding: 12px;
            border-radius: var(--radius-sm);
            max-height: 240px;
            overflow-y: auto;
        }

        /* ABAP Cheat Sheet Table */
        .param-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .param-table th, .param-table td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .param-table th {
            color: var(--text-secondary);
            font-weight: 600;
            background: rgba(0, 0, 0, 0.2);
        }

        .param-name {
            font-family: var(--font-mono);
            font-weight: 600;
            color: var(--accent-cyan);
        }

        .param-val {
            font-family: var(--font-mono);
            color: var(--text-primary);
            background: var(--bg-input);
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .copy-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 2px 6px;
            font-size: 12px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .copy-btn:hover {
            color: var(--accent-cyan);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Log Inspector */
        .log-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .log-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .log-item {
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 16px;
            transition: all 0.2s;
        }

        .log-item:hover {
            border-color: rgba(59, 130, 246, 0.4);
        }

        .log-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .log-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 14px;
        }

        .method-tag {
            font-family: var(--font-mono);
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            background: rgba(99, 102, 241, 0.2);
            color: var(--accent-indigo);
        }

        .log-meta {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            gap: 16px;
            margin-bottom: 10px;
        }

        .log-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            background: #060911;
            padding: 12px;
            border-radius: var(--radius-sm);
            margin-top: 10px;
            font-family: var(--font-mono);
            font-size: 11px;
        }

        .empty-logs {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: var(--accent-emerald);
            color: #fff;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 9999;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <div class="logo-area">
            <div class="logo-icon">SAP</div>
            <div class="logo-text">
                <h1>SAP ABAP REST API Tester</h1>
                <p>Uji Coba Function Module ABAP, Token Authentication & Payload JSON</p>
            </div>
        </div>
        <div class="server-badge">
            <span class="status-dot"></span>
            <span id="server-url">Laragon Server Active</span>
        </div>
    </header>

    <!-- Navigation Tabs -->
    <div class="tabs-nav">
        <button class="tab-btn active" onclick="switchTab('tester')">⚡ API Tester</button>
        <button class="tab-btn" onclick="switchTab('inspector')">🛰️ Live Request Inspector (SAP Monitor)</button>
        <button class="tab-btn" onclick="switchTab('abap')">📋 SAP ABAP Parameter Guide</button>
    </div>

    <!-- TAB 1: API TESTER -->
    <div id="tab-tester" class="tab-content active">
        <div class="grid-2">
            <!-- STEP 1: TOKEN GENERATOR -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="step-num">1</span>
                        <span>Uji Endpoint TOKEN_URL (token.php)</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Target URL (TOKEN_URL)</label>
                    <input type="text" id="token_url" class="form-control" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>token.php">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Client ID (Basic Auth)</label>
                        <input type="text" id="client_id" class="form-control" value="sap_client">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Client Secret (Basic Auth)</label>
                        <input type="password" id="client_secret" class="form-control" value="sap_luar">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">grant_type (POST Form Field)</label>
                    <input type="text" id="grant_type" class="form-control" value="client_credentials">
                </div>

                <button class="btn btn-block" onclick="generateToken()">
                    🔑 Generate Access Token
                </button>

                <div class="response-box">
                    <div class="response-header">
                        <span id="token-status" class="status-badge idle">Status: Idle</span>
                        <span id="token-time" class="time-taken">0 ms</span>
                    </div>
                    <pre id="token-output">// Respon JSON token.php akan tampil di sini...</pre>
                </div>
            </div>

            <!-- STEP 2: MAIN API TESTER -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="step-num">2</span>
                        <span>Uji Endpoint Utama API (api.php)</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Target URL (URL Utama)</label>
                    <input type="text" id="api_url" class="form-control" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>api.php">
                </div>

                <div class="form-group">
                    <label class="form-label">Authorization Header (Bearer Token)</label>
                    <input type="text" id="bearer_token" class="form-control" value="Bearer token_rahasia_12345">
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label class="form-label" style="margin-bottom:0;">REQ_JSON (Payload)</label>
                        <span style="font-size: 11px; color: var(--text-muted);">Contoh Cepat:</span>
                    </div>
                    <div class="presets">
                        <span class="preset-chip" onclick="setPreset(1)">Preset 1 (Basic)</span>
                        <span class="preset-chip" onclick="setPreset(2)">Preset 2 (Material)</span>
                        <span class="preset-chip" onclick="setPreset(3)">Preset 3 (Purchase Order)</span>
                    </div>
                    <textarea id="req_json" class="form-control">{
  "nama": "Budi",
  "pesan": "Testing dari SAP"
}</textarea>
                </div>

                <button class="btn btn-emerald btn-block" onclick="sendApiRequest()">
                    🚀 Kirim REQ_JSON ke API (api.php)
                </button>

                <div class="response-box">
                    <div class="response-header">
                        <span id="api-status" class="status-badge idle">Status: Idle</span>
                        <span id="api-time" class="time-taken">0 ms</span>
                    </div>
                    <pre id="api-output">// Respon RES_JSON api.php akan tampil di sini...</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: LIVE REQUEST INSPECTOR -->
    <div id="tab-inspector" class="tab-content">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <span>🛰️ Live Request Inspector (Setiap HTTP Request yang Masuk ke PHP)</span>
                </div>
                <div style="display:flex; gap: 8px;">
                    <button class="btn btn-secondary btn-sm" onclick="fetchLogs()">🔄 Refresh Manual</button>
                    <button class="btn btn-secondary btn-sm" onclick="clearLogs()">🗑️ Hapus Log</button>
                </div>
            </div>

            <div class="log-toolbar">
                <div style="font-size: 13px; color: var(--text-secondary);">
                    Memantau kiriman HTTP dari <strong>SAP ABAP Function Module</strong> & <strong>Browser UI</strong> secara real-time.
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted);">
                    <input type="checkbox" id="auto-refresh" checked onchange="toggleAutoRefresh(this)">
                    <label for="auto-refresh">Auto Refresh (2 detik)</label>
                </div>
            </div>

            <div id="log-list" class="log-list">
                <div class="empty-logs">Mengambil data log terbaru...</div>
            </div>
        </div>
    </div>

    <!-- TAB 3: ABAP PARAMETER GUIDE -->
    <div id="tab-abap" class="tab-content">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <span>📋 SAP ABAP Function Module Parameter Cheat Sheet</span>
                </div>
            </div>
            <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">
                Saat kamu menjalankan <strong>Test / Execute (F8)</strong> pada Function Module di SAP GUI (SE37), isikan parameter sesuai tabel di bawah ini:
            </p>

            <table class="param-table">
                <thead>
                    <tr>
                        <th>Parameter ABAP</th>
                        <th>Nilai Input</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="param-name">TOKEN_URL</td>
                        <td>
                            <div class="param-val">
                                <span id="abap_token_url"><?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>token.php</span>
                                <button class="copy-btn" onclick="copyText('abap_token_url')">Copy</button>
                            </div>
                        </td>
                        <td>URL untuk generate token OAuth2</td>
                    </tr>
                    <tr>
                        <td class="param-name">TOKEN_CLIENTID</td>
                        <td>
                            <div class="param-val">
                                <span id="abap_client_id">sap_client</span>
                                <button class="copy-btn" onclick="copyText('abap_client_id')">Copy</button>
                            </div>
                        </td>
                        <td>Client ID otentikasi Basic Auth</td>
                    </tr>
                    <tr>
                        <td class="param-name">TOKEN_SECRET</td>
                        <td>
                            <div class="param-val">
                                <span id="abap_secret">sap_luar</span>
                                <button class="copy-btn" onclick="copyText('abap_secret')">Copy</button>
                            </div>
                        </td>
                        <td>Client Secret otentikasi Basic Auth</td>
                    </tr>
                    <tr>
                        <td class="param-name">URL</td>
                        <td>
                            <div class="param-val">
                                <span id="abap_api_url"><?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>api.php</span>
                                <button class="copy-btn" onclick="copyText('abap_api_url')">Copy</button>
                            </div>
                        </td>
                        <td>URL Endpoint Utama API</td>
                    </tr>
                    <tr>
                        <td class="param-name">REQ_JSON</td>
                        <td>
                            <div class="param-val">
                                <span id="abap_req_json">{"nama": "Budi", "pesan": "Testing dari SAP"}</span>
                                <button class="copy-btn" onclick="copyText('abap_req_json')">Copy</button>
                            </div>
                        </td>
                        <td>Payload JSON yang dikirimkan ke SAP</td>
                    </tr>
                    <tr>
                        <td class="param-name">TOKEN_ONLY</td>
                        <td>
                            <div class="param-val">
                                <span>(Kosongkan / De-select 'X')</span>
                            </div>
                        </td>
                        <td>Biarkan kosong agar ABAP melanjut ke API utama</td>
                    </tr>
                </tbody>
            </table>

            <div style="margin-top: 24px; background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.2); padding: 16px; border-radius: var(--radius-md);">
                <h4 style="color: var(--accent-cyan); font-size: 14px; margin-bottom: 8px;">💡 Tips Debugging ABAP:</h4>
                <ul style="font-size: 13px; color: var(--text-secondary); margin-left: 20px; line-height: 1.8;">
                    <li>Setelah klik F8 di SAP, buka tab <strong>🛰️ Live Request Inspector</strong> untuk melihat apakah SAP benar-benar mengirimkan request ke local PHP server kamu.</li>
                    <li>Inspector akan menampilkan header otentikasi <code>Basic ...</code> dan <code>Authorization: Bearer ...</code> yang dikirim oleh ABAP.</li>
                    <li>Nilai <strong>RES_JSON</strong> di SAP akan berisi data balasan dari <code>api.php</code> dengan HTTP Code <strong>201 Created</strong>.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="toast" class="toast">Berhasil disalin ke clipboard!</div>

<script>
    // Tab switching logic
    function switchTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        event.currentTarget.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');

        if (tabId === 'inspector') {
            fetchLogs();
        }
    }

    // JSON Presets
    const presets = {
        1: { "nama": "Budi", "pesan": "Testing dari SAP" },
        2: { "material_code": "MAT-1002", "qty": 50, "plant": "1000", "timestamp": new Date().toISOString().split('T')[0] },
        3: { "vendor_id": "VEND_99", "action": "CREATE_PO", "items": [{ "id": 1, "desc": "Laptop", "price": 15000000 }] }
    };

    function setPreset(num) {
        document.getElementById('req_json').value = JSON.stringify(presets[num], null, 2);
    }

    // Toast Popup
    function showToast(msg) {
        const toast = document.getElementById('toast');
        toast.innerText = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2500);
    }

    function copyText(elementId) {
        const text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            showToast('Copied: ' + text);
        });
    }

    // Step 1: Generate Token
    async function generateToken() {
        const url = document.getElementById('token_url').value;
        const clientId = document.getElementById('client_id').value;
        const clientSecret = document.getElementById('client_secret').value;
        const grantType = document.getElementById('grant_type').value;

        const outputEl = document.getElementById('token-output');
        const statusEl = document.getElementById('token-status');
        const timeEl = document.getElementById('token-time');

        outputEl.innerText = "Mengirim permintaan ke token.php...";
        statusEl.className = 'status-badge idle';
        statusEl.innerText = 'Status: Sending...';

        const startTime = performance.now();

        try {
            const authHeader = 'Basic ' + btoa(clientId + ':' + clientSecret);
            const formData = new URLSearchParams();
            formData.append('grant_type', grantType);

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Authorization': authHeader,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formData
            });

            const duration = Math.round(performance.now() - startTime);
            timeEl.innerText = duration + ' ms';

            const data = await res.json();
            outputEl.innerText = JSON.stringify(data, null, 2);

            statusEl.innerText = `HTTP ${res.status} ${res.ok ? 'OK' : 'Error'}`;
            statusEl.className = `status-badge s${res.status}`;

            if (res.ok && data.access_token) {
                document.getElementById('bearer_token').value = `${data.token_type || 'Bearer'} ${data.access_token}`;
                showToast('Token Berhasil Dibuat & Otomatis Disimpan!');
            }
        } catch (err) {
            const duration = Math.round(performance.now() - startTime);
            timeEl.innerText = duration + ' ms';
            statusEl.innerText = 'HTTP Connection Failed';
            statusEl.className = 'status-badge s500';
            outputEl.innerText = '// Error koneksi: ' + err.message + '\n\nPastikan Laragon/XAMPP aktif dan URL benar.';
        }
    }

    // Step 2: Send Main API Request
    async function sendApiRequest() {
        const url = document.getElementById('api_url').value;
        const bearerToken = document.getElementById('bearer_token').value;
        const jsonText = document.getElementById('req_json').value;

        const outputEl = document.getElementById('api-output');
        const statusEl = document.getElementById('api-status');
        const timeEl = document.getElementById('api-time');

        // Validate JSON
        try {
            JSON.parse(jsonText);
        } catch (e) {
            alert('Format REQ_JSON tidak valid: ' + e.message);
            return;
        }

        outputEl.innerText = "Mengirim REQ_JSON ke api.php...";
        statusEl.className = 'status-badge idle';
        statusEl.innerText = 'Status: Sending...';

        const startTime = performance.now();

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Authorization': bearerToken,
                    'Content-Type': 'application/json'
                },
                body: jsonText
            });

            const duration = Math.round(performance.now() - startTime);
            timeEl.innerText = duration + ' ms';

            const data = await res.json();
            outputEl.innerText = JSON.stringify(data, null, 2);

            statusEl.innerText = `HTTP ${res.status} ${res.status === 201 ? 'Created' : (res.ok ? 'OK' : 'Error')}`;
            statusEl.className = `status-badge s${res.status}`;

            if (res.ok) {
                showToast('REQ_JSON Berhasil Diterima oleh api.php!');
            }
        } catch (err) {
            const duration = Math.round(performance.now() - startTime);
            timeEl.innerText = duration + ' ms';
            statusEl.innerText = 'HTTP Connection Failed';
            statusEl.className = 'status-badge s500';
            outputEl.innerText = '// Error koneksi: ' + err.message;
        }
    }

    // Inspector Logs Poller
    let logTimer = null;

    function toggleAutoRefresh(cb) {
        if (cb.checked) {
            startLogPolling();
        } else {
            clearInterval(logTimer);
        }
    }

    function startLogPolling() {
        clearInterval(logTimer);
        logTimer = setInterval(() => {
            if (document.getElementById('tab-inspector').classList.contains('active')) {
                fetchLogs();
            }
        }, 2000);
    }

    async function fetchLogs() {
        try {
            const res = await fetch('logs_api.php');
            const logs = await res.json();
            renderLogs(logs);
        } catch (e) {
            console.error('Gagal mengambil logs:', e);
        }
    }

    async function clearLogs() {
        if (confirm('Hapus semua catatan log request?')) {
            await fetch('logs_api.php?action=clear');
            fetchLogs();
            showToast('Log berhasil dibersihkan.');
        }
    }

    function renderLogs(logs) {
        const container = document.getElementById('log-list');
        if (!logs || logs.length === 0) {
            container.innerHTML = `<div class="empty-logs">Belum ada request yang masuk dari ABAP atau Browser UI.</div>`;
            return;
        }

        container.innerHTML = logs.map(item => {
            const statusClass = `s${item.status}`;
            return `
                <div class="log-item">
                    <div class="log-header">
                        <div class="log-title">
                            <span class="method-tag">${item.method}</span>
                            <span>${item.endpoint}</span>
                            <span class="status-badge ${statusClass}">HTTP ${item.status}</span>
                        </div>
                        <span style="font-size: 12px; color: var(--text-muted); font-family: var(--font-mono);">${item.time}</span>
                    </div>

                    <div class="log-meta">
                        <span>🌐 Client IP: ${item.remote_ip}</span>
                        <span>🖥️ User-Agent: ${item.user_agent}</span>
                    </div>

                    <div class="log-details">
                        <div>
                            <strong style="color: var(--accent-cyan); display:block; margin-bottom:4px;">📥 INPUT DATA (dari ABAP/Browser):</strong>
                            <pre style="max-height: 120px;">${JSON.stringify(item.input, null, 2)}</pre>
                        </div>
                        <div>
                            <strong style="color: var(--accent-emerald); display:block; margin-bottom:4px;">📤 OUTPUT RESPONSE (dikirim balik):</strong>
                            <pre style="max-height: 120px;">${JSON.stringify(item.output, null, 2)}</pre>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Init
    startLogPolling();
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAP ABAP REST API Tester & Inspector</title>
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
            min-height: 110px;
            resize: vertical;
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
            max-height: 260px;
            overflow-y: auto;
        }

        /* ABAP Cheat Sheet Table */
        .param-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .param-table th, .param-table td {
            padding: 10px 14px;
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
            white-space: nowrap;
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
            flex-wrap: wrap;
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

        .endpoint-badge {
            font-size: 11px;
            font-family: var(--font-mono);
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
        .endpoint-badge.no-header {
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent-emerald);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .endpoint-badge.with-header {
            background: rgba(59, 130, 246, 0.15);
            color: var(--accent-cyan);
            border: 1px solid rgba(59, 130, 246, 0.3);
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
                <p>Pengujian Terpisah: Versi Tanpa Header vs Versi Wajib Header Token</p>
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
        <button class="tab-btn" onclick="switchTab('abap')">📋 SAP GUI SE37 & ABAP Guide</button>
    </div>

    <!-- TAB 1: API TESTER -->
    <div id="tab-tester" class="tab-content active">
        <div class="grid-2">
            <!-- PANEL 1: TANPA HEADER -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="step-num" style="background: rgba(16, 185, 129, 0.2); color: var(--accent-emerald);">A</span>
                        <span>API VERSI TANPA HEADER (api_no_header.php)</span>
                    </div>
                    <span class="endpoint-badge no-header">Bypass Token</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Target URL (Bisa langsung dipanggil tanpa token)</label>
                    <input type="text" id="url_no_header" class="form-control" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>api_no_header.php">
                </div>

                <div class="form-group">
                    <label class="form-label">REQ_JSON Payload</label>
                    <textarea id="json_no_header" class="form-control">{
  "nama": "Budi",
  "pesan": "Testing API Tanpa Header Token"
}</textarea>
                </div>

                <button class="btn btn-emerald btn-block" onclick="sendNoHeaderRequest()">
                    🚀 Kirim REQ_JSON ke api_no_header.php
                </button>

                <div class="response-box">
                    <div class="response-header">
                        <span id="no-header-status" class="status-badge idle">Status: Idle</span>
                        <span id="no-header-time" class="time-taken">0 ms</span>
                    </div>
                    <pre id="no-header-output">// Respon RES_JSON api_no_header.php akan tampil di sini...</pre>
                </div>
            </div>

            <!-- PANEL 2: WAJIB HEADER -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="step-num" style="background: rgba(6, 182, 212, 0.2); color: var(--accent-cyan);">B</span>
                        <span>API VERSI WAJIB HEADER TOKEN (api_with_header.php)</span>
                    </div>
                    <span class="endpoint-badge with-header">Wajib Token</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Target URL (Wajib bawa Authorization Bearer)</label>
                    <input type="text" id="url_with_header" class="form-control" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>api_with_header.php">
                </div>

                <div class="form-group">
                    <label class="form-label">Authorization Header Value</label>
                    <input type="text" id="token_input_with_header" class="form-control" value="Bearer token_rahasia_12345">
                </div>

                <div class="form-group">
                    <label class="form-label">REQ_JSON Payload</label>
                    <textarea id="json_with_header" class="form-control">{
  "nama": "Budi",
  "pesan": "Testing API Wajib Header Token"
}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <button class="btn btn-block" onclick="sendWithHeaderRequest(true)">
                        🔒 Kirim DENGAN Token
                    </button>
                    <button class="btn btn-secondary btn-block" onclick="sendWithHeaderRequest(false)">
                        ⚠️ Kirim TANPA Token
                    </button>
                </div>

                <div class="response-box">
                    <div class="response-header">
                        <span id="with-header-status" class="status-badge idle">Status: Idle</span>
                        <span id="with-header-time" class="time-taken">0 ms</span>
                    </div>
                    <pre id="with-header-output">// Respon RES_JSON api_with_header.php akan tampil di sini...</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: LIVE REQUEST INSPECTOR -->
    <div id="tab-inspector" class="tab-content">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <span>🛰️ Live Request Inspector (Memantau HTTP Request yang Masuk ke PHP)</span>
                </div>
                <div style="display:flex; gap: 8px;">
                    <button class="btn btn-secondary btn-sm" onclick="fetchLogs()">🔄 Refresh Manual</button>
                    <button class="btn btn-secondary btn-sm" onclick="clearLogs()">🗑️ Hapus Log</button>
                </div>
            </div>

            <div id="log-list" class="log-list">
                <div class="empty-logs">Mengambil data log terbaru...</div>
            </div>
        </div>
    </div>

    <!-- TAB 3: ABAP CODE & PARAMETER GUIDE -->
    <div id="tab-abap" class="tab-content">

        <!-- LOKASI UBAH CLIENT ID & SECRET -->
        <div class="card" style="margin-bottom: 24px; border-color: rgba(99, 102, 241, 0.4); background: rgba(99, 102, 241, 0.04);">
            <div class="card-header">
                <div class="card-title">
                    <span style="color: var(--accent-indigo);">🔑 LOKASI MERUBAH CLIENT ID & SECRET DI PHP</span>
                </div>
            </div>
            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 10px;">
                Jika kamu ingin mengganti nilai <strong>TOKEN_CLIENTID</strong> atau <strong>TOKEN_SECRET</strong>, buka file <strong>token.php</strong> pada baris 19-20:
            </p>
            <pre style="background: #060911; color: #a5f3fc; border: 1px solid var(--border);">$valid_id = "sap_client";       // Isi sesuai TOKEN_CLIENTID di SAP GUI
$valid_secret = "sap_luar";     // Isi sesuai TOKEN_SECRET di SAP GUI</pre>
        </div>

        <!-- SE37 PARAMETER TABLE -->
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header">
                <div class="card-title">
                    <span>🖥️ Pengisian Import Parameters di SE37 SAP GUI</span>
                </div>
            </div>
            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 16px;">
                Saat kamu menjalankan <strong>Test/Execute (F8)</strong> pada Function Module di SAP GUI, isikan parameter seperti berikut:
            </p>

            <h4 style="color: var(--accent-cyan); font-size: 14px; margin-bottom: 10px;">Opsi 1: Testing DENGAN Token (api_with_header.php)</h4>
            <table class="param-table">
                <thead>
                    <tr>
                        <th>Import Parameter SAP</th>
                        <th>Value yang Diisi di SE37</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="param-name">TOKEN_ONLY</td>
                        <td><div class="param-val"><span>(Kosongkan / Jangan Centang)</span></div></td>
                        <td>Biarkan kosong</td>
                    </tr>
                    <tr>
                        <td class="param-name">TOKEN_URL</td>
                        <td>
                            <div class="param-val">
                                <span id="se37_token_url"><?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>token.php</span>
                                <button class="copy-btn" onclick="copyText('se37_token_url')">Copy</button>
                            </div>
                        </td>
                        <td>URL Token Generator</td>
                    </tr>
                    <tr>
                        <td class="param-name">TOKEN_CLIENTID</td>
                        <td>
                            <div class="param-val">
                                <span id="se37_client_id">sap_client</span>
                                <button class="copy-btn" onclick="copyText('se37_client_id')">Copy</button>
                            </div>
                        </td>
                        <td>Must match $valid_id in PHP</td>
                    </tr>
                    <tr>
                        <td class="param-name">TOKEN_SECRET</td>
                        <td>
                            <div class="param-val">
                                <span id="se37_secret">sap_luar</span>
                                <button class="copy-btn" onclick="copyText('se37_secret')">Copy</button>
                            </div>
                        </td>
                        <td>Must match $valid_secret in PHP</td>
                    </tr>
                    <tr>
                        <td class="param-name">URL</td>
                        <td>
                            <div class="param-val">
                                <span id="se37_url_with_header"><?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>api_with_header.php</span>
                                <button class="copy-btn" onclick="copyText('se37_url_with_header')">Copy</button>
                            </div>
                        </td>
                        <td>URL Utama API Wajib Header Token</td>
                    </tr>
                    <tr>
                        <td class="param-name">REQ_JSON</td>
                        <td>
                            <div class="param-val">
                                <span id="se37_req_json">{"nama": "Budi", "pesan": "Testing dengan Token"}</span>
                                <button class="copy-btn" onclick="copyText('se37_req_json')">Copy</button>
                            </div>
                        </td>
                        <td>Payload JSON Transaksi</td>
                    </tr>
                </tbody>
            </table>

            <h4 style="color: var(--accent-emerald); font-size: 14px; margin-bottom: 10px; margin-top: 20px;">Opsi 2: Testing TANPA Token (api_no_header.php)</h4>
            <table class="param-table">
                <thead>
                    <tr>
                        <th>Import Parameter SAP</th>
                        <th>Value yang Diisi di SE37</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="param-name">TOKEN_URL</td>
                        <td><div class="param-val"><span>(Kosongkan)</span></div></td>
                        <td>Tidak butuh Token</td>
                    </tr>
                    <tr>
                        <td class="param-name">TOKEN_CLIENTID</td>
                        <td><div class="param-val"><span>(Kosongkan)</span></div></td>
                        <td>Tidak butuh Auth</td>
                    </tr>
                    <tr>
                        <td class="param-name">TOKEN_SECRET</td>
                        <td><div class="param-val"><span>(Kosongkan)</span></div></td>
                        <td>Tidak butuh Auth</td>
                    </tr>
                    <tr>
                        <td class="param-name">URL</td>
                        <td>
                            <div class="param-val">
                                <span id="se37_url_no_header"><?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>api_no_header.php</span>
                                <button class="copy-btn" onclick="copyText('se37_url_no_header')">Copy</button>
                            </div>
                        </td>
                        <td>URL API Tanpa Token</td>
                    </tr>
                    <tr>
                        <td class="param-name">REQ_JSON</td>
                        <td>
                            <div class="param-val">
                                <span id="se37_req_json_no">{"nama": "Budi", "pesan": "Testing tanpa token"}</span>
                                <button class="copy-btn" onclick="copyText('se37_req_json_no')">Copy</button>
                            </div>
                        </td>
                        <td>Payload JSON Transaksi</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ABAP CODE SNIPPETS -->
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header">
                <div class="card-title">
                    <span style="color: var(--accent-emerald);">🟢 VERSI 1: Kodingan ABAP TANPA Header Token (`api_no_header.php`)</span>
                </div>
            </div>
            <pre style="background: #060911; color: #a5f3fc; border: 1px solid var(--border);">
" ====================================================
" KODINGAN ABAP UNTUK VERSI TANPA TOKEN (Super Simpel)
" ====================================================
DATA: lo_http_client TYPE REF TO if_http_client,
      lv_response    TYPE string.

cl_http_client=>create_by_url(
  EXPORTING url = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>api_no_header.php'
  IMPORTING client = lo_http_client
).

lo_http_client->request->set_method( 'POST' ).
lo_http_client->request->set_header_field( name = 'Content-Type' value = 'application/json' ).
lo_http_client->request->set_cdata( '{"nama": "Budi", "pesan": "Tes Tanpa Header"}' ).

lo_http_client->send( ).
lo_http_client->receive( ).
lv_response = lo_http_client->response->get_cdata( ).
" Result: Respon status 201 Created dari api_no_header.php
</pre>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <span style="color: var(--accent-cyan);">🔒 VERSI 2: Kodingan ABAP DENGAN Header Token (`api_with_header.php`)</span>
                </div>
            </div>
            <pre style="background: #060911; color: #a5f3fc; border: 1px solid var(--border);">
" ====================================================
" KODINGAN ABAP UNTUK VERSI DENGAN HEADER TOKEN
" ====================================================
DATA: lo_client   TYPE REF TO if_http_client,
      lv_token    TYPE string,
      lv_response TYPE string.

" 1. Minta Token ke token.php
cl_http_client=>create_by_url(
  EXPORTING url = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>token.php'
  IMPORTING client = lo_client
).
lo_client->request->set_method( 'POST' ).
lo_client->request->set_authorization( auth_type = if_http_request=>co_request_has_authorization username = 'sap_client' password = 'sap_luar' ).
lo_client->request->set_header_field( name = 'Content-Type' value = 'application/x-www-form-urlencoded' ).
lo_client->request->set_form_field( name = 'grant_type' value = 'client_credentials' ).
lo_client->send( ).
lo_client->receive( ).

" (Dapatkan token: token_rahasia_12345)
lv_token = 'token_rahasia_12345'.

" 2. Kirim ke api_with_header.php DENGAN HEADER Authorization Bearer
cl_http_client=>create_by_url(
  EXPORTING url = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'); ?>api_with_header.php'
  IMPORTING client = lo_client
).
lo_client->request->set_method( 'POST' ).

" ⚠️ INI CARA SET HEADER AUTHORIZATION BEARER DI SAP ABAP:
lo_client->request->set_header_field(
  EXPORTING
    name  = 'Authorization'
    value = 'Bearer ' && lv_token
).

lo_client->request->set_header_field( name = 'Content-Type' value = 'application/json' ).
lo_client->request->set_cdata( '{"nama": "Budi", "pesan": "Tes Wajib Token"}' ).

lo_client->send( ).
lo_client->receive( ).
lv_response = lo_client->response->get_cdata( ).
</pre>
        </div>
    </div>
</div>

<div id="toast" class="toast">Berhasil disalin ke clipboard!</div>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        event.currentTarget.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');

        if (tabId === 'inspector') {
            fetchLogs();
        }
    }

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

    // Tester Versi Tanpa Header
    async function sendNoHeaderRequest() {
        const url = document.getElementById('url_no_header').value;
        const jsonText = document.getElementById('json_no_header').value;
        const outputEl = document.getElementById('no-header-output');
        const statusEl = document.getElementById('no-header-status');
        const timeEl = document.getElementById('no-header-time');

        outputEl.innerText = "Mengirim ke api_no_header.php...";
        const startTime = performance.now();

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: jsonText
            });
            const duration = Math.round(performance.now() - startTime);
            timeEl.innerText = duration + ' ms';
            const data = await res.json();
            outputEl.innerText = JSON.stringify(data, null, 2);
            statusEl.innerText = `HTTP ${res.status} Created`;
            statusEl.className = 'status-badge s201';
            showToast('Berhasil dikirim ke api_no_header.php!');
            fetchLogs();
        } catch (err) {
            outputEl.innerText = '// Error: ' + err.message;
        }
    }

    // Tester Versi Wajib Header
    async function sendWithHeaderRequest(withToken = true) {
        const url = document.getElementById('url_with_header').value;
        const bearerToken = document.getElementById('token_input_with_header').value;
        const jsonText = document.getElementById('json_with_header').value;
        const outputEl = document.getElementById('with-header-output');
        const statusEl = document.getElementById('with-header-status');
        const timeEl = document.getElementById('with-header-time');

        outputEl.innerText = "Mengirim ke api_with_header.php...";
        const startTime = performance.now();

        try {
            const headersObj = { 'Content-Type': 'application/json' };
            if (withToken && bearerToken.trim() !== '') {
                headersObj['Authorization'] = bearerToken;
            }

            const res = await fetch(url, {
                method: 'POST',
                headers: headersObj,
                body: jsonText
            });
            const duration = Math.round(performance.now() - startTime);
            timeEl.innerText = duration + ' ms';
            const data = await res.json();
            outputEl.innerText = JSON.stringify(data, null, 2);
            statusEl.innerText = `HTTP ${res.status} ${res.ok ? 'Created' : 'Unauthorized'}`;
            statusEl.className = `status-badge s${res.status}`;
            showToast(res.ok ? 'Berhasil dikirim DENGAN Token!' : 'Gagal (401 Unauthorized - Tanpa Token)!');
            fetchLogs();
        } catch (err) {
            outputEl.innerText = '// Error: ' + err.message;
        }
    }

    // Inspector Logs Poller
    let logTimer = null;
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
            const res = await fetch('logs_api.php?t=' + Date.now(), { cache: 'no-store' });
            const logs = await res.json();
            renderLogs(logs);
        } catch (e) {
            console.error('Gagal mengambil logs:', e);
        }
    }

    async function clearLogs() {
        if (confirm('Hapus semua catatan log request?')) {
            try {
                await fetch('logs_api.php?action=clear&t=' + Date.now(), { method: 'POST', cache: 'no-store' });
                renderLogs([]);
                showToast('Log berhasil dibersihkan!');
            } catch (err) {
                alert('Gagal menghapus log: ' + err.message);
            }
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

    startLogPolling();
</script>

</body>
</html>

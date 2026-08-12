# 🚀 SAP ABAP REST API Tester & Mock Server

Dokumentasi sederhana untuk melakukan testing **ABAP Function Module REST API (OAuth2 Client Credentials & JSON Payload)** menggunakan server PHP lokal (Laragon / XAMPP / Hosting).

---

## 📌 Fitur Utama

1. **OAuth2 Token Mock Server (`token.php`)**
   * Otentikasi **Basic Auth** (`Client ID` & `Client Secret`).
   * Validasi `grant_type=client_credentials`.
   * Menghasilkan token bearer: `token_rahasia_12345`.

2. **Main API Receiver (`api.php`)**
   * Validasi **Bearer Token** pada header `Authorization`.
   * Menerima payload `REQ_JSON` dari SAP ABAP.
   * Mengembalikan status **HTTP 201 Created** dan data respon `RES_JSON`.

3. **Interactive Web Dashboard & Live Inspector (`index.php`)**
   * **API Tester:** Menguji endpoint `token.php` dan `api.php` langsung dari web browser.
   * **Live Request Inspector:** Pemantau request HTTP real-time untuk melihat kiriman masuk dari SAP ABAP Function Module (Headers, Payload, Client IP, User-Agent).
   * **SAP Parameter Helper:** Menyediakan tabel nilai parameter dengan tombol *1-Click Copy*.

---

## 📁 Struktur Berkas

```text
api_json_recheck/
├── token.php        # Endpoint generator OAuth2 Token
├── api.php          # Endpoint utama pemroses REQ_JSON
├── index.php        # Web Dashboard Dashboard UI & Live Inspector
├── logs_api.php     # Endpoint AJAX pendukung inspector log
├── log_helper.php   # Helper logger & request header parser
└── README.md        # Dokumentasi penggunaan
```

---

## ⚙️ Cara Penggunaan di SAP ABAP (SE37)

Saat melakukan **Test / Execute (F8)** pada Function Module kamu di SAP GUI, isikan parameter sebagai berikut:

| Parameter ABAP | Nilai Input | Keterangan |
| :--- | :--- | :--- |
| `TOKEN_URL` | `http://localhost/SWF_Basic_v0.4/api_json_recheck/token.php` | URL generator Token |
| `TOKEN_CLIENTID` | `sap_client` | Client ID Basic Auth |
| `TOKEN_SECRET` | `sap_luar` | Client Secret Basic Auth |
| `URL` | `http://localhost/SWF_Basic_v0.4/api_json_recheck/api.php` | URL Utama API |
| `REQ_JSON` | `{"nama": "Budi", "pesan": "Testing dari SAP"}` | Data JSON yang dikirimkan |
| `TOKEN_ONLY` | *(Kosongkan)* | Kosongkan agar lanjut ke API Utama |

---

## 🧪 Menguji via Web UI Browser

1. Pastikan server lokal (Laragon / XAMPP) sudah berjalan.
2. Buka URL di browser:
   ```text
   http://localhost/SWF_Basic_v0.4/api_json_recheck/
   ```
3. Pilih tab:
   * **⚡ API Tester:** Klik `🔑 Generate Access Token`, lalu klik `🚀 Kirim REQ_JSON ke API`.
   * **🛰️ Live Request Inspector:** Lihat log masuk saat SAP ABAP mengeksekusi Function Module.

---

## 🛡️ Contoh Respon JSON

### 1. Respon dari `token.php` (HTTP 200 OK)
```json
{
  "access_token": "token_rahasia_12345",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

### 2. Respon dari `api.php` (HTTP 201 Created)
```json
{
  "status": "Sukses",
  "pesan": "Mantap bro, data JSON berhasil diterima di PHP!",
  "data_kamu": {
    "nama": "Budi",
    "pesan": "Testing dari SAP"
  }
}
```

---

## 💡 Catatan & Troubleshooting

* **Apache / Nginx Auth Header:** Berkas `token.php` & `api.php` telah dilengkapi *fallback parser* untuk mengantisipasi jika webserver kamu memotong header `Authorization` / `PHP_AUTH_USER`.
* **CORS Support:** Sudah dilengkapi header `Access-Control-Allow-Origin: *` sehingga aman diakses dari browser maupun HTTP Client SAP.

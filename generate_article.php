<?php

declare(strict_types=1);

ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

$config = include __DIR__ . '/config.local.php';
$apiKey = trim($config['GEMINI_API_KEY'] ?? '');
$model = "gemini-2.5-flash";

function respond(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function fail(string $userMessage, int $status = 400, ?string $debug = null): void
{
    if ($debug) {
        // Log untuk developer (tidak ditampilkan ke user)
        error_log('[generate_article] ' . $debug);
    }
    respond(['ok' => false, 'message' => $userMessage], $status);
}

function ok(array $payload): void
{
    respond(['ok' => true] + $payload, 200);
}

// --- Validasi basic request ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail('Metode tidak didukung.', 405);
}

$raw = file_get_contents('php://input');
if ($raw === false || trim($raw) === '') {
    fail('Data yang dikirim kosong. Silakan coba lagi.', 400);
}

$data = json_decode($raw, true);
if (!is_array($data)) {
    fail('Format data tidak valid. Silakan refresh halaman dan coba lagi.', 400, 'Invalid JSON input: ' . $raw);
}

$type = $data['type'] ?? 'ide';
if (!in_array($type, ['ide', 'summary'], true)) {
    fail('Permintaan tidak dikenal. Silakan coba lagi.', 400, 'Unknown type: ' . print_r($type, true));
}

// --- Validasi API key ---
if ($apiKey === '' || $apiKey === 'GANTI_DENGAN_API_KEY_GEMINI_KAMU') {
    fail('Fitur AI sedang tidak tersedia. Coba lagi nanti ya.', 503, 'Missing/placeholder API key');
}

// --- Buat prompt ---
$prompt = '';

if ($type === 'ide') {
    $topic = trim($data['topic'] ?? '');
    if ($topic === '') {
        fail('Topik belum diisi. Silakan isi topik dulu ya.', 400);
    }

    $prompt =
        "Buatkan 5 ide artikel tentang topik: '$topic'. " .
        "Output WAJIB JSON valid array of objects. " .
        "Format: [{\"judul\": \"Judul 1\", \"isi\": \"Konten...\"}] " .
        "Pada isi, jelaskan detail dan gaya penulisan seperti artikel web.";
} else { // summary
    $content = trim($data['content'] ?? '');
    if ($content === '') {
        fail('Isi artikel masih kosong. Silakan isi dulu ya.', 400);
    }

    // Batasi input biar nggak kepanjangan
    $contentCut = function_exists('mb_substr')
        ? mb_substr($content, 0, 1000, 'UTF-8')
        : substr($content, 0, 1000);

    $prompt =
        "Buatkan ringkasan singkat untuk deskripsi thumbnail dari artikel berikut. " .
        "Maksimal 2-3 kalimat. Bahasa Indonesia yang menarik, ringkas dan informatif. " .
        "Output langsung teks ringkasannya saja tanpa format JSON.\n\n" .
        "Artikel: " . $contentCut . "...";
}

// --- Request ke Gemini ---
$url = "https://generativelanguage.googleapis.com/v1beta/models/" . $model . ":generateContent?key=" . $apiKey;

$payload = [
    "contents" => [
        [
            "parts" => [
                ["text" => $prompt]
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,      // fix IPv6
    CURLOPT_SSL_VERIFYPEER => false,             // ONLY localhost; production sebaiknya true
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 30,
]);

$response = curl_exec($ch);
$curlErrNo = curl_errno($ch);
$curlErr   = curl_error($ch);
$httpCode  = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// --- Error koneksi (transport) ---
if ($curlErrNo) {
    fail(
        'Tidak bisa terhubung ke layanan AI. Coba lagi beberapa saat ya.',
        502,
        "cURL error #$curlErrNo: $curlErr"
    );
}

// --- Error dari API (non-200) ---
if ($httpCode !== 200) {
    $decodedErr = json_decode((string)$response, true);
    $apiMsg = $decodedErr['error']['message'] ?? '';

    // Mapping pesan jadi ramah user
    if ($httpCode === 401 || $httpCode === 403) {
        fail('Fitur AI sedang tidak bisa digunakan. (Konfigurasi server)', 503, "HTTP $httpCode: $apiMsg");
    } elseif ($httpCode === 429) {
        fail('AI sedang ramai. Coba lagi dalam 1-2 menit ya.', 503, "HTTP 429: $apiMsg");
    } elseif ($httpCode >= 500) {
        fail('Layanan AI sedang gangguan. Coba lagi nanti ya.', 503, "HTTP $httpCode: $apiMsg");
    } else {
        fail('Permintaan ke AI gagal diproses. Coba lagi ya.', 502, "HTTP $httpCode: $apiMsg; raw=" . (string)$response);
    }
}

// --- Sukses: ambil text output ---
$decoded = json_decode((string)$response, true);
$textResult = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? '';

if (trim($textResult) === '') {
    fail('AI tidak mengembalikan jawaban. Silakan coba lagi.', 502, 'Empty AI text. Raw=' . (string)$response);
}

$cleanText = trim(str_replace(['```json', '```'], '', $textResult));

// --- Output konsisten dan aman ---
if ($type === 'summary') {
    ok(['summary' => $cleanText]);
}

// mode ide: pastikan JSON valid array
$items = json_decode($cleanText, true);

// fallback: coba ambil bagian JSON array jika AI nambah teks
if (!is_array($items) && preg_match('/\[\s*\{.*\}\s*\]/s', $cleanText, $m)) {
    $items = json_decode($m[0], true);
}

if (!is_array($items)) {
    fail(
        'Maaf, format jawaban AI tidak bisa diproses. Silakan klik “Buat 5 Opsi” lagi.',
        502,
        'Invalid AI JSON ide. cleanText=' . $cleanText
    );
}

ok(['items' => $items]);

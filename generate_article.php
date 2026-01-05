<?php
error_reporting(0);
header('Content-Type: application/json');

$apiKey = "AIzaSyA0MZzLXkCGlhiUom1kzdv-_t1QGDTqGYA";
$model = "gemini-2.5-flash";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputJSON = file_get_contents('php://input');
    $data = json_decode($inputJSON, true);

    // Cek jenis permintaan: 'ide' atau 'summary'
    $type = $data['type'] ?? 'ide';

    if ($apiKey == "GANTI_DENGAN_API_KEY_GEMINI_KAMU") {
        echo json_encode(['error' => 'API Key belum diisi!']);
        exit;
    }

    $prompt = "";

    // LOGIKA 1: Generate Ide Judul
    if ($type == 'ide') {
        $topic = $data['topic'] ?? '';
        if (empty($topic)) {
            echo json_encode(['error' => 'Topik kosong']);
            exit;
        }

        $prompt = "Buatkan 5 ide artikel tentang topik: '$topic'. " .
            "Output WAJIB JSON valid array of objects. " .
            "Format: [{\"judul\": \"Judul 1\", \"isi\": \"Konten...\"}]"
            . "Pada isi, tolong buat agar menjelaskan detail tentang dari topik yang diberikan, penyampaiannya mirip dengan penjelasan di web web artikel yang ada"
            ;
    }
    // LOGIKA 2: Generate Summary
    else if ($type == 'summary') {
        $content = $data['content'] ?? '';
        if (empty($content)) {
            echo json_encode(['error' => 'Isi artikel kosong']);
            exit;
        }

        $prompt = "Buatkan ringkasan singkat untuk deskripsi thumbnail dari artikel berikut. " .
            "Maksimal 2-3 kalimat. Bahasa Indonesia yang menarik dan informatif. " .
            "Artikel: " . substr($content, 0, 1000) . "... " . // Batasi input biar ga kepanjangan
            "Output langsung teks ringkasannya saja tanpa format JSON.";
    }

    $url = "https://generativelanguage.googleapis.com/v1beta/models/" . $model . ":generateContent?key=" . trim($apiKey);

    $payload = ["contents" => [["parts" => [["text" => $prompt]]]]];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); // Fix IPv6
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Fix SSL Localhost

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo json_encode(['error' => 'Koneksi Gagal: ' . curl_error($ch)]);
    } elseif ($httpCode !== 200) {
        $decoded = json_decode($response, true);
        echo json_encode(['error' => "API Error ($httpCode): " . ($decoded['error']['message'] ?? '')]);
    } else {
        $decoded = json_decode($response, true);
        $textResult = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Bersihkan hasil
        $cleanText = str_replace(['```json', '```'], '', $textResult);

        // Jika mode summary, kirim sebagai object text biasa
        if ($type == 'summary') {
            echo json_encode(['summary' => trim($cleanText)]);
        } else {
            echo $cleanText; // Mode ide tetap return JSON array
        }
    }
    curl_close($ch);
}

<?php

header("Content-Type: application/json; charset=utf-8");

require_once "config.php";

/* =========================
   CEK REQUEST
========================= */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "success" => false,
        "message" => "Request harus menggunakan POST."
    ]);

    exit;
}

/* =========================
   AMBIL DATA
========================= */

$question = trim($_POST["question"] ?? "");
$answer = trim($_POST["answer"] ?? "");
$correctAnswer = trim($_POST["correct_answer"] ?? "");

/* =========================
   VALIDASI
========================= */

if (
    $question === "" ||
    $answer === "" ||
    $correctAnswer === ""
) {

    echo json_encode([
        "success" => false,
        "message" => "Data soal belum lengkap."
    ]);

    exit;
}

/* =========================
   CEK API KEY
========================= */

if (
    !defined("AI_API_KEY") ||
    trim(AI_API_KEY) === ""
) {

    echo json_encode([
        "success" => false,
        "message" => "API Key belum dimasukkan ke file .env (salin dari .env.example lalu isi key kamu)."
    ]);

    exit;
}

/* =========================
   PROMPT AI
========================= */

$prompt = <<<PROMPT

Kamu adalah AI Tutor pada game edukasi bernama EduQuest AI.

Tugas kamu membantu siswa memahami jawaban soal.

SOAL:
$question

JAWABAN PEMAIN:
$answer

JAWABAN YANG BENAR:
$correctAnswer

Jika jawaban pemain benar:

✅ Jawaban Benar

Kenapa benar:
Jelaskan secara sederhana.

Penjelasan:
Jelaskan konsep dari soal.

Tips:
Berikan satu tips belajar.

Jika jawaban pemain salah:

❌ Jawaban Salah

Jawaban yang benar:
$correctAnswer

Kenapa salah:
Jelaskan mengapa jawaban pemain tidak tepat.

Penjelasan:
Jelaskan konsep yang benar.

Tips:
Berikan satu tips belajar.

Gunakan bahasa Indonesia.
Maksimal 120 kata.
Jangan terlalu panjang.

PROMPT;

/* =========================
   DATA API
========================= */

$data = [
    "model" => AI_MODEL,
    "messages" => [
        [
            "role" => "user",
            "content" => $prompt
        ]
    ],
    "max_tokens" => 800
];

$jsonData = json_encode(
    $data,
    JSON_UNESCAPED_UNICODE
);

/* =========================
   CURL
========================= */

$ch = curl_init(
    AI_API_URL
);

curl_setopt_array($ch, [

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_POST => true,

    CURLOPT_POSTFIELDS => $jsonData,

    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . trim(AI_API_KEY),
        "HTTP-Referer: http://localhost/eduquest-ai",
        "X-Title: EduQuest AI"
    ],

    CURLOPT_TIMEOUT => 60,

    CURLOPT_CONNECTTIMEOUT => 10

]);

/* =========================
   KIRIM REQUEST
========================= */

$response = curl_exec($ch);

$httpCode = curl_getinfo(
    $ch,
    CURLINFO_HTTP_CODE
);

$curlError = curl_error($ch);

curl_close($ch);

/* =========================
   CURL ERROR
========================= */

if ($response === false) {

    echo json_encode([
        "success" => false,
        "message" => "Gagal menghubungi server OpenRouter.",
        "error" => $curlError
    ]);

    exit;
}

/* =========================
   DECODE RESPONSE
========================= */

$result = json_decode(
    $response,
    true
);

/* =========================
   API ERROR
========================= */

if ($httpCode >= 400) {

    $errorMessage =
        $result["error"]["message"]
        ?? "Terjadi kesalahan API.";

    $errorCode =
        $result["error"]["code"]
        ?? "unknown";

    $errorType =
        $result["error"]["type"]
        ?? "unknown";

    echo json_encode([
        "success" => false,
        "message" => "API Error HTTP " . $httpCode,
        "error_code" => $errorCode,
        "error_type" => $errorType,
        "error" => $errorMessage
    ]);

    exit;
}

/* =========================
   ERROR DI BODY
========================= */

if (isset($result["error"])) {

    $errorMessage =
        $result["error"]["message"]
        ?? "Terjadi kesalahan dari provider AI.";

    echo json_encode([
        "success" => false,
        "message" => $errorMessage
    ]);

    exit;
}

/* =========================
   AMBIL HASIL AI
========================= */

$aiText = "";

if (
    isset($result["choices"]) &&
    is_array($result["choices"])
) {

    foreach ($result["choices"] as $choice) {

        if (
            isset($choice["message"]["content"])
        ) {

            $aiText .= $choice["message"]["content"];
        }
    }
}

/* =========================
   HASIL KOSONG
========================= */

if (trim($aiText) === "") {

    echo json_encode([
        "success" => false,
        "message" => "AI tidak memberikan penjelasan.",
        "raw_response" => $result
    ]);

    exit;
}

/* =========================
   SUKSES
========================= */

echo json_encode([
    "success" => true,
    "message" => trim($aiText)
]);

?>

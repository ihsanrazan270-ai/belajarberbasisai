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
    trim(AI_API_KEY) === "" ||
    AI_API_KEY === "MASUKKAN_API_KEY_BARU_DI_SINI"
) {

    echo json_encode([
        "success" => false,
        "message" => "API Key belum dimasukkan ke config.php"
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
    "input" => $prompt,
    "max_output_tokens" => 300
];

$jsonData = json_encode(
    $data,
    JSON_UNESCAPED_UNICODE
);

/* =========================
   CURL
========================= */

$ch = curl_init(
    "https://api.openai.com/v1/responses"
);

curl_setopt_array($ch, [

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_POST => true,

    CURLOPT_POSTFIELDS => $jsonData,

    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . trim(AI_API_KEY)
    ],

    CURLOPT_TIMEOUT => 30,

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
        "message" => "Gagal menghubungi server OpenAI.",
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
   AMBIL HASIL AI
========================= */

$aiText = "";

if (
    isset($result["output"]) &&
    is_array($result["output"])
) {

    foreach ($result["output"] as $output) {

        if (
            isset($output["content"]) &&
            is_array($output["content"])
        ) {

            foreach ($output["content"] as $content) {

                if (
                    isset($content["type"]) &&
                    $content["type"] === "output_text" &&
                    isset($content["text"])
                ) {

                    $aiText .= $content["text"];
                }
            }
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

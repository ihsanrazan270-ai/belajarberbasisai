<?php

/* ========================================
   DATABASE
======================================== */

$host = "localhost";
$username = "root";
$password = "";
$database = "eduquest_ai";


/* ========================================
   KONEKSI DATABASE
======================================== */

$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);


/* ========================================
   CEK KONEKSI
======================================== */

if ($conn->connect_error) {

    die(
        "Koneksi database gagal: " .
        $conn->connect_error
    );

}


/* ========================================
   CHARSET
======================================== */

$conn->set_charset("utf8mb4");


/* ========================================
   OPENROUTER
   (rahasia dibaca dari file .env lokal,
    jangan pernah ditulis langsung di sini)
======================================== */

$env = [];

if (is_file(__DIR__ . "/.env")) {

    $envData = parse_ini_file(
        __DIR__ . "/.env"
    );

    if (is_array($envData)) {
        $env = $envData;
    }

}

define(
    "AI_API_URL",
    $env["AI_API_URL"]
        ?? "https://openrouter.ai/api/v1/chat/completions"
);

define(
    "AI_API_KEY",
    $env["AI_API_KEY"] ?? ""
);

define(
    "AI_MODEL",
    $env["AI_MODEL"]
        ?? "nvidia/nemotron-3-ultra-550b-a55b:free"
);

?>
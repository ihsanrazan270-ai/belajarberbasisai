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
   OPENAI
======================================== */

define(
    "AI_API_KEY",
    "API_KEY_KAMU"
);

define(
    "AI_MODEL",
    "gpt-5.6-luna"
);

?>
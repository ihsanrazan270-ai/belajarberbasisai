<?php

/* ========================================
   KONEKSI DATABASE
======================================== */

require_once "config.php";


/* ========================================
   CEK DATABASE
======================================== */

if (!isset($conn) || !$conn) {
    die("Koneksi database tidak tersedia. Periksa config.php");
}


/* ========================================
   FUNGSI BUAT ROOM CODE
======================================== */

function generateRoomCode($length = 6)
{
    $characters = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";

    $code = "";

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[
            random_int(0, strlen($characters) - 1)
        ];
    }

    return $code;
}


/* ========================================
   PESAN ERROR
======================================== */

$error = "";


/* ========================================
   CREATE ROOM
======================================== */

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["action"]) &&
    $_POST["action"] === "create"
) {

    $playerName = trim(
        $_POST["player_name"] ?? ""
    );

    $character = trim(
        $_POST["character"] ?? "edu"
    );


    if ($playerName === "") {

        $error = "Nama pemain harus diisi.";

    } else {

        /* Buat kode room */

        do {

            $roomCode = generateRoomCode(6);

            $check = $conn->prepare(
                "SELECT id FROM rooms WHERE room_code = ?"
            );

            $check->bind_param(
                "s",
                $roomCode
            );

            $check->execute();

            $result = $check->get_result();

        } while ($result->num_rows > 0);


        /* Buat room */

        $stmt = $conn->prepare(
            "INSERT INTO rooms
            (room_code, status, current_question)
            VALUES (?, 'waiting', 0)"
        );

        $stmt->bind_param(
            "s",
            $roomCode
        );

        if ($stmt->execute()) {

            $roomId = $conn->insert_id;


            /* Masukkan host */

            $playerStmt = $conn->prepare(
                "INSERT INTO players
                (room_id, player_name, character_name, score, lives)
                VALUES (?, ?, ?, 0, 3)"
            );

            $playerStmt->bind_param(
                "iss",
                $roomId,
                $playerName,
                $character
            );

            if ($playerStmt->execute()) {

                $playerId =
                    $conn->insert_id;


                /* Jadikan host */

                $hostStmt = $conn->prepare(
                    "UPDATE rooms
                     SET host_player_id = ?
                     WHERE id = ?"
                );

                $hostStmt->bind_param(
                    "ii",
                    $playerId,
                    $roomId
                );

                $hostStmt->execute();


                /* Masuk lobby */

                header(
                    "Location: lobby.php?room=" .
                    urlencode($roomCode) .
                    "&player_id=" .
                    $playerId
                );

                exit;

            } else {

                $error =
                    "Gagal membuat pemain: " .
                    $playerStmt->error;

            }

        } else {

            $error =
                "Gagal membuat room: " .
                $stmt->error;

        }

    }
}


/* ========================================
   JOIN ROOM
======================================== */

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["action"]) &&
    $_POST["action"] === "join"
) {

    $playerName = trim(
        $_POST["player_name"] ?? ""
    );

    $character = trim(
        $_POST["character"] ?? "edu"
    );

    $roomCode = strtoupper(
        trim(
            $_POST["room_code"] ?? ""
        )
    );


    if ($playerName === "") {

        $error = "Nama pemain harus diisi.";

    } elseif ($roomCode === "") {

        $error = "Kode room harus diisi.";

    } else {

        /* Cari room */

        $stmt = $conn->prepare(
            "SELECT id, status
             FROM rooms
             WHERE room_code = ?"
        );

        $stmt->bind_param(
            "s",
            $roomCode
        );

        $stmt->execute();

        $result = $stmt->get_result();


        if ($result->num_rows === 0) {

            $error =
                "Room tidak ditemukan.";

        } else {

            $room =
                $result->fetch_assoc();


            if ($room["status"] !== "waiting") {

                $error =
                    "Room sudah dimulai.";

            } else {

                $roomId =
                    $room["id"];


                /* Masukkan pemain */

                $playerStmt = $conn->prepare(
                    "INSERT INTO players
                    (room_id, player_name, character_name, score, lives)
                    VALUES (?, ?, ?, 0, 3)"
                );

                $playerStmt->bind_param(
                    "iss",
                    $roomId,
                    $playerName,
                    $character
                );


                if ($playerStmt->execute()) {

                    $playerId =
                        $conn->insert_id;


                    /* Masuk lobby */

                    header(
                        "Location: lobby.php?room=" .
                        urlencode($roomCode) .
                        "&player_id=" .
                        $playerId
                    );

                    exit;

                } else {

                    $error =
                        "Gagal bergabung ke room: " .
                        $playerStmt->error;

                }

            }

        }

    }
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>EduQuest AI Multiplayer</title>


    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            font-family: Arial, sans-serif;

            color: white;

            background:
                radial-gradient(
                    circle at top left,
                    #4f46e5,
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    #06b6d4,
                    transparent 35%
                ),
                #0f172a;

            padding: 20px;

        }


        .container {

            width: 100%;

            max-width: 900px;

        }


        h1 {

            text-align: center;

            margin-bottom: 10px;

        }


        .subtitle {

            text-align: center;

            color: #94a3b8;

            margin-bottom: 30px;

        }


        .cards {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 20px;

        }


        .card {

            background:
                rgba(255,255,255,0.08);

            border:
                1px solid
                rgba(255,255,255,0.12);

            border-radius: 20px;

            padding: 25px;

        }


        .card h2 {

            margin-top: 0;

            color: #38bdf8;

        }


        input,
        select {

            width: 100%;

            padding: 13px;

            margin-bottom: 12px;

            border: none;

            border-radius: 10px;

            background: #1e293b;

            color: white;

            font-size: 15px;

        }


        button {

            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 10px;

            background: #4f46e5;

            color: white;

            font-weight: bold;

            font-size: 15px;

            cursor: pointer;

        }


        button:hover {

            background: #6366f1;

        }


        .error {

            background:
                rgba(239,68,68,0.2);

            border:
                1px solid #ef4444;

            color: #fecaca;

            padding: 12px;

            border-radius: 10px;

            margin-bottom: 20px;

            text-align: center;

        }


        @media(max-width: 700px) {

            .cards {

                grid-template-columns: 1fr;

            }

        }

    </style>

</head>


<body>


<div class="container">

    <h1>🎓 EduQuest AI</h1>

    <div class="subtitle">
        Multiplayer Quiz
    </div>


    <?php if ($error !== ""): ?>

        <div class="error">

            ⚠️
            <?php
            echo htmlspecialchars($error);
            ?>

        </div>

    <?php endif; ?>


    <div class="cards">


        <!-- CREATE ROOM -->

        <div class="card">

            <h2>🏠 Buat Room</h2>

            <form
                method="POST"
            >

                <input
                    type="hidden"
                    name="action"
                    value="create"
                >

                <input
                    type="text"
                    name="player_name"
                    placeholder="Nama kamu"
                    required
                >


                <select
                    name="character"
                >

                    <option value="edu">
                        🧑 Edu
                    </option>

                    <option value="robot">
                        🤖 Robo AI
                    </option>

                </select>


                <button
                    type="submit"
                >

                    🚀 Buat Room

                </button>

            </form>

        </div>


        <!-- JOIN ROOM -->

        <div class="card">

            <h2>👥 Join Room</h2>

            <form
                method="POST"
            >

                <input
                    type="hidden"
                    name="action"
                    value="join"
                >

                <input
                    type="text"
                    name="player_name"
                    placeholder="Nama kamu"
                    required
                >


                <input
                    type="text"
                    name="room_code"
                    placeholder="Kode Room"
                    maxlength="6"
                    style="text-transform:uppercase;"
                    required
                >


                <select
                    name="character"
                >

                    <option value="edu">
                        🧑 Edu
                    </option>

                    <option value="robot">
                        🤖 Robo AI
                    </option>

                </select>


                <button
                    type="submit"
                >

                    🎮 Join Room

                </button>

            </form>

        </div>


    </div>

</div>


</body>

</html>
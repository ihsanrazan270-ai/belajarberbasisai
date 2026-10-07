<?php

require_once "config.php";

/* ========================================
   AMBIL DATA URL
======================================== */

$roomCode = strtoupper(
    trim($_GET["room"] ?? "")
);

$playerId = intval(
    $_GET["player_id"] ?? 0
);


/* ========================================
   VALIDASI
======================================== */

if ($roomCode === "" || $playerId <= 0) {

    die("Data room atau pemain tidak lengkap.");

}


/* ========================================
   CARI ROOM
======================================== */

$stmt = $conn->prepare(
    "SELECT *
     FROM rooms
     WHERE room_code = ?"
);

$stmt->bind_param(
    "s",
    $roomCode
);

$stmt->execute();

$roomResult = $stmt->get_result();

if ($roomResult->num_rows === 0) {

    die("Room tidak ditemukan: " .
        htmlspecialchars($roomCode));

}

$room = $roomResult->fetch_assoc();

$roomId = intval($room["id"]);


/* ========================================
   CARI PEMAIN
======================================== */

$playerStmt = $conn->prepare(
    "SELECT *
     FROM players
     WHERE id = ?
     AND room_id = ?"
);

$playerStmt->bind_param(
    "ii",
    $playerId,
    $roomId
);

$playerStmt->execute();

$playerResult =
    $playerStmt->get_result();

if ($playerResult->num_rows === 0) {

    die(
        "Pemain tidak ditemukan di room ini."
    );

}

$currentPlayer =
    $playerResult->fetch_assoc();


/* ========================================
   AMBIL SEMUA PEMAIN
======================================== */

$playersStmt = $conn->prepare(
    "SELECT *
     FROM players
     WHERE room_id = ?
     ORDER BY id ASC"
);

$playersStmt->bind_param(
    "i",
    $roomId
);

$playersStmt->execute();

$playersResult =
    $playersStmt->get_result();


/* ========================================
   CEK HOST
======================================== */

$isHost =
    intval($room["host_player_id"]) ===
    $playerId;

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>EduQuest AI - Lobby</title>

<style>

* {
    box-sizing: border-box;
}

body {

    margin: 0;

    min-height: 100vh;

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

    padding: 30px;

}

.container {

    width: 100%;

    max-width: 900px;

    margin: auto;

}

.header {

    text-align: center;

    margin-bottom: 25px;

}

.header h1 {

    margin-bottom: 8px;

}

.subtitle {

    color: #94a3b8;

}

.room-box {

    background:
        rgba(255,255,255,0.08);

    border:
        1px solid
        rgba(255,255,255,0.12);

    border-radius: 20px;

    padding: 25px;

    text-align: center;

    margin-bottom: 20px;

}

.room-title {

    color: #94a3b8;

    font-size: 16px;

}

.room-code {

    font-size: 42px;

    font-weight: bold;

    letter-spacing: 8px;

    color: #38bdf8;

    margin: 10px 0;

}

.info {

    color: #cbd5e1;

}

.players {

    background:
        rgba(255,255,255,0.08);

    border:
        1px solid
        rgba(255,255,255,0.12);

    border-radius: 20px;

    padding: 25px;

}

.players h2 {

    margin-top: 0;

}

.player {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 15px;

    margin-bottom: 10px;

    background:
        rgba(255,255,255,0.06);

    border-radius: 14px;

}

.player-left {

    display: flex;

    align-items: center;

    gap: 15px;

}

.avatar {

    width: 50px;

    height: 50px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #1e293b;

    font-size: 25px;

}

.player-name {

    font-weight: bold;

}

.character {

    color: #94a3b8;

    font-size: 13px;

}

.host {

    padding: 6px 10px;

    border-radius: 8px;

    background: #4f46e5;

    font-size: 12px;

    font-weight: bold;

}

.you {

    color: #22c55e;

    font-size: 12px;

    font-weight: bold;

}

.status {

    text-align: center;

    margin-top: 25px;

    padding: 15px;

    background:
        rgba(34,197,94,0.12);

    border:
        1px solid
        rgba(34,197,94,0.3);

    border-radius: 12px;

    color: #86efac;

}

.start-button {

    width: 100%;

    margin-top: 20px;

    padding: 15px;

    border: none;

    border-radius: 12px;

    background: #4f46e5;

    color: white;

    font-size: 16px;

    font-weight: bold;

    cursor: pointer;

}

.start-button:hover {

    background: #6366f1;

}

.waiting {

    color: #facc15;

}

</style>

</head>

<body>

<div class="container">


<div class="header">

    <h1>🎓 EduQuest AI</h1>

    <div class="subtitle">
        Multiplayer Lobby
    </div>

</div>


<!-- ROOM -->

<div class="room-box">

    <div class="room-title">
        KODE ROOM
    </div>

    <div class="room-code">
        <?= htmlspecialchars($roomCode) ?>
    </div>

    <div class="info">

        Bagikan kode ini kepada temanmu.

    </div>

</div>


<!-- PLAYERS -->

<div class="players">

    <h2>
        👥 Pemain
        (<?= $playersResult->num_rows ?>)
    </h2>


    <?php while (
        $player = $playersResult->fetch_assoc()
    ): ?>

        <?php

        $character =
            strtolower(
                $player["character_name"]
            );

        if (
            $character === "robot" ||
            $character === "robot-ai"
        ) {

            $emoji = "🤖";

        } else {

            $emoji = "🧑";

        }

        ?>


        <div class="player">

            <div class="player-left">

                <div class="avatar">

                    <?= $emoji ?>

                </div>


                <div>

                    <div class="player-name">

                        <?= htmlspecialchars(
                            $player["player_name"]
                        ) ?>


                        <?php if (
                            intval($player["id"]) ===
                            $playerId
                        ): ?>

                            <span class="you">
                                (KAMU)
                            </span>

                        <?php endif; ?>

                    </div>


                    <div class="character">

                        Karakter:
                        <?= htmlspecialchars(
                            $player["character_name"]
                        ) ?>

                    </div>

                </div>

            </div>


            <?php if (
                intval($room["host_player_id"]) ===
                intval($player["id"])
            ): ?>

                <div class="host">

                    HOST

                </div>

            <?php endif; ?>


        </div>


    <?php endwhile; ?>


    <?php if ($isHost): ?>

        <div class="status">

            👑 Kamu adalah HOST.
            Tunggu teman masuk ke room.

        </div>


        <button
            class="start-button"
            onclick="startGame()"
        >

            🚀 MULAI GAME

        </button>

    <?php else: ?>

        <div class="status waiting">

            ⏳ Menunggu host memulai game...

        </div>

    <?php endif; ?>


</div>


</div>


<script>

function startGame() {

    alert(
        "Fitur mulai game multiplayer akan kita hubungkan setelah lobby berhasil."
    );

}

</script>

</body>

</html>
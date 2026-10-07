<?php

$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$total = isset($_GET['total']) ? intval($_GET['total']) : 5;

$correct = $score / 100;

if ($correct < 2) {

    $level = "Beginner";

    $message = "Kamu masih dalam tahap awal. Coba pelajari kembali materi dan bermain lagi.";

} elseif ($correct < 4) {

    $level = "Intermediate";

    $message = "Kemampuanmu sudah cukup baik. Terus berlatih untuk meningkatkan skor.";

} else {

    $level = "Advanced";

    $message = "Hebat! Kamu menunjukkan penguasaan materi yang sangat baik.";

}

$percentage = ($correct / $total) * 100;

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hasil - EduQuest AI</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>

        .result-container {

            width: 90%;
            max-width: 650px;
            background: rgba(255,255,255,0.12);
            padding: 45px 30px;
            border-radius: 25px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);

        }

        .result-icon {

            font-size: 70px;
            margin-bottom: 10px;

        }

        .result-title {

            font-size: 35px;
            font-weight: bold;
            margin-bottom: 30px;

        }

        .score-result {

            font-size: 55px;
            font-weight: bold;
            margin-bottom: 10px;

        }

        .percentage {

            font-size: 20px;
            opacity: 0.85;
            margin-bottom: 25px;

        }

        .level {

            display: inline-block;
            padding: 12px 30px;
            background: #22c55e;
            border-radius: 30px;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 25px;

        }

        .analysis {

            background: rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 15px;
            line-height: 1.6;
            margin-bottom: 30px;

        }

        .result-buttons {

            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;

        }

    </style>

</head>

<body>

    <div class="result-container">

        <div class="result-icon">
            🏆
        </div>

        <div class="result-title">
            GAME SELESAI!
        </div>

        <div class="score-result">
            <?= $score ?>
        </div>

        <div class="percentage">
            <?= round($percentage) ?>% Jawaban Benar
        </div>

        <div class="level">
            🎓 Level: <?= $level ?>
        </div>

        <div class="analysis">

            <strong>🤖 Analisis EduQuest AI</strong>

            <br><br>

            <?= $message ?>

        </div>

        <div class="result-buttons">

            <a href="game.php" class="btn btn-start">
                🔄 MAIN LAGI
            </a>

            <a href="index.php" class="btn btn-info">
                🏠 KEMBALI KE MENU
            </a>

        </div>

    </div>

</body>

</html>
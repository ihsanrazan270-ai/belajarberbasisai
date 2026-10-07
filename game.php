<?php

$player = $_GET["player"] ?? "Pemain";
$character = $_GET["character"] ?? "edu";

$characters = [
    "edu" => [
        "name" => "Edu",
        "image" => "assets/img/character/edu.png"
    ],

    "robot" => [
        "name" => "Robo AI",
        "image" => "assets/img/character/robot-ai.png"
    ]
];

if (!isset($characters[$character])) {
    $character = "edu";
}

$currentCharacter = $characters[$character];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>EduQuest AI - Game</title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: Arial, sans-serif;

            min-height: 100vh;

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

            color: white;

            padding: 25px;

        }


        .container {

            width: 100%;

            max-width: 1100px;

            margin: auto;

        }


        /* =========================
           HEADER
        ========================== */

        .header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            background:
                rgba(255,255,255,0.08);

            border:
                1px solid
                rgba(255,255,255,0.12);

            border-radius: 18px;

            padding: 18px 25px;

            margin-bottom: 20px;

        }


        .title {

            font-size: 24px;

            font-weight: bold;

        }


        .title span {

            color: #38bdf8;

        }


        .player-info {

            text-align: right;

            color: #cbd5e1;

        }


        .player-name {

            color: #38bdf8;

            font-weight: bold;

        }


        /* =========================
           HUD
        ========================== */

        .hud {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 15px;

            margin-bottom: 20px;

        }


        .hud-box {

            background:
                rgba(255,255,255,0.08);

            border-radius: 15px;

            padding: 18px;

            text-align: center;

        }


        .hud-label {

            color: #94a3b8;

            font-size: 13px;

            margin-bottom: 7px;

        }


        .hud-value {

            font-size: 25px;

            font-weight: bold;

        }


        /* =========================
           GAME AREA
        ========================== */

        .game-area {

            position: relative;

            background:
                rgba(255,255,255,0.08);

            border:
                1px solid
                rgba(255,255,255,0.12);

            border-radius: 25px;

            padding: 35px;

            min-height: 570px;

            overflow: hidden;

        }


        /* =========================
           CHARACTER PLAYER
        ========================== */

        .player-character {

            position: absolute;

            left: 20px;

            bottom: 20px;

            width: 160px;

            text-align: center;

        }


        .player-character img {

            width: 130px;

            height: 170px;

            object-fit: contain;

            filter:
                drop-shadow(
                    0 10px 15px
                    rgba(0,0,0,0.5)
                );

            animation:
                floating 2s infinite ease-in-out;

        }


        .character-name {

            background:
                rgba(15,23,42,0.8);

            border-radius: 10px;

            padding: 7px 12px;

            font-size: 13px;

            font-weight: bold;

        }


        @keyframes floating {

            0% {

                transform:
                    translateY(0);

            }

            50% {

                transform:
                    translateY(-8px);

            }

            100% {

                transform:
                    translateY(0);

            }

        }


        /* =========================
           AI CHARACTER
        ========================== */

        .ai-character {

            position: absolute;

            right: 20px;

            bottom: 20px;

            width: 160px;

            text-align: center;

        }


        .ai-character img {

            width: 120px;

            height: 150px;

            object-fit: contain;

            filter:
                drop-shadow(
                    0 10px 15px
                    rgba(0,0,0,0.5)
                );

        }


        .ai-name {

            background:
                rgba(15,23,42,0.8);

            border-radius: 10px;

            padding: 7px 12px;

            font-size: 13px;

            font-weight: bold;

        }


        /* =========================
           QUESTION
        ========================== */

        .question-area {

            max-width: 650px;

            margin: auto;

            position: relative;

            z-index: 2;

        }


        .question-number {

            color: #38bdf8;

            font-weight: bold;

            margin-bottom: 15px;

            text-align: center;

        }


        .question {

            background:
                rgba(255,255,255,0.08);

            border-radius: 18px;

            padding: 25px;

            font-size: 22px;

            font-weight: bold;

            line-height: 1.5;

            text-align: center;

            margin-bottom: 20px;

        }


        /* =========================
           ANSWERS
        ========================== */

        .answers {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 12px;

        }


        .answer-btn {

            border: none;

            padding: 17px;

            border-radius: 13px;

            background:
                rgba(255,255,255,0.08);

            border:
                1px solid
                rgba(255,255,255,0.12);

            color: white;

            font-size: 15px;

            cursor: pointer;

            transition: 0.25s;

        }


        .answer-btn:hover {

            background:
                rgba(56,189,248,0.2);

            border-color:
                #38bdf8;

            transform:
                translateY(-2px);

        }


        .answer-btn:disabled {

            cursor: not-allowed;

            opacity: 0.6;

        }


        /* =========================
           PROGRESS
        ========================== */

        .progress-container {

            margin-top: 25px;

        }


        .progress-info {

            display: flex;

            justify-content: space-between;

            color: #94a3b8;

            font-size: 13px;

            margin-bottom: 8px;

        }


        .progress {

            width: 100%;

            height: 10px;

            background:
                rgba(255,255,255,0.08);

            border-radius: 20px;

            overflow: hidden;

        }


        .progress-bar {

            height: 100%;

            width: 0%;

            background: #38bdf8;

            transition: 0.3s;

        }


        /* =========================
           AI FEEDBACK
        ========================== */

        .ai-feedback {

            margin-top: 20px;

            background:
                rgba(15,23,42,0.75);

            border:
                1px solid
                rgba(56,189,248,0.25);

            border-radius: 15px;

            padding: 18px;

            display: none;

        }


        .ai-title {

            color: #38bdf8;

            font-weight: bold;

            margin-bottom: 10px;

        }


        .ai-message {

            color: #cbd5e1;

            line-height: 1.6;

            white-space: pre-line;

        }


        /* =========================
           RESPONSIVE
        ========================== */

        @media(max-width: 800px) {

            .game-area {

                padding: 25px 15px 200px;

            }


            .player-character {

                left: 5px;

            }


            .ai-character {

                right: 5px;

            }


            .answers {

                grid-template-columns:
                    1fr;

            }

        }


        @media(max-width: 550px) {

            .header {

                flex-direction:
                    column;

                gap: 10px;

            }


            .player-info {

                text-align:
                    center;

            }


            .hud {

                grid-template-columns:
                    1fr;

            }


            .player-character img {

                width: 90px;

                height: 110px;

            }


            .ai-character img {

                width: 85px;

                height: 105px;

            }


            .player-character,
            .ai-character {

                width: 110px;

            }

        }

        /* =========================
           MUSIC CONTROL
        ========================== */

        .music-control {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 14px;
            background: rgba(15,23,42,0.92);
            border: 1px solid rgba(56,189,248,0.25);
            backdrop-filter: blur(8px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .music-control button {
            border: none;
            border-radius: 10px;
            padding: 9px 14px;
            background: #4f46e5;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .music-control button:hover {
            transform: scale(1.05);
        }

        #volumeControl {
            width: 90px;
            cursor: pointer;
        }

        @media(max-width: 550px) {
            .music-control {
                top: 10px;
                right: 10px;
                padding: 7px 9px;
            }
            .music-control button {
                padding: 7px 9px;
                font-size: 12px;
            }
            #volumeControl {
                width: 65px;
            }
        }

    </style>

</head>


<body>


<!-- =========================
     BACKGROUND MUSIC
========================== -->
<audio id="bgMusic" loop preload="auto">
    <source src="assets/audio/background.mp3" type="audio/mpeg">
    Browser kamu tidak mendukung audio.
</audio>

<div class="music-control">
    <button id="musicBtn" type="button" onclick="toggleMusic()">
        🎵 Musik ON
    </button>

    <input
        type="range"
        id="volumeControl"
        min="0"
        max="1"
        step="0.01"
        value="0.4"
        title="Volume musik"
    >
</div>


<div class="container">


    <!-- =========================
         HEADER
    ========================== -->

    <div class="header">

        <div class="title">

            🎓 Edu<span>Quest AI</span>

        </div>


        <div class="player-info">

            Pemain:

            <span class="player-name">

                <?php echo htmlspecialchars($player); ?>

            </span>

        </div>

    </div>



    <!-- =========================
         HUD
    ========================== -->

    <div class="hud">


        <div class="hud-box">

            <div class="hud-label">
                ❤️ NYAWA
            </div>

            <div
                class="hud-value"
                id="lives"
            >
                3
            </div>

        </div>


        <div class="hud-box">

            <div class="hud-label">
                🏆 SCORE
            </div>

            <div
                class="hud-value"
                id="score"
            >
                0
            </div>

        </div>


        <div class="hud-box">

            <div class="hud-label">
                ⏱️ WAKTU
            </div>

            <div
                class="hud-value"
                id="timer"
            >
                30
            </div>

        </div>


    </div>



    <!-- =========================
         GAME
    ========================== -->

    <div class="game-area">


        <!-- PLAYER CHARACTER -->

        <div class="player-character">

            <img
                src="<?php echo $currentCharacter["image"]; ?>"
                alt="<?php echo htmlspecialchars($currentCharacter["name"]); ?>"
            >

            <div class="character-name">

                <?php echo htmlspecialchars($player); ?>

            </div>

        </div>



        <!-- AI CHARACTER -->

        <div class="ai-character">

            <img
                src="assets/img/character/robot-ai.png"
                alt="AI Tutor"
            >

            <div class="ai-name">

                🤖 AI Tutor

            </div>

        </div>



        <!-- QUESTION -->

        <div class="question-area">


            <div
                class="question-number"
                id="questionNumber"
            >
                Pertanyaan 1 / 5
            </div>


            <div
                class="question"
                id="question"
            >
                Loading...
            </div>


            <div
                class="answers"
                id="answers"
            >
            </div>



            <!-- PROGRESS -->

            <div class="progress-container">

                <div class="progress-info">

                    <span>
                        Progress
                    </span>

                    <span id="progressText">
                        0%
                    </span>

                </div>


                <div class="progress">

                    <div
                        class="progress-bar"
                        id="progressBar"
                    ></div>

                </div>

            </div>



            <!-- AI FEEDBACK -->

            <div
                class="ai-feedback"
                id="aiFeedback"
            >

                <div class="ai-title">

                    🤖 AI Tutor

                </div>


                <div
                    class="ai-message"
                    id="aiMessage"
                >
                </div>

            </div>


        </div>


    </div>


</div>



<script>



/* ========================================
   BACKGROUND MUSIC
======================================== */

const bgMusic = document.getElementById("bgMusic");
const musicBtn = document.getElementById("musicBtn");
const volumeControl = document.getElementById("volumeControl");

bgMusic.volume = 0.4;

function startMusic() {
    bgMusic.play().then(() => {
        musicBtn.textContent = "🎵 Musik ON";
    }).catch(() => {
        // Browser memblokir autoplay sebelum ada interaksi pengguna.
    });
}

function toggleMusic() {
    if (bgMusic.paused) {
        bgMusic.play().then(() => {
            musicBtn.textContent = "🎵 Musik ON";
        }).catch(() => {
            musicBtn.textContent = "▶️ Putar Musik";
        });
    } else {
        bgMusic.pause();
        musicBtn.textContent = "🔇 Musik OFF";
    }
}

volumeControl.addEventListener("input", function () {
    bgMusic.volume = Number(this.value);
});

// Coba mulai setelah interaksi pertama agar tidak terkena blokir autoplay.
document.addEventListener("click", function startMusicOnce() {
    startMusic();
    document.removeEventListener("click", startMusicOnce);
});


/* ========================================
   DATA SOAL
======================================== */

const questions = [

    {
        question:
            "Apa kepanjangan dari CPU?",

        answers: [

            "Central Processing Unit",

            "Computer Personal Unit",

            "Central Program Utility",

            "Computer Processing Utility"

        ],

        correct: 0

    },


    {
        question:
            "Berapakah hasil dari 12 × 8?",

        answers: [

            "86",

            "96",

            "108",

            "112"

        ],

        correct: 1

    },


    {
        question:
            "HTML digunakan terutama untuk?",

        answers: [

            "Membuat struktur halaman web",

            "Mengedit video",

            "Mengolah database",

            "Membuat sistem operasi"

        ],

        correct: 0

    },


    {
        question:
            "Planet yang dikenal sebagai Planet Merah adalah?",

        answers: [

            "Venus",

            "Jupiter",

            "Mars",

            "Saturnus"

        ],

        correct: 2

    },


    {
        question:
            "RAM berfungsi sebagai?",

        answers: [

            "Penyimpanan sementara",

            "Penyimpanan permanen",

            "Kartu grafis",

            "Sistem operasi"

        ],

        correct: 0

    }

];



/* ========================================
   VARIABLE GAME
======================================== */

let currentQuestion = 0;

let score = 0;

let lives = 3;

let timeLeft = 30;

let timerInterval;

let answered = false;



/* ========================================
   ELEMENT
======================================== */

const questionElement =
    document.getElementById("question");

const answersElement =
    document.getElementById("answers");

const questionNumberElement =
    document.getElementById("questionNumber");

const scoreElement =
    document.getElementById("score");

const livesElement =
    document.getElementById("lives");

const timerElement =
    document.getElementById("timer");

const progressBar =
    document.getElementById("progressBar");

const progressText =
    document.getElementById("progressText");

const aiFeedback =
    document.getElementById("aiFeedback");

const aiMessage =
    document.getElementById("aiMessage");



/* ========================================
   LOAD QUESTION
======================================== */

function loadQuestion() {

    clearInterval(timerInterval);

    answered = false;

    timeLeft = 30;

    timerElement.textContent = timeLeft;

    aiFeedback.style.display = "none";


    const q =
        questions[currentQuestion];


    questionElement.textContent =
        q.question;


    questionNumberElement.textContent =
        "Pertanyaan " +
        (currentQuestion + 1) +
        " / " +
        questions.length;


    answersElement.innerHTML = "";


    q.answers.forEach(
        (answer, index) => {

            const button =
                document.createElement("button");


            button.className =
                "answer-btn";


            button.textContent =
                answer;


            button.onclick = function() {

                checkAnswer(
                    index,
                    answer
                );

            };


            answersElement.appendChild(
                button
            );

        }
    );


    updateProgress();


    startTimer();

}



/* ========================================
   TIMER
======================================== */

function startTimer() {

    timerInterval =
        setInterval(() => {

            timeLeft--;

            timerElement.textContent =
                timeLeft;


            if (timeLeft <= 0) {

                clearInterval(
                    timerInterval
                );

                timeOut();

            }

        }, 1000);

}



/* ========================================
   TIME OUT
======================================== */

function timeOut() {

    if (answered) return;

    answered = true;

    lives--;

    livesElement.textContent =
        lives;


    disableAnswers();


    showAI(

        "Waktu habis! Coba baca soal dengan lebih teliti dan gunakan waktu dengan baik."

    );


    setTimeout(() => {

        nextQuestion();

    }, 2500);

}



/* ========================================
   CHECK ANSWER
======================================== */

function checkAnswer(
    selectedIndex,
    selectedAnswer
) {

    if (answered) return;

    answered = true;

    clearInterval(
        timerInterval
    );


    const q =
        questions[currentQuestion];


    const isCorrect =
        selectedIndex === q.correct;


    if (isCorrect) {

        score += 100;

        scoreElement.textContent =
            score;

    } else {

        lives--;

        livesElement.textContent =
            lives;

    }


    disableAnswers();


    /*
       Kirim jawaban ke AI
    */

    sendToAI(

        q.question,

        selectedAnswer,

        q.answers[q.correct],

        isCorrect

    );

}



/* ========================================
   DISABLE ANSWERS
======================================== */

function disableAnswers() {

    const buttons =
        document.querySelectorAll(
            ".answer-btn"
        );


    buttons.forEach(button => {

        button.disabled = true;

    });

}



/* ========================================
   AI
======================================== */

function sendToAI(
    question,
    answer,
    correctAnswer,
    isCorrect
) {

    aiFeedback.style.display =
        "block";


    aiMessage.textContent =
        "🤖 AI sedang menganalisis jawaban...";


    const formData =
        new FormData();


    formData.append(
        "question",
        question
    );


    formData.append(
        "answer",
        answer
    );


    formData.append(
        "correct_answer",
        correctAnswer
    );


    fetch("ai.php", {

        method: "POST",

        body: formData

    })

    .then(response =>
        response.json()
    )

    .then(data => {

        if (data.success) {

            aiMessage.textContent =
                data.message;

        } else {

            aiMessage.textContent =
                "⚠️ " +
                data.message;

        }


        setTimeout(() => {

            nextQuestion();

        }, 3500);

    })

    .catch(error => {

        console.error(error);


        aiMessage.textContent =
            isCorrect

            ? "✅ Jawaban benar! AI sedang tidak tersedia."

            : "❌ Jawaban belum tepat. AI sedang tidak tersedia.";


        setTimeout(() => {

            nextQuestion();

        }, 2500);

    });

}



/* ========================================
   SHOW AI
======================================== */

function showAI(message) {

    aiFeedback.style.display =
        "block";

    aiMessage.textContent =
        message;

}



/* ========================================
   NEXT QUESTION
======================================== */

function nextQuestion() {

    if (lives <= 0) {

        finishGame();

        return;

    }


    currentQuestion++;


    if (
        currentQuestion >=
        questions.length
    ) {

        finishGame();

        return;

    }


    loadQuestion();

}



/* ========================================
   PROGRESS
======================================== */

function updateProgress() {

    const percentage =
        (currentQuestion /
        questions.length) * 100;


    progressBar.style.width =
        percentage + "%";


    progressText.textContent =
        Math.round(percentage) +
        "%";

}



/* ========================================
   FINISH GAME
======================================== */

function finishGame() {

    clearInterval(
        timerInterval
    );


    window.location.href =
        "result.php?score=" +
        score +
        "&total=" +
        questions.length +
        "&player=<?php echo urlencode($player); ?>";

}



/* ========================================
   START
======================================== */

loadQuestion();


</script>


</body>

</html>
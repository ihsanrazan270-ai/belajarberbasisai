<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pilih Karakter - EduQuest AI</title>

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
                radial-gradient(circle at top left, #4f46e5, transparent 35%),
                radial-gradient(circle at bottom right, #06b6d4, transparent 35%),
                #0f172a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .container {
            width: 100%;
            max-width: 950px;
            text-align: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .logo span {
            color: #38bdf8;
        }

        .subtitle {
            color: #cbd5e1;
            margin-bottom: 35px;
        }

        /* CHARACTER LIST */

        .characters {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .character-card {
            background: rgba(255,255,255,0.08);
            border: 2px solid rgba(255,255,255,0.12);
            border-radius: 20px;
            padding: 25px;
            cursor: pointer;
            transition: 0.3s;
        }

        .character-card:hover {
            transform: translateY(-8px);
            border-color: #38bdf8;
            background: rgba(56,189,248,0.12);
        }

        .character-card.selected {
            border-color: #38bdf8;
            background: rgba(56,189,248,0.18);
            box-shadow: 0 0 25px rgba(56,189,248,0.25);
        }

        .character-card img {
            width: 150px;
            height: 180px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .character-card h3 {
            margin-bottom: 8px;
        }

        .character-card p {
            color: #94a3b8;
            font-size: 14px;
        }

        /* NAME */

        .name-box {
            margin: 20px auto;
            max-width: 450px;
        }

        .name-box label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .name-box input {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #475569;
            background: rgba(255,255,255,0.08);
            color: white;
            outline: none;
            font-size: 16px;
        }

        .name-box input:focus {
            border-color: #38bdf8;
        }

        .name-box input::placeholder {
            color: #94a3b8;
        }

        /* BUTTON */

        .start-btn {
            border: none;
            padding: 16px 35px;
            border-radius: 12px;
            background: #38bdf8;
            color: #082f49;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .start-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(56,189,248,0.3);
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
        }

        .back-btn:hover {
            color: white;
        }

        .warning {
            color: #f87171;
            margin-top: 15px;
            min-height: 20px;
        }

        @media (max-width: 750px) {
            .characters {
                grid-template-columns: 1fr;
            }

            .character-card img {
                width: 130px;
                height: 150px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="logo">
        🎓 Edu<span>Quest AI</span>
    </div>

    <p class="subtitle">
        Pilih karakter yang akan kamu gunakan dalam permainan
    </p>


    <form action="game.php" method="GET" id="characterForm">

        <input
            type="hidden"
            name="character"
            id="characterInput"
            value=""
        >


        <!-- KARAKTER -->

        <div class="characters">

            <!-- KARAKTER 1 -->

            <div
                class="character-card"
                data-character="edu"
            >

                <img
                    src="assets/img/character/edu.png"
                    alt="Karakter Edu"
                >

                <h3>🎓 Edu</h3>

                <p>
                    Karakter utama EduQuest
                </p>

            </div>


            <!-- KARAKTER 2 -->

            <div
                class="character-card"
                data-character="robot"
            >

                <img
                    src="assets/img/character/robot-ai.png"
                    alt="Robot AI"
                >

                <h3>🤖 Robo</h3>

                <p>
                    Robot pintar AI
                </p>

            </div>


            <!-- KARAKTER 3 -->

            <div
                class="character-card"
                data-character="edu"
            >

                <img
                    src="assets/img/character/edu.png"
                    alt="Karakter Edu"
                >

                <h3>⭐ Edu Pro</h3>

                <p>
                    Karakter alternatif
                </p>

            </div>

        </div>


        <!-- NAMA -->

        <div class="name-box">

            <label for="playerName">
                👤 Nama Pemain
            </label>

            <input
                type="text"
                id="playerName"
                name="player"
                placeholder="Masukkan nama kamu..."
                maxlength="20"
                required
            >

        </div>


        <div class="warning" id="warning"></div>


        <button
            type="submit"
            class="start-btn"
        >
            🚀 Mulai Bermain
        </button>

    </form>


    <a href="index.php" class="back-btn">
        ← Kembali ke halaman utama
    </a>

</div>


<script>

    const cards =
        document.querySelectorAll(".character-card");

    const characterInput =
        document.getElementById("characterInput");

    const form =
        document.getElementById("characterForm");

    const warning =
        document.getElementById("warning");


    // PILIH KARAKTER

    cards.forEach(card => {

        card.addEventListener("click", function() {

            cards.forEach(item => {

                item.classList.remove("selected");

            });

            this.classList.add("selected");

            characterInput.value =
                this.dataset.character;

            warning.textContent = "";

        });

    });


    // CEK SEBELUM MULAI

    form.addEventListener("submit", function(event) {

        if (characterInput.value === "") {

            event.preventDefault();

            warning.textContent =
                "⚠️ Silakan pilih karakter terlebih dahulu.";

            return;

        }

    });

</script>

</body>
</html>
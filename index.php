<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>EduQuest AI</title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: Arial, sans-serif;

            min-height: 100vh;

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

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 30px;

        }


        /* =========================
           CONTAINER
        ========================= */

        .container {

            width: 100%;

            max-width: 1100px;

            text-align: center;

        }


        /* =========================
           HEADER
        ========================= */

        .subtitle-top {

            font-size: 27px;

            color: #dbeafe;

            margin-bottom: 65px;

        }


        /* =========================
           MAIN CARD
        ========================= */

        .main-card {

            background:
                rgba(255,255,255,0.08);

            border:
                1px solid
                rgba(255,255,255,0.15);

            border-radius: 28px;

            padding: 70px 45px 50px;

            box-shadow:
                0 25px 70px
                rgba(0,0,0,0.35);

            backdrop-filter: blur(10px);

        }


        /* =========================
           CHARACTER
        ========================= */

        .character {

            display: flex;

            justify-content: center;

            margin-bottom: 30px;

        }


        .character img {

            width: 270px;

            height: 240px;

            object-fit: contain;

            filter:
                drop-shadow(
                    0 15px 20px
                    rgba(0,0,0,0.4)
                );

            animation:
                floating 3s infinite
                ease-in-out;

        }


        @keyframes floating {

            0% {

                transform:
                    translateY(0);

            }

            50% {

                transform:
                    translateY(-10px);

            }

            100% {

                transform:
                    translateY(0);

            }

        }


        /* =========================
           TITLE
        ========================= */

        .title {

            font-size: 40px;

            font-weight: bold;

            margin-bottom: 18px;

        }


        .title span {

            color: #38bdf8;

        }


        .description {

            max-width: 800px;

            margin: auto;

            color: #cbd5e1;

            font-size: 19px;

            line-height: 1.8;

            margin-bottom: 40px;

        }


        /* =========================
           BUTTON
        ========================= */

        .buttons {

            display: flex;

            justify-content: center;

            align-items: center;

            gap: 20px;

            flex-wrap: wrap;

        }


        .btn {

            display: inline-flex;

            justify-content: center;

            align-items: center;

            min-width: 270px;

            padding: 18px 30px;

            border-radius: 15px;

            text-decoration: none;

            font-size: 18px;

            font-weight: bold;

            transition: 0.3s;

        }


        .btn-primary {

            background: #38bdf8;

            color: #082f49;

        }


        .btn-primary:hover {

            transform:
                translateY(-5px);

            box-shadow:
                0 12px 35px
                rgba(56,189,248,0.4);

        }


        .btn-secondary {

            background:
                rgba(255,255,255,0.08);

            color: white;

            border:
                1px solid
                rgba(255,255,255,0.15);

        }


        .btn-secondary:hover {

            transform:
                translateY(-5px);

            background:
                rgba(255,255,255,0.15);

        }


        /* =========================
           FEATURES
        ========================= */

        .features {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;

            margin-top: 50px;

        }


        .feature {

            background:
                rgba(255,255,255,0.06);

            border:
                1px solid
                rgba(255,255,255,0.08);

            border-radius: 18px;

            padding: 25px 20px;

        }


        .feature-icon {

            font-size: 35px;

            margin-bottom: 12px;

        }


        .feature h3 {

            margin-bottom: 10px;

            font-size: 18px;

        }


        .feature p {

            color: #94a3b8;

            font-size: 14px;

            line-height: 1.6;

        }


        /* =========================
           HOW TO PLAY
        ========================= */

        .how-to {

            margin-top: 35px;

            background:
                rgba(255,255,255,0.06);

            border:
                1px solid
                rgba(255,255,255,0.08);

            border-radius: 20px;

            padding: 30px;

            text-align: left;

        }


        .how-to h2 {

            text-align: center;

            margin-bottom: 25px;

        }


        .steps {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 15px;

        }


        .step {

            background:
                rgba(15,23,42,0.4);

            border-radius: 12px;

            padding: 16px;

            color: #cbd5e1;

            line-height: 1.6;

        }


        .step b {

            color: #38bdf8;

        }


        /* =========================
           FOOTER
        ========================= */

        footer {

            margin-top: 30px;

            color: #64748b;

            font-size: 13px;

        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 750px) {

            body {

                padding: 15px;

            }


            .subtitle-top {

                font-size: 20px;

                margin-bottom: 30px;

            }


            .main-card {

                padding:
                    40px 20px;

            }


            .character img {

                width: 190px;

                height: 180px;

            }


            .title {

                font-size: 28px;

            }


            .description {

                font-size: 15px;

            }


            .features {

                grid-template-columns:
                    1fr;

            }


            .steps {

                grid-template-columns:
                    1fr;

            }


            .btn {

                width: 100%;

            }

        }

    </style>

</head>


<body>


<div class="container">


    <!-- =========================
         TOP TITLE
    ========================== -->

    <div class="subtitle-top">

        Game Edukasi Interaktif Berbasis
        Artificial Intelligence

    </div>



    <!-- =========================
         MAIN CARD
    ========================== -->

    <div class="main-card">


        <!-- CHARACTER -->

        <div class="character">

            <img
                src="assets/img/character/edu.png"
                alt="Edu Character"
            >

        </div>



        <!-- TITLE -->

        <div class="title">

            Selamat Datang di
            <span>EduQuest AI!</span>
            🚀

        </div>



        <!-- DESCRIPTION -->

        <div class="description">

            Belajar tidak harus membosankan.
            Jawab berbagai pertanyaan,
            kumpulkan skor, dan dapatkan
            penjelasan serta saran belajar
            dari AI secara interaktif.

        </div>



        <!-- =========================
             BUTTON
        ========================== -->

        <div class="buttons">


            <!-- MULTIPLAYER -->

            <a
                href="multiplayer.php"
                class="btn btn-primary"
            >

                👥 Mulai Multiplayer

            </a>



            <!-- CARA BERMAIN -->

            <a
                href="#cara-bermain"
                class="btn btn-secondary"
            >

                📖 Cara Bermain

            </a>


        </div>



        <!-- =========================
             FEATURES
        ========================== -->

        <div class="features">


            <div class="feature">

                <div class="feature-icon">

                    🎮

                </div>

                <h3>

                    Multiplayer

                </h3>

                <p>

                    Buat room dan ajak teman
                    untuk bermain bersama.

                </p>

            </div>



            <div class="feature">

                <div class="feature-icon">

                    🤖

                </div>

                <h3>

                    AI Tutor

                </h3>

                <p>

                    Dapatkan penjelasan dan
                    saran belajar dari AI.

                </p>

            </div>



            <div class="feature">

                <div class="feature-icon">

                    🏆

                </div>

                <h3>

                    Sistem Skor

                </h3>

                <p>

                    Jawab pertanyaan dan
                    kumpulkan skor.

                </p>

            </div>


        </div>


    </div>



    <!-- =========================
         CARA BERMAIN
    ========================== -->

    <div
        class="how-to"
        id="cara-bermain"
    >

        <h2>

            📖 Cara Bermain

        </h2>


        <div class="steps">


            <div class="step">

                <b>1.</b>
                Klik tombol
                <b>Mulai Multiplayer</b>.

            </div>


            <div class="step">

                <b>2.</b>
                Host membuat room
                dan mendapatkan kode room.

            </div>


            <div class="step">

                <b>3.</b>
                Bagikan kode room
                kepada teman.

            </div>


            <div class="step">

                <b>4.</b>
                Setiap pemain memasukkan
                nama masing-masing.

            </div>


            <div class="step">

                <b>5.</b>
                Setiap pemain dapat
                memilih karakter sendiri.

            </div>


            <div class="step">

                <b>6.</b>
                Semua pemain masuk
                ke lobby yang sama.

            </div>


            <div class="step">

                <b>7.</b>
                Host menekan
                <b>Mulai Game</b>.

            </div>


            <div class="step">

                <b>8.</b>
                Pemain menjawab soal
                dan mendapatkan feedback AI.

            </div>


        </div>

    </div>



    <!-- FOOTER -->

    <footer>

        © 2026 EduQuest AI
        — Pemrograman Multimedia

    </footer>


</div>


</body>

</html>
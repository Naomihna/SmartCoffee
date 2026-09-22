<?php
// ==========================================
// KONEKSI DATABASE
// ==========================================
// File ini digunakan untuk menghubungkan
// halaman SmartCoffee dengan database MySQL.
require_once "config/database.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <!-- Pengaturan dasar halaman -->
    <meta charset="UTF-8">

    <!-- Membuat tampilan responsive di HP -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Judul website -->
    <title>SmartCoffee | Smart Multimedia Coffee Shop</title>


    <!-- ==========================================
         CSS / STYLE WEBSITE
    =========================================== -->

    <style>

        /* ==========================================
           RESET
        =========================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f2e9;
            color: #3b2519;
        }

        a {
            text-decoration: none;
        }


        /* ==========================================
           NAVBAR
        =========================================== */

        .navbar {
            width: 100%;
            height: 78px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 7%;

            background: #f8f2e9;

            position: sticky;
            top: 0;
            z-index: 1000;

            border-bottom: 1px solid #eadccd;
        }

        /* Logo */
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4b2e1f;
        }

        .logo span {
            font-size: 27px;
        }

        /* Menu navigasi */
        .nav-menu {
            display: flex;
            gap: 35px;
        }

        .nav-menu a {
            color: #715b4b;
            font-size: 14px;
            font-weight: 500;

            transition: 0.3s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: #a45d32;
        }

        /* Tombol login */
        .login-button {
            background: #4b2e1f;
            color: white;

            padding: 12px 24px;

            border-radius: 25px;

            font-size: 14px;
            font-weight: bold;

            transition: 0.3s;
        }

        .login-button:hover {
            background: #7b4a2d;
            transform: translateY(-2px);
        }


        /* ==========================================
           HERO SECTION
        =========================================== */

        .hero {
            min-height: 650px;

            padding: 70px 7%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 60px;
        }

        /* Bagian kiri hero */
        .hero-content {
            width: 50%;
        }

        .hero-label {
            color: #a45d32;

            font-size: 13px;
            font-weight: bold;

            letter-spacing: 3px;

            margin-bottom: 18px;
        }

        .hero h1 {
            font-family: Georgia, serif;

            font-size: 68px;
            line-height: 1.05;

            color: #3b2519;

            margin-bottom: 25px;
        }

        .hero h1 span {
            color: #a45d32;
        }

        .hero-description {
            color: #756256;

            max-width: 520px;

            line-height: 1.8;

            font-size: 16px;

            margin-bottom: 35px;
        }

        /* Tombol hero */
        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .btn-primary {
            display: inline-block;

            padding: 14px 27px;

            background: #4b2e1f;
            color: white;

            border-radius: 30px;

            font-size: 14px;
            font-weight: bold;

            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #7b4a2d;
            transform: translateY(-2px);
        }

        .btn-secondary {
            display: inline-block;

            padding: 14px 27px;

            border: 1px solid #8e705d;

            color: #4b2e1f;

            border-radius: 30px;

            font-size: 14px;
            font-weight: bold;

            transition: 0.3s;
        }

        .btn-secondary:hover {
            background: #eadccd;
        }


        /* ==========================================
           HERO IMAGE
        =========================================== */

        .hero-image {
            width: 45%;

            display: flex;
            justify-content: center;

            position: relative;
        }

        .coffee-image {
            width: 450px;
            height: 450px;

            border-radius: 50%;

            object-fit: cover;

            border: 12px solid #eadccd;

            box-shadow: 0 25px 50px rgba(72, 42, 25, 0.18);
        }

        /* Kartu rating */
        .rating-card {
            position: absolute;

            bottom: 35px;
            left: 20px;

            background: white;

            padding: 15px 20px;

            border-radius: 15px;

            box-shadow: 0 10px 30px rgba(60, 35, 20, 0.15);

            display: flex;
            align-items: center;

            gap: 10px;
        }

        .rating-star {
            font-size: 25px;
        }

        .rating-card strong {
            display: block;
            font-size: 15px;
        }

        .rating-card small {
            color: #8b796c;
            font-size: 11px;
        }


        /* ==========================================
           FEATURE SECTION
        =========================================== */

        .features {
            padding: 35px 7%;

            display: grid;
            grid-template-columns: repeat(3, 1fr);

            gap: 20px;
        }

        .feature-card {
            background: #fffaf4;

            padding: 25px;

            border-radius: 18px;

            display: flex;
            align-items: center;

            gap: 18px;

            border: 1px solid #eadccd;

            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);

            box-shadow: 0 15px 30px rgba(65, 38, 20, 0.08);
        }

        .feature-icon {
            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eadccd;

            border-radius: 15px;

            font-size: 25px;

            flex-shrink: 0;
        }

        .feature-card h3 {
            font-size: 16px;

            margin-bottom: 7px;
        }

        .feature-card p {
            font-size: 12px;

            color: #806f63;

            line-height: 1.5;
        }


        /* ==========================================
           POPULAR MENU
        =========================================== */

        .popular {
            padding: 100px 7%;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;

            margin-bottom: 40px;
        }

        .section-label {
            color: #a45d32;

            font-size: 12px;
            font-weight: bold;

            letter-spacing: 3px;

            margin-bottom: 10px;
        }

        .section-heading h2 {
            font-family: Georgia, serif;

            font-size: 42px;
        }

        .section-heading h2 span {
            color: #a45d32;
        }

        .see-menu {
            color: #a45d32;

            font-size: 14px;
            font-weight: bold;
        }


        /* ==========================================
           PRODUCT GRID
        =========================================== */

        .product-grid {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 25px;
        }

        .product-card {
            background: #fffaf4;

            border-radius: 20px;

            overflow: hidden;

            border: 1px solid #eadccd;

            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-7px);

            box-shadow: 0 20px 35px rgba(65, 38, 20, 0.12);
        }

        .product-image {
            height: 250px;

            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            transition: 0.4s;
        }

        .product-card:hover .product-image img {
            transform: scale(1.06);
        }

        .product-info {
            padding: 23px;
        }

        .product-category {
            color: #a45d32;

            font-size: 10px;

            font-weight: bold;

            letter-spacing: 2px;

            margin-bottom: 8px;
        }

        .product-info h3 {
            font-family: Georgia, serif;

            font-size: 23px;

            margin-bottom: 8px;
        }

        .product-info p {
            color: #806f63;

            font-size: 13px;

            line-height: 1.6;

            margin-bottom: 20px;
        }

        .product-bottom {
            display: flex;

            justify-content: space-between;

            align-items: center;
        }

        .product-price {
            color: #4b2e1f;

            font-size: 17px;

            font-weight: bold;
        }

        .add-button {
            width: 35px;
            height: 35px;

            border: none;

            background: #4b2e1f;

            color: white;

            border-radius: 50%;

            font-size: 20px;

            cursor: pointer;
        }


        /* ==========================================
           AI RECOMMENDATION
        =========================================== */

        .ai-section {
            margin: 20px 7% 100px;

            padding: 60px;

            background: #4b2e1f;

            border-radius: 25px;

            color: white;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 40px;
        }

        .ai-content {
            max-width: 650px;
        }

        .ai-label {
            color: #e9c9a7;

            font-size: 12px;

            letter-spacing: 3px;

            font-weight: bold;

            margin-bottom: 15px;
        }

        .ai-section h2 {
            font-family: Georgia, serif;

            font-size: 42px;

            margin-bottom: 18px;
        }

        .ai-section h2 span {
            color: #e9c9a7;
        }

        .ai-section p {
            color: #dfd1c7;

            line-height: 1.8;

            font-size: 14px;

            margin-bottom: 25px;
        }

        .ai-button {
            display: inline-block;

            padding: 13px 25px;

            background: #e9c9a7;

            color: #4b2e1f;

            border-radius: 25px;

            font-weight: bold;

            font-size: 13px;
        }

        .ai-icon {
            width: 130px;
            height: 130px;

            border-radius: 50%;

            background: rgba(255,255,255,0.1);

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 60px;
        }


        /* ==========================================
           ABOUT SECTION
        =========================================== */

        .about {
            padding: 50px 7% 100px;

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 70px;

            align-items: center;
        }

        .about-image img {
            width: 100%;

            height: 420px;

            object-fit: cover;

            border-radius: 25px;
        }

        .about-content h2 {
            font-family: Georgia, serif;

            font-size: 45px;

            line-height: 1.2;

            margin-bottom: 25px;
        }

        .about-content h2 span {
            color: #a45d32;
        }

        .about-content p:last-child {
            color: #756256;

            line-height: 1.9;

            font-size: 15px;
        }


        /* ==========================================
           FOOTER
        =========================================== */

        footer {
            background: #2d1c13;

            color: white;

            padding: 45px 7%;

            text-align: center;
        }

        .footer-logo {
            font-size: 23px;

            font-weight: bold;

            margin-bottom: 10px;
        }

        footer p {
            color: #c8b9ae;

            font-size: 13px;

            margin-bottom: 10px;
        }

        .copyright {
            margin-top: 20px;

            font-size: 11px;
        }


        /* ==========================================
           RESPONSIVE / MOBILE
        =========================================== */

        @media (max-width: 900px) {

            .nav-menu {
                display: none;
            }

            .hero {
                flex-direction: column;

                text-align: center;
            }

            .hero-content,
            .hero-image {
                width: 100%;
            }

            .hero h1 {
                font-size: 48px;
            }

            .hero-buttons {
                justify-content: center;
            }

            .coffee-image {
                width: 350px;
                height: 350px;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .ai-section {
                flex-direction: column;

                text-align: center;

                padding: 40px 25px;
            }

            .about {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


    <!-- ==========================================
         NAVBAR
    =========================================== -->

    <header class="navbar">

        <!-- Logo -->
        <a href="index.php" class="logo">
            ☕ SmartCoffee
        </a>

        <!-- Navigasi -->
        <nav class="nav-menu">

            <a href="index.php" class="active">
                Home
            </a>

            <a href="user/menu.php">
                Menu
            </a>

            <a href="#about">
                About
            </a>

            <a href="#contact">
                Contact
            </a>

        </nav>

        <!-- Tombol login -->
        <a href="login.php" class="login-button">
            Login
        </a>

    </header>



    <!-- ==========================================
         HERO SECTION
    =========================================== -->

    <section class="hero">

        <!-- Teks hero -->
        <div class="hero-content">

            <p class="hero-label">
                WELCOME TO SMARTCOFFEE
            </p>

            <h1>
                Your Daily
                <span>Coffee Moment.</span>
            </h1>

            <p class="hero-description">

                Temukan berbagai pilihan kopi favoritmu
                dengan pengalaman coffee shop yang lebih
                modern, interaktif, dan personal.

            </p>


            <!-- Tombol -->
            <div class="hero-buttons">

                <a href="user/menu.php" class="btn-primary">
                    Jelajahi Menu
                </a>

                <a href="#about" class="btn-secondary">
                    Tentang Kami
                </a>

            </div>

        </div>


        <!-- Foto kopi -->
        <div class="hero-image">

            <img
                class="coffee-image"
                src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=900&q=80"
                alt="Coffee SmartCoffee"
            >

            <!-- Rating -->
            <div class="rating-card">

                <span class="rating-star">
                    ⭐
                </span>

                <div>

                    <strong>
                        4.8 / 5
                    </strong>

                    <small>
                        Customer Rating
                    </small>

                </div>

            </div>

        </div>

    </section>



    <!-- ==========================================
         FITUR SMARTCOFFEE
    =========================================== -->

    <section class="features">


        <!-- Fitur 1 -->
        <div class="feature-card">

            <div class="feature-icon">
                ☕
            </div>

            <div>

                <h3>
                    Premium Coffee
                </h3>

                <p>
                    Pilihan kopi dengan kualitas
                    dan rasa terbaik.
                </p>

            </div>

        </div>


        <!-- Fitur 2 -->
        <div class="feature-card">

            <div class="feature-icon">
                ✨
            </div>

            <div>

                <h3>
                    Fresh Everyday
                </h3>

                <p>
                    Produk dibuat fresh untuk
                    menjaga kualitas rasa.
                </p>

            </div>

        </div>


        <!-- Fitur 3 -->
        <div class="feature-card">

            <div class="feature-icon">
                🤖
            </div>

            <div>

                <h3>
                    Smart Recommendation
                </h3>

                <p>
                    Sistem memberikan rekomendasi
                    berdasarkan aktivitas pengguna.
                </p>

            </div>

        </div>

    </section>



    <!-- ==========================================
         POPULAR MENU
    =========================================== -->

    <section class="popular">

        <!-- Judul -->
        <div class="section-heading">

            <div>

                <p class="section-label">
                    OUR MENU
                </p>

                <h2>
                    Popular
                    <span>Choices</span>
                </h2>

            </div>

            <a href="user/menu.php" class="see-menu">
                Lihat Semua →
            </a>

        </div>


        <!-- Produk -->
        <div class="product-grid">


            <!-- ==========================
                 CAPPUCCINO
            =========================== -->

            <div class="product-card">

                <div class="product-image">

                    <img
                        src="https://images.unsplash.com/photo-1572449043416-55f4685c9bb7?auto=format&fit=crop&w=700&q=80"
                        alt="Cappuccino"
                    >

                </div>

                <div class="product-info">

                    <div class="product-category">
                        COFFEE
                    </div>

                    <h3>
                        Cappuccino
                    </h3>

                    <p>
                        Espresso dengan susu dan
                        foam yang creamy.
                    </p>

                    <div class="product-bottom">

                        <span class="product-price">
                            Rp22.000
                        </span>

                        <button class="add-button">
                            +
                        </button>

                    </div>

                </div>

            </div>


            <!-- ==========================
                 CAFE LATTE
            =========================== -->

            <div class="product-card">

                <div class="product-image">

                    <img
                        src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=700&q=80"
                        alt="Cafe Latte"
                    >

                </div>

                <div class="product-info">

                    <div class="product-category">
                        COFFEE
                    </div>

                    <h3>
                        Cafe Latte
                    </h3>

                    <p>
                        Espresso dengan susu
                        yang lembut dan creamy.
                    </p>

                    <div class="product-bottom">

                        <span class="product-price">
                            Rp22.000
                        </span>

                        <button class="add-button">
                            +
                        </button>

                    </div>

                </div>

            </div>


            <!-- ==========================
                 MATCHA LATTE
            =========================== -->

            <div class="product-card">

                <div class="product-image">

                    <img
                        src="https://images.unsplash.com/photo-1515823064-d6e0c04616a7?auto=format&fit=crop&w=700&q=80"
                        alt="Matcha Latte"
                    >

                </div>

                <div class="product-info">

                    <div class="product-category">
                        NON-COFFEE
                    </div>

                    <h3>
                        Matcha Latte
                    </h3>

                    <p>
                        Matcha dengan susu creamy
                        dan rasa yang lembut.
                    </p>

                    <div class="product-bottom">

                        <span class="product-price">
                            Rp25.000
                        </span>

                        <button class="add-button">
                            +
                        </button>

                    </div>

                </div>

            </div>


        </div>

    </section>



    <!-- ==========================================
         AI RECOMMENDATION
    =========================================== -->

    <section class="ai-section">

        <div class="ai-content">

            <p class="ai-label">
                SMART FEATURE
            </p>

            <h2>
                Recommendation
                <span>For You 🤎</span>
            </h2>

            <p>

                SmartCoffee menggunakan data aktivitas
                pengguna seperti produk yang dilihat,
                produk favorit, rating, dan riwayat
                pembelian untuk memberikan rekomendasi
                menu yang sesuai dengan preferensi pengguna.

            </p>

            <a
                href="user/rekomendasi.php"
                class="ai-button"
            >
                Lihat Rekomendasi
            </a>

        </div>


        <!-- Icon AI -->
        <div class="ai-icon">
            🤖
        </div>

    </section>



    <!-- ==========================================
         ABOUT
    =========================================== -->

    <section class="about" id="about">


        <!-- Foto coffee shop -->
        <div class="about-image">

            <img
                src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?auto=format&fit=crop&w=1000&q=80"
                alt="SmartCoffee Shop"
            >

        </div>


        <!-- Deskripsi -->
        <div class="about-content">

            <p class="section-label">
                ABOUT SMARTCOFFEE
            </p>

            <h2>
                More Than Just
                <span>A Cup of Coffee.</span>
            </h2>

            <p>

                SmartCoffee merupakan aplikasi multimedia
                untuk UMKM coffee shop yang menggabungkan
                katalog produk, gambar, video, interaksi
                pengguna, serta sistem rekomendasi berbasis
                data.

            </p>

        </div>

    </section>



    <!-- ==========================================
         FOOTER
    =========================================== -->

    <footer id="contact">

        <div class="footer-logo">
            ☕ SmartCoffee
        </div>

        <p>
            Smart Multimedia Coffee Shop
        </p>

        <p class="copyright">
            © 2026 SmartCoffee. All Rights Reserved.
        </p>

    </footer>


</body>
</html>
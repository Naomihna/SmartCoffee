<?php

// ==========================================================
// OLD MONEY COFFEE
// CUSTOMER - HALAMAN MENU
// ==========================================================

// Memulai session
session_start();


// ==========================================================
// KONEKSI DATABASE
// ==========================================================

// Menghubungkan halaman dengan database
require_once "../config/database.php";


// ==========================================================
// CEK STATUS LOGIN
// ==========================================================

// Mengecek apakah customer sudah login
$isLogin = isset($_SESSION['user_id']);

// Mengambil ID customer
$userId = $_SESSION['user_id'] ?? null;

// Mengambil nama customer
$userName = $_SESSION['user_name'] ?? '';


// ==========================================================
// MENGAMBIL DATA PRODUK
// ==========================================================

$queryProduk = mysqli_query(
    $conn,
    "SELECT
        products.*,
        categories.name AS category_name
     FROM products
     LEFT JOIN categories
        ON categories.id = products.category_id
     ORDER BY products.id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <!-- Pengaturan dasar halaman -->
    <meta charset="UTF-8">

    <!-- Membuat tampilan responsive -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- Judul halaman -->
    <title>
        Menu | Old Money Coffee
    </title>


    <style>

        /* ==================================================
           RESET
        ================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        /* ==================================================
           BODY
        ================================================== */

        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f8f2e9;

            color: #3b2519;

        }


        /* ==================================================
           NAVBAR
        ================================================== */

        .navbar {

            height: 78px;

            padding: 0 7%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            background: #f8f2e9;

            border-bottom: 1px solid #eadccd;

            position: sticky;

            top: 0;

            z-index: 1000;

        }


        /* Logo */

        .logo {

            font-family: Georgia, serif;

            font-size: 23px;

            font-weight: bold;

            color: #4b2e1f;

            text-decoration: none;

        }


        /* Navigasi */

        .nav-menu {

            display: flex;

            gap: 32px;

        }


        .nav-menu a {

            color: #715b4b;

            text-decoration: none;

            font-size: 14px;

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

            padding: 11px 22px;

            border-radius: 25px;

            text-decoration: none;

            font-size: 13px;

            font-weight: bold;

        }


        /* ==================================================
           HERO MENU
        ================================================== */

        .menu-hero {

            padding: 80px 7% 55px;

            text-align: center;

        }


        .menu-label {

            color: #a45d32;

            font-size: 11px;

            font-weight: bold;

            letter-spacing: 3px;

            margin-bottom: 12px;

        }


        .menu-hero h1 {

            font-family: Georgia, serif;

            font-size: 50px;

            margin-bottom: 15px;

        }


        .menu-hero h1 span {

            color: #a45d32;

        }


        .menu-hero p {

            max-width: 600px;

            margin: auto;

            color: #806f63;

            font-size: 14px;

            line-height: 1.7;

        }


        /* ==================================================
           PRODUCT SECTION
        ================================================== */

        .menu-section {

            padding: 20px 7% 100px;

        }


        /* ==================================================
           PRODUCT GRID
        ================================================== */

        .product-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 25px;

        }


        /* ==================================================
           PRODUCT CARD
        ================================================== */

        .product-card {

            background: #fffaf4;

            border: 1px solid #eadccd;

            border-radius: 20px;

            overflow: hidden;

            transition: 0.3s;

        }


        .product-card:hover {

            transform: translateY(-7px);

            box-shadow:
                0 20px 35px
                rgba(65, 38, 20, 0.12);

        }


        /* ==================================================
           PRODUCT IMAGE
        ================================================== */

        .product-image {

            width: 100%;

            height: 250px;

            overflow: hidden;

            position: relative;

        }


        .product-image img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            transition: 0.4s;

        }


        .product-card:hover
        .product-image img {

            transform: scale(1.06);

        }


        /* ==================================================
           STOCK BADGE
        ================================================== */

        .stock-badge {

            position: absolute;

            top: 15px;

            right: 15px;

            background: #4b2e1f;

            color: white;

            padding: 7px 11px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: bold;

        }


        .stock-empty {

            background: #8b5e4a;

        }


        /* ==================================================
           PRODUCT INFO
        ================================================== */

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

            min-height: 42px;

            margin-bottom: 15px;

        }


        /* ==================================================
           FLAVOR
        ================================================== */

        .flavor {

            color: #927a69;

            font-size: 11px;

            margin-bottom: 17px;

        }


        /* ==================================================
           PRODUCT BOTTOM
        ================================================== */

        .product-bottom {

            display: flex;

            align-items: center;

            justify-content: space-between;

        }


        .product-price {

            color: #4b2e1f;

            font-size: 17px;

            font-weight: bold;

        }


        /* ==================================================
           BUTTON BELI
        ================================================== */

        .buy-button {

            background: #4b2e1f;

            color: white;

            padding: 10px 17px;

            border-radius: 20px;

            text-decoration: none;

            font-size: 11px;

            font-weight: bold;

        }


        .buy-button:hover {

            background: #7b4a2d;

        }


        .buy-disabled {

            background: #c7b9ae;

            pointer-events: none;

        }


        /* ==================================================
           EMPTY PRODUCT
        ================================================== */

        .empty {

            grid-column: 1 / -1;

            text-align: center;

            padding: 70px 20px;

            background: #fffaf4;

            border: 1px solid #eadccd;

            border-radius: 20px;

            color: #806f63;

        }


        .empty-icon {

            font-size: 45px;

            margin-bottom: 15px;

        }


        /* ==================================================
           FOOTER
        ================================================== */

        footer {

            background: #2d1c13;

            color: white;

            padding: 40px 7%;

            text-align: center;

        }


        footer h3 {

            font-family: Georgia, serif;

            margin-bottom: 10px;

        }


        footer p {

            color: #c8b9ae;

            font-size: 12px;

        }


        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media (max-width: 900px) {

            .nav-menu {

                display: none;

            }


            .product-grid {

                grid-template-columns: 1fr 1fr;

            }

        }


        @media (max-width: 600px) {

            .product-grid {

                grid-template-columns: 1fr;

            }


            .menu-hero h1 {

                font-size: 40px;

            }

        }

    </style>

</head>


<body>


    <!-- ==================================================
         NAVBAR
    ================================================== -->

    <header class="navbar">


        <!-- Logo -->

        <a
            href="../index.php"
            class="logo"
        >

            ☕ Old Money Coffee

        </a>


        <!-- Menu navigasi -->

        <nav class="nav-menu">

            <a href="../index.php">
                Home
            </a>

            <a
                href="menu.php"
                class="active"
            >
                Menu
            </a>

            <a href="../index.php#about">
                About
            </a>

            <a href="../index.php#contact">
                Contact
            </a>

        </nav>


       <!-- ==================================================
     LOGIN / PROFILE CUSTOMER
================================================== -->

<?php if ($isLogin): ?>

    <!-- Jika customer sudah login -->
    <a
        href="../index.php"
        class="login-button"
    >
        👤 <?= htmlspecialchars($userName) ?>
    </a>

<?php else: ?>

    <!-- Jika customer belum login -->
    <a
        href="../login.php"
        class="login-button"
    >
        Login
    </a>

<?php endif; ?>

    </header>



    <!-- ==================================================
         HERO
    ================================================== -->

    <section class="menu-hero">


        <p class="menu-label">

            OLD MONEY COFFEE

        </p>


        <h1>

            Our <span>Menu</span>

        </h1>


        <p>

            Pilih kopi dan minuman favoritmu
            dari berbagai menu yang tersedia
            di Old Money Coffee.

        </p>


    </section>



    <!-- ==================================================
         DAFTAR PRODUK
    ================================================== -->

    <section class="menu-section">


        <div class="product-grid">


            <?php

            // Mengecek apakah terdapat produk
            if (
                mysqli_num_rows(
                    $queryProduk
                ) > 0
            ):


                // Menampilkan produk satu per satu
                while (
                    $produk =
                    mysqli_fetch_assoc(
                        $queryProduk
                    )
                ):

            ?>


                <!-- ==================================================
                     PRODUCT CARD
                ================================================== -->

                <div class="product-card">


                    <!-- GAMBAR PRODUK -->

                    <div class="product-image">


                        <?php if (
                            !empty(
                                $produk['image']
                            )
                        ): ?>

                            <img
                                src="<?php
                                    echo htmlspecialchars(
                                        $produk['image']
                                    );
                                ?>"
                                alt="<?php
                                    echo htmlspecialchars(
                                        $produk['name']
                                    );
                                ?>"
                            >

                        <?php else: ?>

                            <img
                                src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=700&q=80"
                                alt="Coffee"
                            >

                        <?php endif; ?>


                        <!-- STATUS STOK -->

                        <?php if (
                            $produk['stock'] > 0
                        ): ?>

                            <div class="stock-badge">

                                Tersedia

                            </div>

                        <?php else: ?>

                            <div
                                class="
                                    stock-badge
                                    stock-empty
                                "
                            >

                                Habis

                            </div>

                        <?php endif; ?>


                    </div>



                    <!-- INFORMASI PRODUK -->

                    <div class="product-info">


                        <!-- KATEGORI -->

                        <div class="product-category">

                            <?php
                            echo htmlspecialchars(
                                $produk['category_name']
                                ?? 'MENU'
                            );
                            ?>

                        </div>



                        <!-- NAMA PRODUK -->

                        <h3>

                            <?php
                            echo htmlspecialchars(
                                $produk['name']
                            );
                            ?>

                        </h3>



                        <!-- DESKRIPSI -->

                        <p>

                            <?php
                            echo htmlspecialchars(
                                $produk['description']
                                ?? 'Menu pilihan Old Money Coffee.'
                            );
                            ?>

                        </p>



                        <!-- FLAVOR -->

                        <?php if (
                            !empty(
                                $produk['flavor']
                            )
                        ): ?>

                            <div class="flavor">

                                ☕ Flavor:
                                <?php
                                echo htmlspecialchars(
                                    $produk['flavor']
                                );
                                ?>

                            </div>

                        <?php endif; ?>



                        <!-- HARGA + TOMBOL -->

                        <div class="product-bottom">


                            <!-- HARGA -->

                            <span class="product-price">

                                Rp

                                <?php
                                echo number_format(
                                    $produk['price'],
                                    0,
                                    ',',
                                    '.'
                                );
                                ?>

                            </span>



<!-- ==================================================
     TOMBOL BELI
================================================== -->

<?php if ($produk['stock'] > 0): ?>

    <!-- ==================================================
         CEK STATUS LOGIN
    ================================================== -->

    <?php if ($isLogin): ?>

        <!-- Customer sudah login -->
        <!-- Langsung menuju detail produk -->

        <a
            href="detail_produk.php?id=<?= $produk['id']; ?>"
            class="buy-button"
        >
            Beli
        </a>

    <?php else: ?>

        <!-- Customer belum login -->
        <!-- Arahkan ke halaman login -->

        <a
            href="../login.php"
            class="buy-button"
        >
            Login untuk Beli
        </a>

    <?php endif; ?>


<?php else: ?>

    <!-- ==================================================
         PRODUK HABIS
    ================================================== -->

    <span
        class="buy-button buy-disabled"
    >
        Habis
    </span>

<?php endif; ?>


                        </div>
                        <!-- END PRODUCT BOTTOM -->


                    </div>
                    <!-- END PRODUCT INFO -->


                </div>
                <!-- END PRODUCT CARD -->


            <?php endwhile; ?>


        <?php else: ?>

            <!-- ==================================================
                 JIKA PRODUK BELUM ADA
            ================================================== -->

            <div class="empty">

                <div class="empty-icon">
                    ☕
                </div>

                <h3>
                    Belum Ada Produk
                </h3>

                <p>
                    Produk yang ditambahkan Admin
                    akan muncul di halaman ini.
                </p>

            </div>

        <?php endif; ?>


        </div>
        <!-- END PRODUCT GRID -->


    </section>
    <!-- END MENU SECTION -->



    <!-- ==================================================
         FOOTER
    ================================================== -->

    <footer>


        <h3>
            ☕ Old Money Coffee
        </h3>


        <p>
            Smart Multimedia Coffee Shop
        </p>


    </footer>


</body>

</html>
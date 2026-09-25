<?php

// ==========================================================
// OLD MONEY COFFEE
// SMART UMKM OWNER DASHBOARD
// ==========================================================


// ==========================================================
// KONEKSI DATABASE
// ==========================================================

// Memanggil file koneksi database.
// Karena index.php berada di dalam folder admin,
// maka kita naik satu folder menggunakan ../
require_once "../config/database.php";


// ==========================================================
// DATA CUSTOMER
// ==========================================================

// Menghitung jumlah user dengan role user
$queryCustomer = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE role = 'user'"
);

// Mengambil hasil query
$dataCustomer = mysqli_fetch_assoc($queryCustomer);

// Menyimpan jumlah customer
$totalCustomer = $dataCustomer['total'];


// ==========================================================
// DATA PRODUK
// ==========================================================

// Menghitung seluruh produk
$queryProduk = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM products"
);

// Mengambil hasil query
$dataProduk = mysqli_fetch_assoc($queryProduk);

// Menyimpan jumlah produk
$totalProduk = $dataProduk['total'];


// ==========================================================
// DATA TRANSAKSI
// ==========================================================

// Menghitung seluruh transaksi
$queryTransaksi = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM transaksi"
);

// Mengambil hasil query
$dataTransaksi = mysqli_fetch_assoc($queryTransaksi);

// Menyimpan jumlah transaksi
$totalTransaksi = $dataTransaksi['total'];


// ==========================================================
// DATA PENDAPATAN
// ==========================================================

// Menghitung total pendapatan dari transaksi selesai
$queryPendapatan = mysqli_query(
    $conn,
    "SELECT COALESCE(SUM(total), 0) AS total
     FROM transaksi
     WHERE status = 'selesai'"
);

// Mengambil hasil query
$dataPendapatan = mysqli_fetch_assoc($queryPendapatan);

// Menyimpan total pendapatan
$totalPendapatan = $dataPendapatan['total'];


// ==========================================================
// PRODUK TERLARIS
// ==========================================================

// Mengambil produk berdasarkan jumlah pembelian terbanyak
$queryTerlaris = mysqli_query(
    $conn,
    "SELECT
        products.name,
        SUM(detail_transaksi.jumlah) AS total_terjual
     FROM detail_transaksi

     INNER JOIN products
     ON products.id = detail_transaksi.produk_id

     INNER JOIN transaksi
     ON transaksi.id = detail_transaksi.transaksi_id

     WHERE transaksi.status = 'selesai'

     GROUP BY products.id

     ORDER BY total_terjual DESC

     LIMIT 5"
);


// ==========================================================
// CUSTOMER TERBARU
// ==========================================================

// Mengambil 5 customer terbaru
$queryCustomerBaru = mysqli_query(
    $conn,
    "SELECT name, email, created_at
     FROM users
     WHERE role = 'user'
     ORDER BY created_at DESC
     LIMIT 5"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <!-- ==================================================
         PENGATURAN DASAR
    =================================================== -->

    <!-- Mengatur karakter -->
    <meta charset="UTF-8">

    <!-- Membuat tampilan responsive -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- Judul halaman -->
    <title>
        Dashboard Admin | Old Money Coffee
    </title>


    <!-- ==================================================
         CSS DASHBOARD
    =================================================== -->

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

            background: #f7f1e8;

            color: #3b2519;
        }


        /* ==================================================
           SIDEBAR
        ================================================== */

        .sidebar {

            position: fixed;

            left: 0;

            top: 0;

            width: 240px;

            height: 100vh;

            background: #2d1c13;

            padding: 30px 20px;

            color: white;
        }


        /* Logo */
        .logo {

            font-family: Georgia, serif;

            font-size: 21px;

            font-weight: bold;

            text-align: center;

            margin-bottom: 45px;
        }


        /* Judul menu */
        .menu-title {

            color: #bda99a;

            font-size: 10px;

            letter-spacing: 2px;

            margin: 25px 10px 12px;
        }


        /* Link menu */
        .sidebar a {

            display: block;

            color: #d9c8ba;

            text-decoration: none;

            padding: 13px 15px;

            border-radius: 10px;

            font-size: 13px;

            margin-bottom: 5px;

            transition: 0.3s;
        }


        /* Hover menu */
        .sidebar a:hover {

            background: #4b2e1f;

            color: white;
        }


        /* Menu aktif */
        .sidebar a.active {

            background: #4b2e1f;

            color: white;
        }


        /* ==================================================
           MAIN CONTENT
        ================================================== */

        .main {

            margin-left: 240px;

            padding: 35px 45px;
        }


        /* Header dashboard */
        .top {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 35px;
        }


        /* Judul dashboard */
        .top h1 {

            font-family: Georgia, serif;

            font-size: 32px;
        }


        /* Deskripsi */
        .top p {

            color: #806f63;

            font-size: 13px;

            margin-top: 7px;
        }


        /* Badge owner */
        .owner {

            background: white;

            padding: 10px 17px;

            border-radius: 25px;

            font-size: 12px;

            border: 1px solid #eadccd;
        }


        /* ==================================================
           STATISTICS
        ================================================== */

        .stats {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

            margin-bottom: 30px;
        }


        /* Card statistik */
        .stat-card {

            background: #fffaf4;

            border: 1px solid #eadccd;

            border-radius: 18px;

            padding: 23px;
        }


        /* Icon statistik */
        .stat-icon {

            font-size: 25px;

            margin-bottom: 13px;
        }


        /* Label statistik */
        .stat-card h3 {

            font-size: 12px;

            color: #806f63;

            font-weight: normal;

            margin-bottom: 7px;
        }


        /* Angka statistik */
        .stat-card strong {

            font-size: 23px;

            color: #4b2e1f;
        }


        /* ==================================================
           CONTENT GRID
        ================================================== */

        .content-grid {

            display: grid;

            grid-template-columns:
                1.3fr 1fr;

            gap: 25px;

            margin-bottom: 25px;
        }


        /* Panel */
        .panel {

            background: #fffaf4;

            border: 1px solid #eadccd;

            border-radius: 20px;

            padding: 25px;
        }


        /* Header panel */
        .panel-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;
        }


        /* Judul panel */
        .panel-header h2 {

            font-family: Georgia, serif;

            font-size: 22px;
        }


        /* Label panel */
        .panel-header span {

            color: #a45d32;

            font-size: 10px;

            letter-spacing: 1px;
        }


        /* ==================================================
           PRODUK TERLARIS
        ================================================== */

        .product-row {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 15px 0;

            border-bottom: 1px solid #eee3d8;
        }


        /* Menghilangkan border terakhir */
        .product-row:last-child {

            border-bottom: none;
        }


        /* Nama produk */
        .product-name {

            font-size: 13px;

            font-weight: bold;
        }


        /* Jumlah terjual */
        .sold {

            color: #a45d32;

            font-size: 12px;

            font-weight: bold;
        }


        /* ==================================================
           AI BUSINESS INSIGHT
        ================================================== */

        .ai-panel {

            background: #4b2e1f;

            color: white;

            border: none;
        }


        /* Label AI */
        .ai-label {

            color: #e9c9a7;

            font-size: 10px;

            font-weight: bold;

            letter-spacing: 2px;

            margin-bottom: 5px;
        }


        /* Judul AI */
        .ai-panel h2 {

            color: white;
        }


        /* Deskripsi AI */
        .ai-text {

            color: #dfd1c7;

            font-size: 13px;

            line-height: 1.7;

            margin-bottom: 20px;
        }


        /* Box AI */
        .ai-box {

            background:
                rgba(255,255,255,0.08);

            border-radius: 12px;

            padding: 15px;

            margin-bottom: 12px;
        }


        /* Judul box */
        .ai-box strong {

            display: block;

            color: #e9c9a7;

            font-size: 11px;

            margin-bottom: 5px;
        }


        /* Isi box */
        .ai-box p {

            color: #eee1d7;

            font-size: 11px;

            line-height: 1.6;
        }


        /* Tombol AI */
        .ai-button {

            display: block;

            text-align: center;

            background: #e9c9a7;

            color: #4b2e1f;

            padding: 12px;

            border-radius: 25px;

            text-decoration: none;

            font-size: 12px;

            font-weight: bold;

            margin-top: 15px;
        }


        /* ==================================================
           CUSTOMER TERBARU
        ================================================== */

        .customer-row {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 13px 0;

            border-bottom:
                1px solid #eee3d8;
        }


        /* Customer terakhir */
        .customer-row:last-child {

            border-bottom: none;
        }


        /* Nama customer */
        .customer-name {

            font-size: 13px;

            font-weight: bold;
        }


        /* Email */
        .customer-email {

            font-size: 11px;

            color: #806f63;

            margin-top: 3px;
        }


        /* Tanggal */
        .customer-date {

            font-size: 10px;

            color: #a45d32;
        }


        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media (max-width: 1000px) {

            .stats {

                grid-template-columns:
                    repeat(2, 1fr);
            }

            .content-grid {

                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 700px) {

            .sidebar {

                position: relative;

                width: 100%;

                height: auto;
            }


            .main {

                margin-left: 0;

                padding: 25px;
            }


            .stats {

                grid-template-columns: 1fr;
            }


            .top {

                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }

        }

    </style>

</head>


<body>


    <!-- ==================================================
         SIDEBAR ADMIN
    ================================================== -->

    <aside class="sidebar">


        <!-- Logo -->
        <div class="logo">

            ☕ Old Money Coffee

        </div>


        <!-- Menu utama -->
        <div class="menu-title">

            MAIN MENU

        </div>


        <!-- Dashboard -->
        <a
            href="index.php"
            class="active"
        >

            📊 Dashboard

        </a>


        <!-- Produk -->
        <a href="produk.php">

            ☕ Produk

        </a>


        <!-- Customer -->
        <a href="pengguna.php">

            👥 Customer

        </a>


        <!-- Pesanan -->
        <a href="pesanan.php">

            🛒 Pesanan

        </a>


        <!-- Menu analytics -->
        <div class="menu-title">

            ANALYTICS

        </div>


        <!-- Data analytics -->
        <a href="analytics.php">

            📈 Data Analytics

        </a>


        <!-- AI -->
        <a href="ai_insight.php">

            🤖 AI Business Insight

        </a>


        <!-- Laporan -->
        <div class="menu-title">

            REPORT

        </div>


        <a href="laporan.php">

            📋 Laporan

        </a>


    </aside>



    <!-- ==================================================
         MAIN CONTENT
    ================================================== -->

    <main class="main">


        <!-- ==================================================
             HEADER
        ================================================== -->

        <div class="top">

            <div>

                <h1>

                    Dashboard Owner

                </h1>


                <p>

                    Pantau perkembangan Old Money Coffee
                    melalui data bisnis dan perilaku customer.

                </p>

            </div>


            <div class="admin">

                👤 Admin

            </div>

        </div>



        <!-- ==================================================
             STATISTIK
        ================================================== -->

        <section class="stats">


            <!-- Total customer -->
            <div class="stat-card">

                <div class="stat-icon">

                    👥

                </div>


                <h3>

                    Total Customer

                </h3>


                <strong>

                    <?php

                    // Menampilkan jumlah customer
                    echo $totalCustomer;

                    ?>

                </strong>

            </div>


            <!-- Total produk -->
            <div class="stat-card">

                <div class="stat-icon">

                    ☕

                </div>


                <h3>

                    Total Produk

                </h3>


                <strong>

                    <?php

                    // Menampilkan jumlah produk
                    echo $totalProduk;

                    ?>

                </strong>

            </div>


            <!-- Total transaksi -->
            <div class="stat-card">

                <div class="stat-icon">

                    🛒

                </div>


                <h3>

                    Total Transaksi

                </h3>


                <strong>

                    <?php

                    // Menampilkan jumlah transaksi
                    echo $totalTransaksi;

                    ?>

                </strong>

            </div>


            <!-- Total pendapatan -->
            <div class="stat-card">

                <div class="stat-icon">

                    💰

                </div>


                <h3>

                    Pendapatan

                </h3>


                <strong>

                    Rp

                    <?php

                    // Menampilkan pendapatan
                    echo number_format(
                        $totalPendapatan,
                        0,
                        ',',
                        '.'
                    );

                    ?>

                </strong>

            </div>


        </section>



        <!-- ==================================================
             PRODUK TERLARIS + AI
        ================================================== -->

        <section class="content-grid">


            <!-- ==================================================
                 PRODUK TERLARIS
            ================================================== -->

            <div class="panel">


                <div class="panel-header">

                    <h2>

                        ☕ Produk Terlaris

                    </h2>


                    <span>

                        DATA PENJUALAN

                    </span>

                </div>


                <?php

                // Mengecek apakah data tersedia
                if (
                    $queryTerlaris &&
                    mysqli_num_rows($queryTerlaris) > 0
                ):

                    // Mengambil data produk satu per satu
                    while (
                        $produk =
                        mysqli_fetch_assoc($queryTerlaris)
                    ):

                ?>


                    <div class="product-row">


                        <div>

                            <div class="product-name">

                                <?php

                                // Nama produk
                                echo htmlspecialchars(
                                    $produk['name']
                                );

                                ?>

                            </div>

                        </div>


                        <div class="sold">

                            <?php

                            // Jumlah produk terjual
                            echo $produk['total_terjual'];

                            ?>

                            terjual

                        </div>


                    </div>


                <?php

                    endwhile;

                else:

                ?>


                    <p
                        style="
                            color:#806f63;
                            font-size:13px;
                        "
                    >

                        Belum ada data penjualan.

                    </p>


                <?php

                endif;

                ?>


            </div>



            <!-- ==================================================
                 AI BUSINESS INSIGHT
            ================================================== -->

            <div class="panel ai-panel">


                <div class="panel-header">

                    <div>

                        <div class="ai-label">

                            SMART AI

                        </div>


                        <h2>

                            Business Insight

                        </h2>

                    </div>


                    <span>

                        🤖

                    </span>

                </div>


                <p class="ai-text">

                    Sistem menganalisis data penjualan,
                    aktivitas customer, rating, dan
                    produk untuk membantu owner memahami
                    kondisi bisnis.

                </p>


                <div class="ai-box">

                    <strong>

                        📊 DATA ANALYSIS

                    </strong>


                    <p>

                        Menganalisis produk yang paling
                        sering dibeli oleh customer.

                    </p>

                </div>


                <div class="ai-box">

                    <strong>

                        👥 CUSTOMER BEHAVIOR

                    </strong>


                    <p>

                        Menganalisis aktivitas dan
                        preferensi customer.

                    </p>

                </div>


                <div class="ai-box">

                    <strong>

                        🔮 BUSINESS PREDICTION

                    </strong>


                    <p>

                        Menggunakan data historis untuk
                        membantu melihat pola penjualan.

                    </p>

                </div>


                <a
                    href="ai_insight.php"
                    class="ai-button"
                >

                    ✨ Buka AI Business Insight

                </a>


            </div>


        </section>



        <!-- ==================================================
             CUSTOMER TERBARU
        ================================================== -->

        <section class="panel">


            <div class="panel-header">

                <h2>

                    👥 Customer Terbaru

                </h2>


                <span>

                    USER DATA

                </span>

            </div>


            <?php

            // Mengecek apakah terdapat customer
            if (
                $queryCustomerBaru &&
                mysqli_num_rows($queryCustomerBaru) > 0
            ):

                // Menampilkan customer satu per satu
                while (
                    $customer =
                    mysqli_fetch_assoc($queryCustomerBaru)
                ):

            ?>


                <div class="customer-row">


                    <div>

                        <div class="customer-name">

                            <?php

                            // Menampilkan nama customer
                            echo htmlspecialchars(
                                $customer['name']
                            );

                            ?>

                        </div>


                        <div class="customer-email">

                            <?php

                            // Menampilkan email customer
                            echo htmlspecialchars(
                                $customer['email']
                            );

                            ?>

                        </div>

                    </div>


                    <div class="customer-date">

                        <?php

                        // Menampilkan tanggal daftar
                        echo date(
                            'd M Y',
                            strtotime(
                                $customer['created_at']
                            )
                        );

                        ?>

                    </div>


                </div>


            <?php

                endwhile;

            else:

            ?>


                <p
                    style="
                        color:#806f63;
                        font-size:13px;
                    "
                >

                    Belum ada customer.

                </p>


            <?php

            endif;

            ?>


        </section>


    </main>


</body>

</html>
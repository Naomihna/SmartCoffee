<?php
// ======================================================
// MENU.PHP - HALAMAN DAFTAR MENU OLD MONEY COFFEE
// ======================================================

// Menghubungkan halaman dengan database
require_once "../config/database.php";

// ======================================================
// MENGAMBIL DATA PRODUK DARI DATABASE
// ======================================================

// Query mengambil semua produk
$query = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu | Old Money Coffee</title>

    <style>

        /* ==================================================
           RESET
        ================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Georgia, 'Times New Roman', serif;
            background: #f7f1e8;
            color: #3a2a20;
        }

        /* ==================================================
           NAVBAR
        ================================================== */

        nav {
            height: 75px;
            background: #3a2a20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 8%;
        }

        .logo {
            color: #f5e8d3;
            font-size: 25px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        .nav-menu a {
            color: #f5e8d3;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .nav-menu a:hover,
        .nav-menu .active {
            color: #c5a46d;
        }

        /* ==================================================
           HEADER MENU
        ================================================== */

        .menu-header {
            text-align: center;
            padding: 70px 20px 40px;
        }

        .menu-header p {
            color: #a08058;
            letter-spacing: 3px;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .menu-header h1 {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .menu-header span {
            color: #76583e;
            font-family: Arial, sans-serif;
            font-size: 15px;
        }

        /* ==================================================
           PRODUCT GRID
        ================================================== */

        .products {
            width: 84%;
            max-width: 1200px;
            margin: auto;

            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;

            padding-bottom: 70px;
        }

        /* ==================================================
           CARD PRODUK
        ================================================== */

        .card {
            background: #fffdf9;
            border-radius: 12px;
            overflow: hidden;

            box-shadow: 0 5px 20px rgba(58, 42, 32, 0.10);

            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(58, 42, 32, 0.18);
        }

        .card-image {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .card-content {
            padding: 20px;
        }

        .category {
            color: #a08058;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-family: Arial, sans-serif;
        }

        .card h3 {
            margin: 8px 0;
            font-size: 21px;
        }

        .description {
            color: #76695e;
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.6;
            min-height: 42px;
        }

        .bottom-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 18px;
        }

        .price {
            font-weight: bold;
            color: #6f4e37;
            font-family: Arial, sans-serif;
        }

        .btn-detail {
            background: #3a2a20;
            color: white;
            text-decoration: none;

            padding: 9px 15px;
            border-radius: 6px;

            font-family: Arial, sans-serif;
            font-size: 12px;

            transition: 0.3s;
        }

        .btn-detail:hover {
            background: #76583e;
        }

        /* ==================================================
           JIKA PRODUK KOSONG
        ================================================== */

        .empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px;
            font-family: Arial, sans-serif;
        }

        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media (max-width: 900px) {
            .products {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {

            nav {
                padding: 0 5%;
            }

            .nav-menu {
                gap: 12px;
            }

            .nav-menu a {
                font-size: 12px;
            }

            .products {
                grid-template-columns: 1fr;
                width: 90%;
            }

            .menu-header h1 {
                font-size: 32px;
            }
        }

    </style>
</head>

<body>

<!-- ======================================================
     NAVBAR
====================================================== -->

<nav>

    <!-- Nama coffee shop -->
    <div class="logo">
        Old Money Coffee
    </div>

    <!-- Menu navigasi -->
    <ul class="nav-menu">

        <li>
            <a href="../index.php">
                Home
            </a>
        </li>

        <li>
            <a href="menu.php" class="active">
                Menu
            </a>
        </li>

        <li>
            <a href="rekomendasi.php">
                Rekomendasi
            </a>
        </li>

    </ul>

</nav>


<!-- ======================================================
     HEADER
====================================================== -->

<section class="menu-header">

    <p>OUR SELECTION</p>

    <h1>Menu Old Money Coffee</h1>

    <span>
        Pilihan kopi dan hidangan untuk menemani setiap momen.
    </span>

</section>


<!-- ======================================================
     DAFTAR PRODUK
====================================================== -->

<section class="products">

<?php if ($result && $result->num_rows > 0): ?>

    <?php while ($product = $result->fetch_assoc()): ?>

        <div class="card">

            <!-- Foto produk -->
            <img
                src="<?php echo !empty($product['image'])
                    ? htmlspecialchars($product['image'])
                    : 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800'; ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>"
                class="card-image"
            >

            <div class="card-content">

                <!-- Kategori -->
                <div class="category">
                    <?php echo htmlspecialchars($product['category_id']); ?>
                </div>

                <!-- Nama produk -->
                <h3>
                    <?php echo htmlspecialchars($product['name']); ?>
                </h3>

                <!-- Deskripsi -->
                <p class="description">
                    <?php
                    echo !empty($product['description'])
                        ? htmlspecialchars($product['description'])
                        : "Nikmati pilihan terbaik dari Old Money Coffee.";
                    ?>
                </p>

                <div class="bottom-card">

                    <!-- Harga -->
                    <div class="price">
                        Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                    </div>

                    <!-- Tombol detail -->
                    <a
                        href="detail.php?id=<?php echo $product['id']; ?>"
                        class="btn-detail"
                    >
                        Lihat Detail
                    </a>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

<?php else: ?>

    <div class="empty">
        <h3>Menu belum tersedia.</h3>
        <p>Silakan tambahkan produk melalui database.</p>
    </div>

<?php endif; ?>

</section>

</body>
</html>
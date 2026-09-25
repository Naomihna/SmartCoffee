<?php
// ==========================================================
// REKOMENDASI.PHP
// Old Money Coffee
// Sistem rekomendasi menu berdasarkan preferensi pengguna
// ==========================================================

require_once "../config/database.php";

// Menyimpan pilihan kategori dari user
$preference = isset($_GET['preference'])
    ? $_GET['preference']
    : '';

// Data menu sementara untuk sistem rekomendasi
// Nanti bisa kita pindahkan sepenuhnya ke database.
$menus = [

    [
        'name' => 'Cappuccino',
        'category' => 'coffee',
        'price' => 22000,
        'description' => 'Espresso dengan susu dan foam yang creamy.',
        'image' => 'https://images.unsplash.com/photo-1572449043416-55f4685c9bb7?auto=format&fit=crop&w=700&q=80'
    ],

    [
        'name' => 'Cafe Latte',
        'category' => 'coffee',
        'price' => 22000,
        'description' => 'Espresso dengan susu lembut dan creamy.',
        'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=700&q=80'
    ],

    [
        'name' => 'Americano',
        'category' => 'coffee',
        'price' => 18000,
        'description' => 'Espresso dengan air yang memiliki rasa kopi kuat.',
        'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=700&q=80'
    ],

    [
        'name' => 'Matcha Latte',
        'category' => 'non-coffee',
        'price' => 25000,
        'description' => 'Matcha dengan susu creamy dan rasa yang lembut.',
        'image' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?auto=format&fit=crop&w=700&q=80'
    ],

    [
        'name' => 'Chocolate Latte',
        'category' => 'non-coffee',
        'price' => 24000,
        'description' => 'Cokelat creamy dengan rasa manis yang seimbang.',
        'image' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?auto=format&fit=crop&w=700&q=80'
    ]

];


// ==========================================================
// FILTER REKOMENDASI
// ==========================================================

$recommendations = [];

if ($preference !== '') {

    foreach ($menus as $menu) {

        if ($menu['category'] === $preference) {
            $recommendations[] = $menu;
        }

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Rekomendasi | Old Money Coffee
    </title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
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

        }


        .logo {

            color: #4b2e1f;

            font-family: Georgia, serif;

            font-size: 24px;

            font-weight: bold;

        }


        .back {

            color: #715b4b;

            text-decoration: none;

            font-size: 14px;

        }


        .back:hover {

            color: #a45d32;

        }


        /* ==================================================
           HEADER
        ================================================== */

        .header {

            text-align: center;

            padding: 70px 20px 40px;

        }


        .label {

            color: #a45d32;

            font-size: 12px;

            letter-spacing: 3px;

            font-weight: bold;

            margin-bottom: 15px;

        }


        .header h1 {

            font-family: Georgia, serif;

            font-size: 45px;

            margin-bottom: 15px;

        }


        .header h1 span {

            color: #a45d32;

        }


        .header p {

            color: #756256;

            font-size: 14px;

            line-height: 1.7;

        }


        /* ==================================================
           PREFERENCE
        ================================================== */

        .preferences {

            width: 85%;

            max-width: 900px;

            margin: 0 auto 60px;

            text-align: center;

        }


        .preferences h2 {

            font-family: Georgia, serif;

            margin-bottom: 25px;

        }


        .buttons {

            display: flex;

            justify-content: center;

            gap: 15px;

            flex-wrap: wrap;

        }


        .preference-button {

            padding: 13px 25px;

            border-radius: 30px;

            border: 1px solid #8e705d;

            background: transparent;

            color: #4b2e1f;

            text-decoration: none;

            font-size: 13px;

            transition: 0.3s;

        }


        .preference-button:hover {

            background: #4b2e1f;

            color: white;

        }


        /* ==================================================
           RESULT
        ================================================== */

        .result {

            width: 85%;

            max-width: 1100px;

            margin: auto;

            padding-bottom: 100px;

        }


        .result-title {

            text-align: center;

            margin-bottom: 30px;

        }


        .result-title h2 {

            font-family: Georgia, serif;

            font-size: 32px;

        }


        .result-title p {

            color: #806f63;

            font-size: 13px;

            margin-top: 8px;

        }


        .products {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 25px;

        }


        .card {

            background: #fffaf4;

            border: 1px solid #eadccd;

            border-radius: 20px;

            overflow: hidden;

            transition: 0.3s;

        }


        .card:hover {

            transform: translateY(-7px);

            box-shadow: 0 20px 35px rgba(65, 38, 20, 0.12);

        }


        .card img {

            width: 100%;

            height: 230px;

            object-fit: cover;

        }


        .card-content {

            padding: 22px;

        }


        .category {

            color: #a45d32;

            font-size: 10px;

            font-weight: bold;

            letter-spacing: 2px;

        }


        .card h3 {

            font-family: Georgia, serif;

            font-size: 23px;

            margin: 8px 0;

        }


        .card p {

            color: #806f63;

            font-size: 13px;

            line-height: 1.6;

            margin-bottom: 15px;

        }


        .price {

            color: #4b2e1f;

            font-weight: bold;

        }


        /* ==================================================
           EMPTY
        ================================================== */

        .empty {

            background: #fffaf4;

            border: 1px solid #eadccd;

            padding: 45px;

            border-radius: 20px;

            text-align: center;

            color: #806f63;

        }


        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media (max-width: 800px) {

            .products {

                grid-template-columns: 1fr;

            }

            .header h1 {

                font-size: 34px;

            }

        }

    </style>

</head>


<body>


<!-- ======================================================
     NAVBAR
====================================================== -->

<header class="navbar">

    <div class="logo">
        ☕ Old Money Coffee
    </div>

    <a href="../index.php" class="back">
        ← Kembali ke Home
    </a>

</header>


<!-- ======================================================
     HEADER
====================================================== -->

<section class="header">

    <div class="label">
        SMART RECOMMENDATION
    </div>

    <h1>
        Find Your
        <span>Perfect Coffee.</span>
    </h1>

    <p>
        Pilih jenis minuman yang sedang kamu inginkan,
        lalu sistem akan memberikan rekomendasi menu
        yang sesuai dengan preferensimu.
    </p>

</section>


<!-- ======================================================
     PILIH PREFERENSI
====================================================== -->

<section class="preferences">

    <h2>
        What are you craving?
    </h2>

    <div class="buttons">

        <a
            href="rekomendasi.php?preference=coffee"
            class="preference-button"
        >
            ☕ Coffee
        </a>


        <a
            href="rekomendasi.php?preference=non-coffee"
            class="preference-button"
        >
            🍵 Non Coffee
        </a>
         
        <a
            href="rekomendasi.php?preference=Snack"
            class="preference-button"
        >
            🍨 Snack
        </a>

    </div>

</section>


<!-- ======================================================
     HASIL REKOMENDASI
====================================================== -->

<section class="result">

<?php if ($preference !== '' && count($recommendations) > 0): ?>

    <div class="result-title">

        <h2>
            Recommended For You 🤎
        </h2>

        <p>
            Berdasarkan preferensi yang kamu pilih.
        </p>

    </div>


    <div class="products">

        <?php foreach ($recommendations as $menu): ?>

            <div class="card">

                <img
                    src="<?php echo $menu['image']; ?>"
                    alt="<?php echo $menu['name']; ?>"
                >

                <div class="card-content">

                    <div class="category">

                        <?php
                        echo strtoupper($menu['category']);
                        ?>

                    </div>

                    <h3>
                        <?php
                        echo $menu['name'];
                        ?>
                    </h3>

                    <p>
                        <?php
                        echo $menu['description'];
                        ?>
                    </p>

                    <div class="price">

                        Rp
                        <?php
                        echo number_format(
                            $menu['price'],
                            0,
                            ',',
                            '.'
                        );
                        ?>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>


<?php else: ?>


    <div class="empty">

        <h3>
            ☕ Belum ada pilihan
        </h3>

        <p>
            Pilih kategori minuman di atas
            untuk mendapatkan rekomendasi.
        </p>

    </div>


<?php endif; ?>

</section>


</body>

</html>
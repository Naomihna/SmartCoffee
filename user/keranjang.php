<?php

session_start();

/*
|--------------------------------------------------------------------------
| DATA PRODUK SEMENTARA
|--------------------------------------------------------------------------
| Nanti kalau database products sudah siap,
| bagian ini bisa diganti dengan query database.
*/

$products = [

    1 => [
        "name" => "Cafe Latte",
        "price" => 22000,
        "image" => "https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=700&q=80"
    ],

    2 => [
        "name" => "Cappuccino",
        "price" => 22000,
        "image" => "https://images.unsplash.com/photo-1572449043416-55f4685c9bb7?auto=format&fit=crop&w=700&q=80"
    ],

    3 => [
        "name" => "Matcha Latte",
        "price" => 25000,
        "image" => "https://images.unsplash.com/photo-1515823064-d6e0c04616a7?auto=format&fit=crop&w=700&q=80"
    ]

];


/*
|--------------------------------------------------------------------------
| MEMBUAT SESSION KERANJANG
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


/*
|--------------------------------------------------------------------------
| TAMBAH PRODUK
|--------------------------------------------------------------------------
*/

if (isset($_GET['action']) && $_GET['action'] === 'add') {

    $productId = (int) ($_GET['id'] ?? 0);

    if (isset($products[$productId])) {

        if (isset($_SESSION['cart'][$productId])) {

            $_SESSION['cart'][$productId]++;

        } else {

            $_SESSION['cart'][$productId] = 1;

        }
    }

    header("Location: keranjang.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| KURANGI QUANTITY
|--------------------------------------------------------------------------
*/

if (isset($_GET['action']) && $_GET['action'] === 'minus') {

    $productId = (int) ($_GET['id'] ?? 0);

    if (isset($_SESSION['cart'][$productId])) {

        $_SESSION['cart'][$productId]--;

        if ($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    header("Location: keranjang.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| HAPUS PRODUK
|--------------------------------------------------------------------------
*/

if (isset($_GET['action']) && $_GET['action'] === 'remove') {

    $productId = (int) ($_GET['id'] ?? 0);

    unset($_SESSION['cart'][$productId]);

    header("Location: keranjang.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| HITUNG TOTAL
|--------------------------------------------------------------------------
*/

$total = 0;

foreach ($_SESSION['cart'] as $productId => $quantity) {

    if (isset($products[$productId])) {

        $total +=
            $products[$productId]['price']
            * $quantity;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Keranjang | OldMoneyCoffee</title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            font-family: Arial, sans-serif;

            background: #f8f2e9;

            color: #3b2519;

        }


        /* NAVBAR */

        .navbar {

            height: 78px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 7%;

            background: #f8f2e9;

            border-bottom: 1px solid #eadccd;

        }


        .logo {

            color: #4b2e1f;

            font-size: 24px;

            font-weight: bold;

            text-decoration: none;

        }


        .back-button {

            text-decoration: none;

            color: #4b2e1f;

            font-weight: bold;

            font-size: 14px;

        }


        /* CONTAINER */

        .container {

            width: 86%;

            max-width: 1100px;

            margin: 60px auto;

        }


        .title {

            margin-bottom: 30px;

        }


        .title p {

            color: #a45d32;

            font-size: 12px;

            font-weight: bold;

            letter-spacing: 3px;

            margin-bottom: 8px;

        }


        .title h1 {

            font-family: Georgia, serif;

            font-size: 42px;

        }


        /* CART */

        .cart-wrapper {

            display: grid;

            grid-template-columns: 1fr 330px;

            gap: 30px;

        }


        .cart-list {

            background: #fffaf4;

            border: 1px solid #eadccd;

            border-radius: 20px;

            padding: 20px;

        }


        .cart-item {

            display: flex;

            align-items: center;

            gap: 20px;

            padding: 20px 0;

            border-bottom: 1px solid #eadccd;

        }


        .cart-item:last-child {

            border-bottom: none;

        }


        .cart-item img {

            width: 100px;

            height: 100px;

            object-fit: cover;

            border-radius: 15px;

        }


        .item-info {

            flex: 1;

        }


        .item-info h3 {

            font-family: Georgia, serif;

            font-size: 21px;

            margin-bottom: 8px;

        }


        .item-price {

            color: #806f63;

            font-size: 14px;

        }


        .quantity {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .quantity a {

            width: 30px;

            height: 30px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #4b2e1f;

            color: white;

            border-radius: 50%;

            text-decoration: none;

            font-weight: bold;

        }


        .quantity span {

            font-weight: bold;

            min-width: 20px;

            text-align: center;

        }


        .item-total {

            width: 100px;

            text-align: right;

            font-weight: bold;

            color: #4b2e1f;

        }


        .remove {

            color: #a04b3d;

            text-decoration: none;

            font-size: 12px;

        }


        /* SUMMARY */

        .summary {

            background: #4b2e1f;

            color: white;

            border-radius: 20px;

            padding: 28px;

            height: fit-content;

        }


        .summary h2 {

            font-family: Georgia, serif;

            margin-bottom: 25px;

        }


        .summary-row {

            display: flex;

            justify-content: space-between;

            margin-bottom: 15px;

            color: #eadccd;

        }


        .summary-total {

            display: flex;

            justify-content: space-between;

            border-top: 1px solid rgba(255,255,255,.2);

            padding-top: 20px;

            margin-top: 20px;

            font-size: 19px;

            font-weight: bold;

        }


        .checkout {

            display: block;

            text-align: center;

            background: #e9c9a7;

            color: #4b2e1f;

            padding: 14px;

            border-radius: 25px;

            margin-top: 25px;

            text-decoration: none;

            font-weight: bold;

        }


        /* EMPTY */

        .empty {

            text-align: center;

            padding: 70px 20px;

        }


        .empty-icon {

            font-size: 60px;

            margin-bottom: 20px;

        }


        .empty h2 {

            font-family: Georgia, serif;

            margin-bottom: 10px;

        }


        .empty p {

            color: #806f63;

            margin-bottom: 25px;

        }


        .menu-button {

            display: inline-block;

            background: #4b2e1f;

            color: white;

            padding: 13px 25px;

            border-radius: 25px;

            text-decoration: none;

        }


        @media (max-width: 800px) {

            .cart-wrapper {

                grid-template-columns: 1fr;

            }

            .cart-item {

                flex-wrap: wrap;

            }

            .item-total {

                width: auto;

            }

        }

    </style>

</head>


<body>


<header class="navbar">

    <a href="../index.php" class="logo">
        ☕ OldMoneyCoffee
    </a>

    <a href="../index.php" class="back-button">
        ← Kembali ke Home
    </a>

</header>


<div class="container">


    <div class="title">

        <p>YOUR ORDER</p>

        <h1>Keranjang</h1>

    </div>


    <?php if (empty($_SESSION['cart'])): ?>


        <!-- KERANJANG KOSONG -->

        <div class="cart-list">

            <div class="empty">

                <div class="empty-icon">
                    🛒
                </div>

                <h2>
                    Keranjang masih kosong
                </h2>

                <p>
                    Yuk pilih kopi favorit kamu.
                </p>

                <a
                    href="menu.php"
                    class="menu-button"
                >
                    Lihat Menu
                </a>

            </div>

        </div>


    <?php else: ?>


        <div class="cart-wrapper">


            <!-- DAFTAR PRODUK -->

            <div class="cart-list">


                <?php foreach ($_SESSION['cart'] as $productId => $quantity): ?>

                    <?php

                    if (!isset($products[$productId])) {
                        continue;
                    }

                    $product = $products[$productId];

                    $subtotal =
                        $product['price'] * $quantity;

                    ?>


                    <div class="cart-item">


                        <img
                            src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                        >


                        <div class="item-info">

                            <h3>
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>

                            <div class="item-price">

                                Rp<?= number_format(
                                    $product['price'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>

                            </div>

                        </div>


                        <div class="quantity">

                            <a
                                href="keranjang.php?action=minus&id=<?= $productId ?>"
                            >
                                −
                            </a>

                            <span>
                                <?= $quantity ?>
                            </span>

                            <a
                                href="keranjang.php?action=add&id=<?= $productId ?>"
                            >
                                +
                            </a>

                        </div>


                        <div class="item-total">

                            Rp<?= number_format(
                                $subtotal,
                                0,
                                ',',
                                '.'
                            ) ?>

                        </div>


                        <a
                            href="keranjang.php?action=remove&id=<?= $productId ?>"
                            class="remove"
                        >
                            Hapus
                        </a>


                    </div>


                <?php endforeach; ?>


            </div>


            <!-- RINGKASAN -->

            <div class="summary">

                <h2>
                    Ringkasan Pesanan
                </h2>


                <div class="summary-row">

                    <span>
                        Subtotal
                    </span>

                    <span>
                        Rp<?= number_format(
                            $total,
                            0,
                            ',',
                            '.'
                        ) ?>
                    </span>

                </div>


                <div class="summary-row">

                    <span>
                        Biaya layanan
                    </span>

                    <span>
                        Rp0
                    </span>

                </div>


                <div class="summary-total">

                    <span>
                        Total
                    </span>

                    <span>
                        Rp<?= number_format(
                            $total,
                            0,
                            ',',
                            '.'
                        ) ?>
                    </span>

                </div>


                <a
                    href="checkout.php"
                    class="checkout"
                >
                    Lanjut Checkout
                </a>

            </div>


        </div>


    <?php endif; ?>


</div>


</body>

</html>
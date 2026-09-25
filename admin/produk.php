<?php

// ==========================================================
// OLD MONEY COFFEE
// ADMIN - KELOLA PRODUK
// ==========================================================

// Memanggil koneksi database
require_once "../config/database.php";


// ==========================================================
// PROSES HAPUS PRODUK
// ==========================================================

if (isset($_GET['hapus'])) {

    // Mengambil ID produk dari URL
    $id = (int) $_GET['hapus'];

    // Menghapus produk berdasarkan ID
    mysqli_query(
        $conn,
        "DELETE FROM products WHERE id = $id"
    );

    // Kembali ke halaman produk
    header("Location: produk.php?status=hapus");
    exit;
}


// ==========================================================
// PROSES TAMBAH PRODUK
// ==========================================================

if (isset($_POST['tambah_produk'])) {

    // Mengambil data dari form
    $category_id = (int) $_POST['category_id'];
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = (float) $_POST['price'];
    $image       = $_POST['image'];
    $video       = $_POST['video'];
    $flavor      = $_POST['flavor'];
    $stock       = (int) $_POST['stock'];

    // Query untuk menambahkan produk
    $query = mysqli_query(
        $conn,
        "INSERT INTO products
        (
            category_id,
            name,
            description,
            price,
            image,
            video,
            flavor,
            stock
        )
        VALUES
        (
            '$category_id',
            '$name',
            '$description',
            '$price',
            '$image',
            '$video',
            '$flavor',
            '$stock'
        )"
    );

    // Mengecek hasil tambah produk
    if ($query) {

        header("Location: produk.php?status=tambah");
        exit;

    } else {

        $error = "Produk gagal ditambahkan.";

    }
}


// ==========================================================
// PROSES EDIT PRODUK
// ==========================================================

if (isset($_POST['edit_produk'])) {

    // Mengambil ID produk
    $id = (int) $_POST['id'];

    // Mengambil data terbaru dari form
    $category_id = (int) $_POST['category_id'];
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = (float) $_POST['price'];
    $image       = $_POST['image'];
    $video       = $_POST['video'];
    $flavor      = $_POST['flavor'];
    $stock       = (int) $_POST['stock'];

    // Update data produk
    $query = mysqli_query(
        $conn,
        "UPDATE products SET

            category_id = '$category_id',
            name = '$name',
            description = '$description',
            price = '$price',
            image = '$image',
            video = '$video',
            flavor = '$flavor',
            stock = '$stock'

        WHERE id = $id"
    );

    // Mengecek hasil update
    if ($query) {

        header("Location: produk.php?status=edit");
        exit;

    } else {

        $error = "Produk gagal diperbarui.";

    }
}


// ==========================================================
// MODE EDIT
// ==========================================================

// Mengecek apakah admin sedang memilih produk untuk diedit
$produkEdit = null;

if (isset($_GET['edit'])) {

    // Mengambil ID produk
    $idEdit = (int) $_GET['edit'];

    // Mengambil data produk
    $hasilEdit = mysqli_query(
        $conn,
        "SELECT *
         FROM products
         WHERE id = $idEdit"
    );

    // Menyimpan data produk
    $produkEdit = mysqli_fetch_assoc($hasilEdit);
}


// ==========================================================
// MENGAMBIL DATA KATEGORI
// ==========================================================

$queryKategori = mysqli_query(
    $conn,
    "SELECT *
     FROM categories
     ORDER BY id ASC"
);


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

    <!-- Pengaturan dasar -->
    <meta charset="UTF-8">

    <!-- Responsive -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- Judul halaman -->
    <title>
        Kelola Produk | Old Money Coffee
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


        .logo {

            font-family: Georgia, serif;

            font-size: 21px;

            font-weight: bold;

            text-align: center;

            margin-bottom: 45px;

        }


        .menu-title {

            color: #bda99a;

            font-size: 10px;

            letter-spacing: 2px;

            margin: 25px 10px 12px;

        }


        .sidebar a {

            display: block;

            color: #d9c8ba;

            text-decoration: none;

            padding: 13px 15px;

            border-radius: 10px;

            font-size: 13px;

            margin-bottom: 5px;

        }


        .sidebar a:hover,
        .sidebar a.active {

            background: #4b2e1f;

            color: white;

        }


        /* ==================================================
           MAIN
        ================================================== */

        .main {

            margin-left: 240px;

            padding: 35px 45px;

        }


        .header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 30px;

        }


        .header h1 {

            font-family: Georgia, serif;

            font-size: 32px;

        }


        .header p {

            color: #806f63;

            font-size: 13px;

            margin-top: 7px;

        }


        /* ==================================================
           TOMBOL
        ================================================== */

        .btn-add,
        .btn-save {

            border: none;

            background: #4b2e1f;

            color: white;

            padding: 12px 20px;

            border-radius: 25px;

            cursor: pointer;

            font-weight: bold;

        }


        .btn-add:hover,
        .btn-save:hover {

            background: #7b4a2d;

        }


        .btn-cancel {

            display: inline-block;

            margin-left: 8px;

            padding: 12px 20px;

            border-radius: 25px;

            background: #eadccd;

            color: #4b2e1f;

            text-decoration: none;

            font-size: 13px;

            font-weight: bold;

        }


        /* ==================================================
           FORM
        ================================================== */

        .form-box {

            background: #fffaf4;

            border: 1px solid #eadccd;

            border-radius: 20px;

            padding: 25px;

            margin-bottom: 30px;

        }


        .form-box h2 {

            font-family: Georgia, serif;

            margin-bottom: 20px;

        }


        .form-grid {

            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 15px;

        }


        .form-group {

            display: flex;

            flex-direction: column;

            gap: 7px;

        }


        .form-group.full {

            grid-column: 1 / -1;

        }


        .form-group label {

            font-size: 12px;

            font-weight: bold;

        }


        .form-group input,
        .form-group textarea,
        .form-group select {

            padding: 12px;

            border: 1px solid #dfd0c3;

            border-radius: 10px;

            background: white;

            outline: none;

        }


        .form-group textarea {

            min-height: 90px;

            resize: vertical;

        }


        /* ==================================================
           TABEL
        ================================================== */

        .table-box {

            background: #fffaf4;

            border: 1px solid #eadccd;

            border-radius: 20px;

            padding: 25px;

            overflow-x: auto;

        }


        .table-box h2 {

            font-family: Georgia, serif;

            margin-bottom: 20px;

        }


        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 850px;

        }


        th {

            text-align: left;

            padding: 13px;

            background: #f1e6d9;

            font-size: 11px;

        }


        td {

            padding: 13px;

            border-bottom: 1px solid #eee3d8;

            font-size: 12px;

        }


        .product-img {

            width: 55px;

            height: 55px;

            object-fit: cover;

            border-radius: 10px;

        }


        .price {

            font-weight: bold;

            color: #4b2e1f;

        }


        .edit {

            background: #e9c9a7;

            color: #4b2e1f;

            padding: 7px 11px;

            border-radius: 8px;

            text-decoration: none;

            font-size: 11px;

        }


        .delete {

            background: #ead1cc;

            color: #7b3025;

            padding: 7px 11px;

            border-radius: 8px;

            text-decoration: none;

            font-size: 11px;

        }


        /* ==================================================
           NOTIFIKASI
        ================================================== */

        .success {

            background: #e3f0e2;

            color: #356238;

            padding: 12px 15px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-size: 13px;

        }


        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media (max-width: 800px) {

            .sidebar {

                position: relative;

                width: 100%;

                height: auto;

            }


            .main {

                margin-left: 0;

                padding: 25px;

            }


            .form-grid {

                grid-template-columns: 1fr;

            }


            .form-group.full {

                grid-column: auto;

            }


            .header {

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

        <div class="logo">

            ☕ Old Money Coffee

        </div>


        <div class="menu-title">
            MAIN MENU
        </div>


        <a href="index.php">
            📊 Dashboard
        </a>


        <a
            href="produk.php"
            class="active"
        >
            ☕ Produk
        </a>


        <a href="pengguna.php">
            👥 Customer
        </a>


        <a href="pesanan.php">
            🛒 Pesanan
        </a>


        <div class="menu-title">
            ANALYTICS
        </div>


        <a href="analytics.php">
            📈 Data Analytics
        </a>


        <a href="ai_insight.php">
            🤖 AI Business Insight
        </a>


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


        <!-- HEADER -->
        <div class="header">

            <div>

                <h1>
                    Kelola Produk
                </h1>

                <p>
                    Kelola produk yang akan ditampilkan
                    kepada customer.
                </p>

            </div>


            <a
                href="produk.php#formProduk"
                class="btn-add"
            >

                + Tambah Produk

            </a>

        </div>



        <!-- ==================================================
             NOTIFIKASI
        ================================================== -->

        <?php if (isset($_GET['status'])): ?>

            <div class="success">

                <?php

                if ($_GET['status'] == 'tambah') {

                    echo "Produk berhasil ditambahkan.";

                }

                elseif ($_GET['status'] == 'edit') {

                    echo "Produk berhasil diperbarui.";

                }

                elseif ($_GET['status'] == 'hapus') {

                    echo "Produk berhasil dihapus.";

                }

                ?>

            </div>

        <?php endif; ?>



        <!-- ==================================================
             FORM TAMBAH / EDIT
        ================================================== -->

        <section
            class="form-box"
            id="formProduk"
        >

            <h2>

                <?php

                if ($produkEdit) {

                    echo "Edit Produk";

                } else {

                    echo "Tambah Produk";

                }

                ?>

            </h2>


            <form method="POST">


                <!-- ID hanya digunakan saat EDIT -->

                <?php if ($produkEdit): ?>

                    <input
                        type="hidden"
                        name="id"
                        value="<?php
                            echo $produkEdit['id'];
                        ?>"
                    >

                <?php endif; ?>


                <div class="form-grid">


                    <!-- KATEGORI -->

                    <div class="form-group">

                        <label>
                            Kategori
                        </label>


                        <select
                            name="category_id"
                            required
                        >

                            <option value="">
                                Pilih Kategori
                            </option>


                            <?php

                            // Reset pointer kategori
                            mysqli_data_seek(
                                $queryKategori,
                                0
                            );

                            while (
                                $kategori =
                                mysqli_fetch_assoc(
                                    $queryKategori
                                )
                            ):

                            ?>

                                <option
                                    value="<?php
                                        echo $kategori['id'];
                                    ?>"
                                    <?php

                                    if (
                                        $produkEdit &&
                                        $produkEdit['category_id']
                                        ==
                                        $kategori['id']
                                    ) {

                                        echo "selected";

                                    }

                                    ?>
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        $kategori['name']
                                    );
                                    ?>

                                </option>

                            <?php endwhile; ?>

                        </select>

                    </div>



                    <!-- NAMA -->

                    <div class="form-group">

                        <label>
                            Nama Produk
                        </label>


                        <input
                            type="text"
                            name="name"
                            required
                            value="<?php

                                echo $produkEdit
                                    ? htmlspecialchars(
                                        $produkEdit['name']
                                      )
                                    : '';

                            ?>"
                        >

                    </div>



                    <!-- HARGA -->

                    <div class="form-group">

                        <label>
                            Harga
                        </label>


                        <input
                            type="number"
                            name="price"
                            required
                            value="<?php

                                echo $produkEdit
                                    ? $produkEdit['price']
                                    : '';

                            ?>"
                        >

                    </div>



                    <!-- STOK -->

                    <div class="form-group">

                        <label>
                            Stok
                        </label>


                        <input
                            type="number"
                            name="stock"
                            required
                            value="<?php

                                echo $produkEdit
                                    ? $produkEdit['stock']
                                    : '0';

                            ?>"
                        >

                    </div>



                    <!-- FLAVOR -->

                    <div class="form-group">

                        <label>
                            Flavor
                        </label>


                        <input
                            type="text"
                            name="flavor"
                            value="<?php

                                echo $produkEdit
                                    ? htmlspecialchars(
                                        $produkEdit['flavor']
                                      )
                                    : '';

                            ?>"
                        >

                    </div>



                    <!-- GAMBAR -->

                    <div class="form-group">

                        <label>
                            URL Gambar
                        </label>


                        <input
                            type="text"
                            name="image"
                            value="<?php

                                echo $produkEdit
                                    ? htmlspecialchars(
                                        $produkEdit['image']
                                      )
                                    : '';

                            ?>"
                        >

                    </div>



                    <!-- VIDEO -->

                    <div class="form-group">

                        <label>
                            URL Video
                        </label>


                        <input
                            type="text"
                            name="video"
                            value="<?php

                                echo $produkEdit
                                    ? htmlspecialchars(
                                        $produkEdit['video']
                                      )
                                    : '';

                            ?>"
                        >

                    </div>



                    <!-- DESKRIPSI -->

                    <div class="form-group full">

                        <label>
                            Deskripsi
                        </label>


                        <textarea
                            name="description"
                        ><?php

                            echo $produkEdit
                                ? htmlspecialchars(
                                    $produkEdit['description']
                                  )
                                : '';

                        ?></textarea>

                    </div>


                </div>



                <!-- ==================================================
                     TOMBOL FORM
                ================================================== -->

                <?php if ($produkEdit): ?>

                    <button
                        type="submit"
                        name="edit_produk"
                        class="btn-save"
                    >

                        Simpan Perubahan

                    </button>


                    <a
                        href="produk.php"
                        class="btn-cancel"
                    >

                        Batal

                    </a>

                <?php else: ?>

                    <button
                        type="submit"
                        name="tambah_produk"
                        class="btn-save"
                    >

                        Simpan Produk

                    </button>

                <?php endif; ?>


            </form>

        </section>



        <!-- ==================================================
             DAFTAR PRODUK
        ================================================== -->

        <section class="table-box">

            <h2>
                Daftar Produk
            </h2>


            <table>

                <thead>

                    <tr>

                        <th>Foto</th>

                        <th>Produk</th>

                        <th>Kategori</th>

                        <th>Harga</th>

                        <th>Rating</th>

                        <th>Stok</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>


                    <?php

                    // Mengecek apakah produk tersedia
                    if (
                        mysqli_num_rows(
                            $queryProduk
                        ) > 0
                    ):

                        // Menampilkan semua produk
                        while (
                            $produk =
                            mysqli_fetch_assoc(
                                $queryProduk
                            )
                        ):

                    ?>

                        <tr>


                            <!-- FOTO -->

                            <td>

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
                                        class="product-img"
                                        alt="Produk"
                                    >

                                <?php else: ?>

                                    ☕

                                <?php endif; ?>

                            </td>



                            <!-- NAMA PRODUK -->

                            <td>

                                <strong>

                                    <?php
                                    echo htmlspecialchars(
                                        $produk['name']
                                    );
                                    ?>

                                </strong>

                                <br>

                                <small>

                                    <?php
                                    echo htmlspecialchars(
                                        $produk['flavor'] ?? ''
                                    );
                                    ?>

                                </small>

                            </td>



                            <!-- KATEGORI -->

                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $produk['category_name']
                                    ?? '-'
                                );
                                ?>

                            </td>



                            <!-- HARGA -->

                            <td class="price">

                                Rp

                                <?php
                                echo number_format(
                                    $produk['price'],
                                    0,
                                    ',',
                                    '.'
                                );
                                ?>

                            </td>



                            <!-- RATING -->

                            <td>

                                ⭐

                                <?php
                                echo $produk['rating'];
                                ?>

                            </td>



                            <!-- STOK -->

                            <td>

                                <?php
                                echo $produk['stock'];
                                ?>

                            </td>



                            <!-- AKSI -->

                            <td>

                                <!-- Tombol edit -->

                                <a
                                    href="produk.php?edit=<?php
                                        echo $produk['id'];
                                    ?>#formProduk"
                                    class="edit"
                                >

                                    Edit

                                </a>


                                <!-- Tombol hapus -->

                                <a
                                    href="produk.php?hapus=<?php
                                        echo $produk['id'];
                                    ?>"
                                    class="delete"
                                    onclick="
                                        return confirm(
                                            'Yakin ingin menghapus produk ini?'
                                        );
                                    "
                                >

                                    Hapus

                                </a>

                            </td>


                        </tr>


                    <?php

                        endwhile;

                    else:

                    ?>

                        <tr>

                            <td
                                colspan="7"
                                style="text-align:center;"
                            >

                                Belum ada produk.

                            </td>

                        </tr>

                    <?php endif; ?>


                </tbody>

            </table>

        </section>


    </main>


</body>

</html>
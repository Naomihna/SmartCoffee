<?php

// ==========================================================
// OLD MONEY COFFEE
// REGISTER CUSTOMER
// ==========================================================

// Memanggil koneksi database
require_once "config/database.php";

// Memulai session
session_start();


// ==========================================================
// PROSES REGISTER
// ==========================================================

if (isset($_POST['register'])) {

    // Mengambil data dari form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    // ======================================================
    // VALIDASI PASSWORD
    // ======================================================

    if ($password !== $confirm_password) {

        $error = "Konfirmasi password tidak sama.";

    } else {

        // ==================================================
        // CEK EMAIL
        // ==================================================

        $email_safe = mysqli_real_escape_string(
            $conn,
            $email
        );

        $cekEmail = mysqli_query(
            $conn,
            "SELECT id
             FROM users
             WHERE email = '$email_safe'
             LIMIT 1"
        );


        if (mysqli_num_rows($cekEmail) > 0) {

            $error = "Email sudah terdaftar.";

        } else {

            // ==================================================
            // SIMPAN PASSWORD
            // ==================================================

            $password_hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );


            // Mengamankan data sebelum dimasukkan
            $name_safe = mysqli_real_escape_string(
                $conn,
                $name
            );

            $password_safe = mysqli_real_escape_string(
                $conn,
                $password_hash
            );


            // ==================================================
            // INSERT USER
            // ==================================================

            $query = mysqli_query(
                $conn,
                "INSERT INTO users
                (
                    name,
                    email,
                    password,
                    role
                )
                VALUES
                (
                    '$name_safe',
                    '$email_safe',
                    '$password_safe',
                    'user'
                )"
            );


            // ==================================================
            // HASIL REGISTER
            // ==================================================

            if ($query) {

                // Berhasil → menuju login
                header(
                    "Location: login.php?register=success"
                );

                exit;

            } else {

                $error = "Registrasi gagal. Silakan coba lagi.";

            }

        }

    }

}

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

    <title>
        Register | Old Money Coffee
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

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f8f2e9;

            color: #3b2519;

        }


        /* ==================================================
           REGISTER CARD
        ================================================== */

        .register-card {

            width: 100%;

            max-width: 430px;

            background: #fffaf4;

            padding: 40px;

            border-radius: 25px;

            border: 1px solid #eadccd;

            box-shadow:
                0 20px 50px
                rgba(65, 38, 20, 0.12);

        }


        /* Logo */

        .logo {

            text-align: center;

            font-family: Georgia, serif;

            font-size: 25px;

            font-weight: bold;

            color: #4b2e1f;

            margin-bottom: 10px;

        }


        .subtitle {

            text-align: center;

            color: #806f63;

            font-size: 13px;

            margin-bottom: 30px;

        }


        /* ==================================================
           FORM
        ================================================== */

        .form-group {

            margin-bottom: 18px;

        }


        .form-group label {

            display: block;

            font-size: 12px;

            font-weight: bold;

            margin-bottom: 8px;

        }


        .form-group input {

            width: 100%;

            padding: 13px 15px;

            border: 1px solid #dfd0c3;

            border-radius: 11px;

            outline: none;

            font-size: 13px;

        }


        .form-group input:focus {

            border-color: #a45d32;

        }


        /* ==================================================
           BUTTON
        ================================================== */

        .register-button {

            width: 100%;

            border: none;

            padding: 14px;

            border-radius: 25px;

            background: #4b2e1f;

            color: white;

            font-weight: bold;

            cursor: pointer;

            margin-top: 5px;

        }


        .register-button:hover {

            background: #7b4a2d;

        }


        /* ==================================================
           ERROR
        ================================================== */

        .error {

            background: #f4dddd;

            color: #8a3939;

            padding: 11px 13px;

            border-radius: 10px;

            font-size: 12px;

            margin-bottom: 18px;

        }


        /* ==================================================
           LOGIN LINK
        ================================================== */

        .login-link {

            text-align: center;

            margin-top: 22px;

            font-size: 12px;

            color: #806f63;

        }


        .login-link a {

            color: #a45d32;

            font-weight: bold;

            text-decoration: none;

        }


        /* ==================================================
           BACK HOME
        ================================================== */

        .back-home {

            display: block;

            text-align: center;

            margin-top: 15px;

            color: #806f63;

            font-size: 11px;

            text-decoration: none;

        }

    </style>

</head>


<body>


    <!-- ==================================================
         REGISTER CARD
    ================================================== -->

    <div class="register-card">


        <!-- Logo -->

        <div class="logo">

            ☕ Old Money Coffee

        </div>


        <p class="subtitle">

            Buat akun untuk menikmati pengalaman
            coffee shop kami.

        </p>


        <!-- ==================================================
             ERROR MESSAGE
        ================================================== -->

        <?php if (isset($error)): ?>

            <div class="error">

                <?php
                echo htmlspecialchars($error);
                ?>

            </div>

        <?php endif; ?>


        <!-- ==================================================
             REGISTER FORM
        ================================================== -->

        <form method="POST">


            <!-- Nama -->

            <div class="form-group">

                <label>
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Masukkan nama"
                    required
                >

            </div>


            <!-- Email -->

            <div class="form-group">

                <label>
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    required
                >

            </div>


            <!-- Password -->

            <div class="form-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <!-- Konfirmasi Password -->

            <div class="form-group">

                <label>
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="confirm_password"
                    placeholder="Ulangi password"
                    required
                >

            </div>


            <!-- Tombol -->

            <button
                type="submit"
                name="register"
                class="register-button"
            >

                Daftar Sekarang

            </button>


        </form>


        <!-- Login -->

        <div class="login-link">

            Sudah punya akun?

            <a href="login.php">
                Login
            </a>

        </div>


        <!-- Kembali -->

        <a
            href="index.php"
            class="back-home"
        >

            ← Kembali ke Home

        </a>


    </div>


</body>

</html>
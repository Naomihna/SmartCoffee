<?php

// ==========================================================
// OLD MONEY COFFEE
// LOGIN CUSTOMER / ADMIN
// ==========================================================

// Memanggil koneksi database
require_once "config/database.php";

// Memulai session
session_start();


// ==========================================================
// PROSES LOGIN
// ==========================================================

if (isset($_POST['login'])) {

    // Mengambil data form
    $email = trim($_POST['email']);
    $password = $_POST['password'];


    // Mengamankan email
    $email_safe = mysqli_real_escape_string(
        $conn,
        $email
    );


    // ======================================================
    // MENCARI USER
    // ======================================================

    $query = mysqli_query(
        $conn,
        "SELECT *
         FROM users
         WHERE email = '$email_safe'
         LIMIT 1"
    );


    // Mengecek apakah email ditemukan
    if (mysqli_num_rows($query) === 1) {

        $user = mysqli_fetch_assoc($query);


        // ==================================================
        // CEK PASSWORD
        // ==================================================

        if (
            password_verify(
                $password,
                $user['password']
            )
        ) {


            // ==================================================
            // SIMPAN DATA USER KE SESSION
            // ==================================================

            $_SESSION['user_id'] = $user['id'];

            $_SESSION['user_name'] = $user['name'];

            $_SESSION['user_email'] = $user['email'];

            $_SESSION['user_role'] = $user['role'];


            // ==================================================
            // REDIRECT BERDASARKAN ROLE
            // ==================================================

            if ($user['role'] === 'admin') {

                // Admin masuk dashboard
                header(
                    "Location: admin/index.php"
                );

            } else {

                // Customer masuk home
                header(
                    "Location: index.php"
                );

            }

            exit;


        } else {

            $error = "Password yang dimasukkan salah.";

        }


    } else {

        $error = "Email belum terdaftar.";

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
        Login | Old Money Coffee
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
           LOGIN CARD
        ================================================== */

        .login-card {

            width: 100%;

            max-width: 420px;

            background: #fffaf4;

            padding: 40px;

            border-radius: 25px;

            border: 1px solid #eadccd;

            box-shadow:
                0 20px 50px
                rgba(65, 38, 20, 0.12);

        }


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
           SUCCESS
        ================================================== */

        .success {

            background: #e2f0e1;

            color: #356238;

            padding: 11px 13px;

            border-radius: 10px;

            font-size: 12px;

            margin-bottom: 18px;

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
           LOGIN BUTTON
        ================================================== */

        .login-button {

            width: 100%;

            border: none;

            padding: 14px;

            border-radius: 25px;

            background: #4b2e1f;

            color: white;

            font-weight: bold;

            cursor: pointer;

        }


        .login-button:hover {

            background: #7b4a2d;

        }


        /* ==================================================
           REGISTER
        ================================================== */

        .register-link {

            text-align: center;

            margin-top: 22px;

            color: #806f63;

            font-size: 12px;

        }


        .register-link a {

            color: #a45d32;

            font-weight: bold;

            text-decoration: none;

        }


        /* ==================================================
           HOME
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
         LOGIN CARD
    ================================================== -->

    <div class="login-card">


        <!-- Logo -->

        <div class="logo">

            ☕ Old Money Coffee

        </div>


        <p class="subtitle">

            Login untuk melanjutkan
            ke Old Money Coffee.

        </p>


        <!-- ==================================================
             PESAN REGISTER BERHASIL
        ================================================== -->

        <?php if (
            isset($_GET['register']) &&
            $_GET['register'] === 'success'
        ): ?>

            <div class="success">

                Registrasi berhasil.
                Silakan login.

            </div>

        <?php endif; ?>


        <!-- ==================================================
             PESAN ERROR
        ================================================== -->

        <?php if (isset($error)): ?>

            <div class="error">

                <?php
                echo htmlspecialchars($error);
                ?>

            </div>

        <?php endif; ?>


        <!-- ==================================================
             FORM LOGIN
        ================================================== -->

        <form method="POST">


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


            <!-- Tombol Login -->

            <button
                type="submit"
                name="login"
                class="login-button"
            >

                Login

            </button>


        </form>


        <!-- Register -->

        <div class="register-link">

            Belum punya akun?

            <a href="register.php">
                Daftar sekarang
            </a>

        </div>


        <!-- Home -->

        <a
            href="index.php"
            class="back-home"
        >

            ← Kembali ke Home

        </a>


    </div>


</body>

</html>
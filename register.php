<?php
// ==========================================
// KONEKSI DATABASE
// ==========================================
require_once "config/database.php";

// Variabel untuk menampilkan pesan
$message = "";
$message_type = "";

// ==========================================
// PROSES REGISTER
// ==========================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Mengambil data dari form
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // ==========================================
    // VALIDASI
    // ==========================================

    if ($name === "" || $email === "" || $password === "") {

        $message = "Semua data harus diisi.";
        $message_type = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Format email tidak valid.";
        $message_type = "error";

    } elseif ($password !== $confirm_password) {

        $message = "Konfirmasi password tidak sama.";
        $message_type = "error";

    } elseif (strlen($password) < 6) {

        $message = "Password minimal 6 karakter.";
        $message_type = "error";

    } else {

        // ==========================================
        // CEK EMAIL
        // ==========================================

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "Email sudah terdaftar.";
            $message_type = "error";

        } else {

            // ==========================================
            // ENKRIPSI PASSWORD
            // ==========================================

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // ==========================================
            // SIMPAN USER
            // ==========================================

            $stmt = $conn->prepare(
                "INSERT INTO users
                (name, email, password, role)
                VALUES (?, ?, ?, 'user')"
            );

            $stmt->bind_param(
                "sss",
                $name,
                $email,
                $hashed_password
            );

            if ($stmt->execute()) {

                // Setelah berhasil daftar,
                // arahkan user ke halaman login
                header("Location: login.php?register=success");
                exit;

            } else {

                $message = "Registrasi gagal.";
                $message_type = "error";
            }
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

    <title>Register | SmartCoffee</title>


    <!-- ==========================================
         CSS REGISTER
    =========================================== -->

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f7f0e7;

            font-family: Arial, sans-serif;

            color: #3b2519;
        }

        .register-container {
            width: 900px;
            max-width: 92%;

            min-height: 550px;

            display: grid;
            grid-template-columns: 1fr 1fr;

            background: white;

            border-radius: 25px;

            overflow: hidden;

            box-shadow:
                0 20px 50px rgba(60, 35, 20, 0.15);
        }

        /* ==========================================
           BAGIAN GAMBAR
        =========================================== */

        .register-image {

            background-image:
                url("https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=900&q=80");

            background-size: cover;
            background-position: center;

            position: relative;
        }

        .register-image::after {
            content: "";

            position: absolute;

            inset: 0;

            background: rgba(55, 32, 20, 0.45);
        }

        .image-text {

            position: absolute;

            z-index: 2;

            left: 40px;
            bottom: 40px;

            color: white;
        }

        .image-text h1 {
            font-family: Georgia, serif;

            font-size: 42px;

            margin-bottom: 10px;
        }

        .image-text p {
            line-height: 1.6;

            font-size: 14px;

            color: #f2e8df;
        }


        /* ==========================================
           FORM REGISTER
        =========================================== */

        .register-form {

            padding: 55px 45px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            color: #a45d32;

            font-weight: bold;

            margin-bottom: 10px;
        }

        .register-form h2 {

            font-family: Georgia, serif;

            font-size: 34px;

            margin-bottom: 8px;
        }

        .subtitle {

            color: #8a7667;

            font-size: 13px;

            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {

            display: block;

            font-size: 13px;

            font-weight: bold;

            margin-bottom: 7px;
        }

        .form-group input {

            width: 100%;

            padding: 13px 15px;

            border: 1px solid #dfd0c3;

            border-radius: 10px;

            outline: none;

            font-size: 14px;
        }

        .form-group input:focus {

            border-color: #a45d32;
        }

        .register-button {

            width: 100%;

            border: none;

            background: #4b2e1f;

            color: white;

            padding: 14px;

            border-radius: 25px;

            font-weight: bold;

            cursor: pointer;

            margin-top: 5px;
        }

        .register-button:hover {
            background: #7b4a2d;
        }

        .message {

            padding: 10px;

            border-radius: 8px;

            font-size: 12px;

            margin-bottom: 15px;

            background: #fce4e4;

            color: #a52b2b;
        }

        .login-link {

            text-align: center;

            margin-top: 20px;

            font-size: 13px;

            color: #806f63;
        }

        .login-link a {
            color: #a45d32;

            font-weight: bold;
        }


        /* ==========================================
           RESPONSIVE
        =========================================== */

        @media (max-width: 700px) {

            .register-container {
                grid-template-columns: 1fr;
            }

            .register-image {
                display: none;
            }

            .register-form {
                padding: 40px 25px;
            }
        }

    </style>

</head>


<body>


    <!-- ==========================================
         REGISTER CONTAINER
    =========================================== -->

    <div class="register-container">


        <!-- ==========================================
             GAMBAR
        =========================================== -->

        <div class="register-image">

            <div class="image-text">

                <h1>SmartCoffee</h1>

                <p>
                    Temukan kopi favoritmu dan
                    dapatkan rekomendasi yang sesuai
                    dengan selera kamu.
                </p>

            </div>

        </div>


        <!-- ==========================================
             FORM
        =========================================== -->

        <div class="register-form">

            <div class="logo">
                ☕ SMARTCOFFEE
            </div>

            <h2>
                Buat Akun
            </h2>

            <p class="subtitle">
                Daftar untuk mendapatkan pengalaman
                SmartCoffee yang lebih personal.
            </p>


            <!-- Pesan error -->
            <?php if ($message !== ""): ?>

                <div class="message">
                    <?= htmlspecialchars($message) ?>
                </div>

            <?php endif; ?>


            <form method="POST">


                <!-- Nama -->
                <div class="form-group">

                    <label>
                        Nama Lengkap
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
                        placeholder="Minimal 6 karakter"
                        required
                    >

                </div>


                <!-- Konfirmasi password -->
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
                    class="register-button"
                >
                    Daftar Sekarang
                </button>

            </form>


            <!-- Link login -->
            <p class="login-link">

                Sudah punya akun?

                <a href="login.php">
                    Login di sini
                </a>

            </p>

        </div>

    </div>

</body>

</html>
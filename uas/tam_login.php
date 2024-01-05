<?php
session_start();
$title = 'Pendaftaran Akun Baru';
include_once 'koneksi.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password sebelum menyimpan ke database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Gunakan parameterized query untuk menghindari SQL injection
    $stmtCheck = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmtCheck->bind_param("s", $username);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        // Username sudah ada, tampilkan pesan error
        echo "<p style='color: red;'>Username sudah digunakan. Silakan pilih username lain.</p>";
    } else {
        // Username belum ada, lanjutkan dengan insert
        $stmtCheck->close();

        $stmtInsert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmtInsert->bind_param("ss", $username, $hashedPassword);

        if ($stmtInsert->execute()) {
            // Pendaftaran berhasil, atur sesi login
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;

            // Redirect ke halaman login setelah pendaftaran sukses
            header('location: login.php');
            exit(); // Pastikan untuk keluar dari skrip setelah melakukan redirect
        } else {
            echo "<p style='color: red;'>Error: " . $stmtInsert->error . "</p>";
        }

        $stmtInsert->close();
    }

    $stmtCheck->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tampilan Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body style="margin-top: 30px; background-color: #696969;">
    <div class="container" style="background-color: #808080; width: 70%; padding: 20px; margin: auto; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h1 style="color: #343a40; text-align: center;">DATA CHECKLIST KEBERSIHAN TOILET</h1><br>
        <h2 style="color: #343a40; text-align: center;">PENDAFTARAN AKUN BARU</h2><br>
        <form method="POST">
            <div class="mb-3 row" style="background-color: ;">
                <label for="staticEmail" class="col-sm-2 col-form-label" style="color: #ffffff;">Username</label>
                <div class="col-sm-10">
                    <input style="color: #000000;" type="text" class="form-control" id="staticEmail" placeholder="Username" name="username">
                </div>
            </div>
            <br>
            <div class="mb-3 row " style="background-color: ;">
                <label for="inputPassword" class="col-sm-2 col-form-label" style="color: #ffffff;">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password" accept="" name="password">
                </div>
            </div>
            <br>
            <div class="submit">
                <button type="submit" name="submit" class="btn" style="background-color: #006400; color: #ffffff;">Daftar</button>
            </div>
            <div><br><br>
                <p style="color: #000000;">Sudah memiliki akun??</p>
                <a href="login.php" style="color: #ADFF2F;">Login</a>
            </div>
        </form>
    </div>
</body>

</html>

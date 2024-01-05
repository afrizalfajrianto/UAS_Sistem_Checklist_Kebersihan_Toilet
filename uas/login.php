<?php
session_start();
$title = 'Login';
include_once 'koneksi.php';

if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['pass'];  // Ubah $pass menjadi $password

    // Gunakan parameterized query untuk mencegah SQL injection
    $sql = "SELECT * FROM users WHERE username = ? AND pass = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) != 0){
        $_SESSION['login'] = true;
        $_SESSION['username'] = mysqli_fetch_array($result);

        header('location: home.php');
    } else {
        $errorMsg = "<p style=\"color:red;\">Gagal Login, silakan ulangi lagi.</p>";
    }

    mysqli_stmt_close($stmt);
}

if (isset($errorMsg)) echo $errorMsg;
?>

<!DOCTYPE html>
<html lang="en">


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            margin-top: 30px;
            background-color: 	#696969; /* Warna latar belakang */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Ganti dengan font yang diinginkan */
        }

        .container {
            background-color: #808080; /* Warna latar belakang container */
            width: 70%;
            padding: 20px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Efek bayangan pada container */
        }

        h1, h2 {
            color: #343a40; /* Warna teks judul */
            text-align: center;
        }

        .form-control {
            color: #495057; /* Warna teks pada input form */
        }

        .btn {
            background-color: 	#006400; /* Warna latar belakang tombol */
            color: #ffffff; /* Warna teks tombol */
        }

        p {
            color: #000000; /* Warna teks paragraf */
        }

        a {
            color: 	#ADFF2F; /* Warna teks link */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DATA CHECKLIST KEBERSIHAN TOILET</h1>
        <h2>LOGIN</h2>

        <form method="POST">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="staticEmail" placeholder="Username" name="username">
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password" accept="" name="pass">
                </div>
            </div>
            <br>
            <div class="submit">
                <button type="submit" name="submit" class="btn">Login</button>
            </div>
            <div><br><br>
                <p>Belum memiliki akun??</p>
                <a href="tam_login.php">Buat Akun Baru</a>
            </div>
        </form>
    </div>
</body>
</html>

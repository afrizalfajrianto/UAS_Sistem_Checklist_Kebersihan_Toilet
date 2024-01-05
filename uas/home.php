<?php
session_start();
$title = 'Pendaftaran Akun Baru';
include_once 'koneksi.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password sebelum menyimpan ke database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Pendaftaran berhasil!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<!-- ... Bagian HTML tetap sama ... -->

</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>
<body style="margin-top: 30px; background-color: #228B22;">
    <h1 style="color: #000000; text-align: center;">SELAMAT DATANG DI APLIKASI CHECKLIST</h1>
    <div class = "container" style= "width: 50%; padding: 30px;">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true" style="background-color: #9FB501;">Menu</li>
            <li class="list-group-item" type="" style="font-size: 30px; color: #FFFFFF;"><a style="color: #FF0000;" href="index.php">Checklist Toilet</a></li>
            <li class="list-group-item" style="font-size: 30px; color: #FFFFFF;"><a style="color: #144272;" href="ind_toilet.php">Data Toilet</a></li>
        </ul>
    </div>
    <div class="d-grid gap-2 container" style="width:50%;">
        <button class="btn" type="button" style="background-color: #FF1E1E"><a style="color: #FFFFFF" href="login.php">Logout</a></button>
    </div>
</body>
</html>
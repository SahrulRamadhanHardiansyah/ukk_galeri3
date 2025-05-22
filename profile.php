<?php
session_start();
include 'inc/fungsi.php';

if (!isLoggedIn()){
    header('Location: login.php');
    exit();
}

$user = getUserById($_SESSION['user_id']);
$total_foto = countUserPhotos($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Galari Foto</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
        <h1>Profile Pengguna</h1>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="profile.php">Profil</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <div class="profile-info">
                <h3><?= htmlspecialchars($user['NamaLengkap']) ?></h3>
                <p>Username: <?= htmlspecialchars($user['Username']) ?></p>
                <p>Email: <?= htmlspecialchars($user['Email']) ?></p>
                <p>Alamat: <?= htmlspecialchars($user['Alamat']) ?></p>
            </div>

            <div class="profile-stats">
                <span class="stat">Foto: <?= $total_foto ?></span>
            </div>
        </div>
    </main>
</body>
</html>
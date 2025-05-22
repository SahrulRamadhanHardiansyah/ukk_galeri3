<?php
session_start();
include 'inc/fungsi.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['UserID'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau Password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Galeri Foto</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
        <h1>Login</h1>
        <nav class="">
            <a href="index.php">Beranda</a>
            <a href="register.php">Register</a>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <?php if(isset($error)): ?>
                <div class="color: red; margin-bottom: 1rem;"><?= $error ?></div>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button class="btn" type="submit">Login</button>
            </form>
        </div>
    </main>
</html>
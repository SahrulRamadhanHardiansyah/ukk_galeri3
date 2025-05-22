<?php
session_start();
include 'inc/koneksi.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $alamat = trim($_POST['alamat']);

    if(empty($username) || empty($password) || empty($email)){
        $error = 'Semua field harus diisi!';
    } else {
        $cekUsername = mysqli_query($conn, "SELECT * FROM user WHERE Username = '$username'");
        if(mysqli_num_rows($cekUsername) > 0 ) {
            $error = 'Username sudah digunakan!';
        } else {
            $simpan = mysqli_query($conn, "INSERT INTO user (username, password, email, namalengkap, alamat)
            VALUES ('$username', '$password', '$email', '$nama_lengkap', '$alamat')");

            if ($simpan) {
                $success = 'Registrasi berhasil! Silakan Login.';
                $_POST = array();
            }else {
                $error = 'Gagal Registrasi! ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Galeri Foto</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
        <h1>Register</h1>
        <nav class="">
            <a href="index.php">Beranda</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <?php if($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <?php if($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <main>
        <div class="form-container">    
			<form method="post">
				<div class="form-group">
					<label>Username:</label>
					<input type="text" name="username" value="<?= $_POST['username'] ?? '' ?>" required>
				</div>
				
				<div class="form-group">
					<label>Password:</label>
					<input type="password" name="password" required>
				</div>
				
				<div class="form-group">
					<label>Email:</label>
					<input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
				</div>
				
				<div class="form-group">
					<label class="required">Nama Lengkap</label>
					<input type="text" name="nama_lengkap" 
						   value="<?= htmlspecialchars($_POST['nama_lengkap'] ?? '') ?>" required>
				</div>
        
				<div class="form-group">
					<label>Alamat</label>
					<textarea name="alamat"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
				</div>
				
				<button class="btn" type="submit">Daftar</button>
			</form>
		</div>
    </main>
</html>
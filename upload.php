<?php
session_start();
include 'inc/fungsi.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$albums = mysqli_query($conn, "SELECT * FROM album WHERE UserID = {$_SESSION['user_id']}");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $upload_dir = 'uploads/';
    $file_name = basename($_FILES['foto']['name']);
    $file_path = $upload_dir . $file_name;
    
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $file_path)) {
        include 'inc/koneksi.php';
        $judul = trim($_POST['judul'] ?? 'Tanpa Judul');
        $user_id = trim($_SESSION['user_id']);
        $deskripsi = $_POST['deskripsi'];
        $album_id = trim($_POST['album_id']);

        $sql = "INSERT INTO foto (JudulFoto, DeskripsiFoto, LokasiFile, AlbumID, UserID, TanggalUnggah)
                VALUES ('$judul', '$deskripsi', '$file_name', '$album_id', '$user_id', NOW())";
        mysqli_query($conn, $sql);
        $success = "Foto berhasil di unggah!";
    } else {
        $error = "Foto gagal di unggah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto - Galeri Foto</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header>
        <h1>Upload Foto</h1>
        <nav class="">
            <a href="index.php">Beranda</a>
            <a href="profile.php">Profil</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <?php if (isset($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <main>
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Judul Foto: </label> 
                    <input type="text" name="judul" required>
                </div>
                <div class="form-group">
                    <label>Pilih Album</label>
                    <select name="album_id" id="" required>
                        <?php while($album = mysqli_fetch_assoc($albums)): ?>
                            <option value="<?= $album['AlbumID'] ?>"><?= $album['NamaAlbum'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi Foto: </label>
                    <input type="text" name="deskripsi" required>
                </div>
                <div class="form-group">
                    <label>Pilih Foto: </label>
                    <input type="file" name="foto" accept="image/*" required>
                </div>

                <button class="btn" type="submit">Upload</button>
            </form>
        </div>
    </main>
</html>
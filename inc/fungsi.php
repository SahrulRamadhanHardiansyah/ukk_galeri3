<?php
include 'koneksi.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserById($id) {
    global $conn;
    $query = "SELECT * FROM user WHERE UserID = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function getPhotos($album_id = null) {
    global $conn;
    $query = "SELECT * FROM foto";
    if ($album_id) {
        $query .= " WHERE AlbumID = $album_id";
    }
    $query .= " ORDER BY TanggalUnggah DESC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function countUserPhotos($user_id) {
    global $conn;
    $query = "SELECT COUNT(*) AS total FROM foto WHERE UserID = '$user_id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

function getAlbumByUser($user_id) {
    global $conn;
    $query = "SELECT * FROM album WHERE UserID = '$user_id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getPhotoById($photo_id) {
    global $conn;
    $query = "SELECT * FROM foto WHERE PhotoID = '$photo_id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function getPhotosWithStats() {
    global $conn;

    $query = "SELECT f.*, 
            COUNT(DISTINCT l.LikeID) AS jumlah_like, 
            COUNT(DISTINCT k.KomentarID) AS jumlah_komentar
            FROM foto f
            LEFT JOIN likefoto l ON f.FotoID = l.FotoID
            LEFT JOIN komentarfoto k ON f.FotoID = k.FotoID
            GROUP BY f.FotoID
            ORDER BY f.TanggalUnggah DESC";

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>
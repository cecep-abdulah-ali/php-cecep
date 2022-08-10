<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("location: login.php");
    exit;
}

require 'functions.php';
// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {

// cek apakah data berhasil di tambahkan atau tidak
if( tambah($_POST) > 0 ) {
    echo "
<script>
    alert('data berhasil ditambahkan!');
    document.location.href = 'index.php';
</script>
    ";
} else {
    echo "
<script>
    alert('data gagal ditambahkan!');
    document.location.href = 'index.php';
</script>
    ";
}

}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>tambah data</title>
    </head>
    <body>

<h1>tambah data cindy florist</h1>

<form action="" method="post" enctype="multipart/form-data">
<ul>
    <li>
        <label for="nama">Nama : </label>
        <input type="text" name="nama" id="nama" required autocomplete="off">
    </li>
    <li>
        <label for="harga">Harga : </label>
        <input type="text" name="harga" id="harga" required autocomplete="off">
    </li>
    <li>
        <label for="bahan">Bahan : </label>
        <input type="text" name="bahan" id="bahan" required autocomplete="off">
    </li>
    <li>
        <label for="gambar">Gambar : </label>
        <input type="file" name="gambar" id="gambar" autocomplete="off">
    </li>
    <li>
        <button type="submit" name="submit">Tambah data!</button>
    </li>
</ul>
</form>
    
</body>
</html>
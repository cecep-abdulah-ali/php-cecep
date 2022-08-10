<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("location: login.php");
    exit;
}

require 'functions.php';

//ambil data di URL
$id = $_GET["id"];

//query data cindy florist berdasarkan id
$sin = query("SELECT * FROM cindy_florist WHERE id = $id") [0];


// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {

// cek apakah data berhasil di ubah atau tidak
if( ubah($_POST) > 0 ) {
    echo "
<script>
    alert('data berhasil diubah!');
    document.location.href = 'index.php';
</script>
    ";
} else {
    echo "
<script>
    alert('data gagal diubah!');
    document.location.href = 'index.php';
</script>
    ";
}

}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>ubah data</title>
    </head>
    <body>

<h1>ubah data cindy florist</h1>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $sin ["id"];?>"> 
    <input type="hidden" name="gambarlama" value="<?= $sin ["gambar"];?>"> 
<ul>
    <li>
        <label for="nama">Nama : </label>
        <input type="text" name="nama" id="nama" required
        value="<?= $sin ["nama"];?>">
    </li>
    <li>
        <label for="harga">Harga : </label>
        <input type="text" name="harga" id="harga" required
        value="<?= $sin ["harga"];?>">
    </li>
    <li>
        <label for="bahan">Bahan : </label>
        <input type="text" name="bahan" id="bahan" required
        value="<?= $sin ["bahan"];?>">
    </li>
    <li>
        <label for="gambar">Gambar : </label> <br>
        <img src="img/<?= $sin['gambar'];?>"> <br>
        <input type="file" name="gambar" id="gambar">
    </li>
    <li>
        <button type="submit" name="submit">ubah data!</button>
    </li>
</ul>
</form>
    
</body>
</html>
<?php  
session_start();

if( !isset($_SESSION["login"]) ) {
    header("location: login.php");
    exit;
}

 // menghubungkan halaman index ke halaman functions 
 require 'functions.php';
 $cindy_florist = query("SELECT * FROM cindy_florist");

 // tombol cari ditekan
 if ( isset($_POST["cari"]) ) {
    $cindy_florist = cari($_POST["keyword"]);
 }
 ?>
 <!DOCTYPE html>
<html>
    <head>
        <title>ndy</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
<header>
    <nav>
        <a href="logout.php"><b>logout</b></a>
    </nav>
        <h1>Cindy Florist</h1>
        <a href="tambah.php"><b> tambah data cindy florist </b></a>
    <br><br>
</header>
    <br>
    <form action="" method="post">

        <input type="text" name="keyword" size="40" autofocus
        placeholder="masukan keyword pencarian.." autocomplete="off">
        <button type="submit" name="cari">cari</button>

    </form>
    <br>
<main>
    <table border = "1" cellpadding = "10" cellspacing = "0">
        <tr>
            <th>no</th>
            <th>aksi</th>
            <th>gambar</th>
            <th>nama</th>
            <th>harga</th>
            <th>bahan</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach($cindy_florist as $ndy): ?>
        <tr>
            <td><?= $i ;?></td>
            <td>
                <a href="ubah.php?id=<?= $ndy ["id"];?>">ubah</a>  |
                <a href="hapus.php?id=<?= $ndy["id"];?>" onclick="return confirm('apakah kamu yakin ingin menghapus data tersebut');">hapus</a>
            </td>
            <td><img src="img/<?= $ndy["gambar"];?>" width = "70"></td>
            <td><?= $ndy["nama"];?></td>
            <td><?= $ndy["harga"];?></td>
            <td><?= $ndy["bahan"];?></td>
        </tr>
        <?php $i++ ; ?>
        <?php endforeach; ?>
    </table>
</main>


    </body>
</html>
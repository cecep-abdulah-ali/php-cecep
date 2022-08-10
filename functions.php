<?php
// koneksi ke DBMS
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $conn ;
    $result = mysqli_query($conn, $query);
    $ndys = [];
    while($ndy = mysqli_fetch_assoc($result)) {
        $ndys[] = $ndy;
    }
    return $ndys;

}

function tambah($data) {
    global $conn;
// ambil data dari tiap elemen dalam form
$nama =htmlspecialchars($data ["nama"]);
$harga =htmlspecialchars($data ["harga"]);
$bahan =htmlspecialchars($data ["bahan"]);

// upload gamar
$gambar = upload();
if( !$gambar ) {
    return false;
}

 //query insert data
 $query = "INSERT INTO cindy_florist
            VALUES
            ('', '$nama', '$harga', '$bahan', '$gambar')";

            mysqli_query($conn, $query);

            return mysqli_affected_rows($conn);
}


function upload() {
    
    $namafile = $_FILES ['gambar']['name'];
    $ukuranfile = $_FILES ['gambar']['size'];
    $error = $_FILES ['gambar']['error'];
    $tmpname = $_FILES ['gambar']['tmp_name'];

// cek apakah tidak ada gambar yang di upload
if( $error === 4 ) {
 echo "<script>
        alert ('pilih gambar terlebih dahulu');
    </script>";
    return false;
    }

// cek apakah yang diupload adalah gambar
 $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
 $ekstensiGambar = explode( '.', $namafile );
 $ekstensiGambar = strtolower(end($ekstensiGambar));
 if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
 echo "<script>
        alert ('yang anda upload bukan gambar');
    </script>";
    return false;
 }

 // cek ukuranya terlalu besar
 if ($ukuranfile > 1000000) {
    echo "<script>
        alert ('gambar yang diupload terlalu besar');
    </script>";
    return false;
 }

// lolos pengecekan, gambar siap di upload
//generate gambar baru 
$namafilebaru = uniqid();
$namafilebaru .= '.';
$namafilebaru .= $ekstensiGambar;


move_uploaded_file($tmpname, 'img/' . $namafilebaru);

return $namafilebaru;
}


function hapus($id) {
    global $conn;
    mysqli_query( $conn, "DELETE FROM cindy_florist WHERE id = $id");
    return mysqli_affected_rows($conn);
}


function ubah($data) {
    global $conn;
    $id = $data["id"];

$nama = htmlspecialchars($data ["nama"]);
$harga = htmlspecialchars($data ["harga"]);
$bahan = htmlspecialchars($data ["bahan"]);
$gambarlama =htmlspecialchars($data ["gambarlama"]);

// cek apakah user pilih gambar baru atau tidak
if( $_FILES['gambar']['error'] === 4 ) {
    $gambar = $gambarlama;
} else {
    $gambar = upload();
}


 //query insert data
 $query = "UPDATE cindy_florist SET
            nama = '$nama',
            harga = '$harga',
            bahan = '$bahan',
            gambar = '$gambar'
           WHERE id = $id  
            ";

            mysqli_query($conn, $query);

            return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM cindy_florist 
                WHERE
                nama LIKE '%$keyword%' OR
                harga LIKE '%$keyword%' OR
                bahan LIKE '%$keyword%'
                ";
        return query($query);
}



function registrasi($data) {
    global $conn;
$username = strtolower(stripslashes($data["username"]));
$password = mysqli_real_escape_string($conn, $data["password"]);
$password2 = mysqli_real_escape_string($conn, $data["password2"]);


//cek apakah username sudah ada atau belum 
$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

if( mysqli_fetch_assoc($result) ) {
   echo "<script>
            alert('username yang anda masukan sudah terdaftar!')
   </script>";
   return false;
}


// cek confirmasi password
if( $password !== $password2 ) {
    echo "<script>
        alert ('confirmasi password tidak sesuai!');
    </script>";
    return false;
}

// enkripsi/amankan password
$password = password_hash( $password, PASSWORD_DEFAULT );
 
//tambahkan user baru ke database
mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

return mysqli_affected_rows($conn);



}




?>
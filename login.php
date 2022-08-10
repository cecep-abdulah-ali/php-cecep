<?php
session_start();

require 'functions.php';

//cek cookie
if(isset($_COOKIE["id"]) && isset($_COOKIE['key'] )) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

// cari username berdasarkan id
    $result = mysqli_query( $conn, "SELECT username FROM user WHERE id = $id" );
    $row = mysqli_fetch_assoc($result);

// cek id dan username
    if($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }

}

if( isset($_SESSION["login"]) ) {
    header("location: index.php");
    exit;
}



if( isset($_POST["login"]) ) {
 
$username = $_POST["username"];
$password = $_POST["password"];

$result = mysqli_query( $conn, "SELECT * FROM user WHERE username = '$username'" );

// cek username
if (mysqli_num_rows($result)=== 1 ) {

// cek password
$row = mysqli_fetch_assoc($result);
if (password_verify($password, $row["password"]) ) {
// set session
$_SESSION["login"] = true;

// cek remember me
if( isset($_POST["remember"]) ) {
// buat cookie
setcookie('id', $row['id'], time()+120);
setcookie('key', hash('sha256', $row['username']), time()+120 );
}

    header("location: index.php");
    exit;
        }       

    }
    $error = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    
    <title>halamn login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
    
<h1>HALAMAN LOGIN</h1>

<?php if(isset($error)) : ?>
    <p style="color : red; font-style: italic ;">username / password salah</p>
    <?php endif; ?>

<form action="" method="post">

        
        <main>    
            <label for="username">username</label>
            <br>
            <input type="text" name="username" id="username">
            <br>
            
            <label for="password">password</label>
            <br>
            <input type="password" name="password" id="password">
        </main>
            <br>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">remember me</label>
            <br>
            <br>
            <button type="submit" name="login">login</button>
            
        


</form>

</div>
</body>
</html>
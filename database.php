<?php 

$localhost  = "localhost";
$user       = "root";
$pass       = "";
$db         = "todolist_php_april";

$conn = mysqli_connect($localhost,$user,$pass,$db);

if (!$conn) {
    die("Gagal terkoneksi" .mysqli_connect_error());
}
?>

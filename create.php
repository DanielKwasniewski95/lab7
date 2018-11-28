<?php
$location="files.php";
header("Location: $location");
$name=$_POST['n_kat'];
$user=$_COOKIE['user_n'];
mkdir ("users/$user/$name", 0777);
?>
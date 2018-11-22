<?php
$dalej="pliki.php";
header("Location: $dalej");
$nazwa=$_POST['n_kat'];
$usr=$_COOKIE['user_n'];
mkdir ("users/$usr/$nazwa", 0777);
?>
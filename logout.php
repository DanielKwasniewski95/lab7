<?php
setcookie("user", "", time() - 3600);
setcookie("user_n", "", time() - 3600);
$dalej="index.php";
header("Location: $dalej");
?>
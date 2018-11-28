<?php
$user=$_COOKIE['user_n'];
$path=$_POST['folder'];
$size = 100000;
if (is_uploaded_file($_FILES['plik']['tmp_name']))
{
if ($_FILES['plik']['size'] > $size) {echo "Przekroczenie rozmiaru $size"; }
else
{
    if(IsSet($path)){
        move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."z7/users/$user/$path/".$_FILES['plik']['name']);
    }else{
     move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."z7/users/$user/".$_FILES['plik']['name']);
    }
}
}
$location="files.php";
header("Location: $location");
?>
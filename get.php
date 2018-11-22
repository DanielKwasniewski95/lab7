<?php
$usr=$_COOKIE['user_n'];
$sciezka=$_POST['folder'];
$max_rozmiar = 100000;
if (is_uploaded_file($_FILES['plik']['tmp_name']))
{
if ($_FILES['plik']['size'] > $max_rozmiar) {echo "Przekroczenie rozmiaru $max_rozmiar"; }
else
{
    if(IsSet($sciezka)){
        move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."z7/users/$usr/$sciezka/".$_FILES['plik']['name']);
    }else{
     move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."z7/users/$usr/".$_FILES['plik']['name']);
    }
}
}
$dalej="pliki.php";
header("Location: $dalej");
?>
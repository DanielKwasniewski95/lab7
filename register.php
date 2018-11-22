<html>
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
     <title>Kwasniewski</title>
</head>

<body>

<a href="index.php">Sign in</a>

<form method="POST">
<p>Login:</p>
<input type="text" name="nick" maxlength="25" size="25"><br>
<p>Password:</p>
<input type="password" name="haslo" maxlength="25" size="25"><br>
<p>Confirm password:</p>
<input type="password" name="haslo1" maxlength="25" size="25"><br><br>

<input type="submit" value="Sign up">
</form>

<?php
     $dbhost="serwer1829042.home.pl"; $dbuser="28887864_github"; $dbpassword="githubzadanie7"; $dbname="28887864_github";
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$polaczenie) {
            echo "Błąd połączenia z MySQL." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }    
if (IsSet($_POST['nick'])) {
    if($_POST['haslo'] == $_POST['haslo1']){
    $n=$_POST['nick'];
    $h=$_POST['haslo'];
    $dodaj="INSERT INTO users VALUES (NULL,'$n', '$h')";
    mysqli_query($polaczenie, $dodaj);
    mysqli_close($polaczenie);
    mkdir ("users/$n", 0777);
    echo "<script>alert('User added')</script>";
    echo "<script>location.href='index.php';</script>";
    }else {
         echo "<script>alert('Passwords mismatch')</script>";
        }
}
?>

</body>
</html>
</html>





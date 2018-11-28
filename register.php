<html>
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
     <title>Kwasniewski</title>
</head>

<body>

<a href="index.php">Sign in</a>

<form method="POST">
<p>Login:</p>
<input type="text" name="nick" maxlength="30" size="30"><br>
<p>Password:</p>
<input type="password" name="haslo" maxlength="30" size="30"><br>
<p>Confirm password:</p>
<input type="password" name="haslo1" maxlength="30" size="30"><br><br>

<input type="submit" value="Sign up">
</form>

<?php
    
    require_once ('db_data.php');
     /*$dbhost="serwer1829042.home.pl"; $dbuser="28887864_github"; $dbpassword="githubzadanie7"; $dbname="28887864_github";*/
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$connection) {
            echo "Błąd połączenia z MySQL." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }    
if (IsSet($_POST['nick'])) {
    if($_POST['haslo'] == $_POST['haslo1']){
    $nick=$_POST['nick'];
    $password=$_POST['haslo'];
    $sql="INSERT INTO users VALUES (NULL,'$nick', '$password')";
    mysqli_query($connection, $sql);
    mysqli_close($connection);
    mkdir ("users/$nick", 0777);
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





<?php
    $ipaddress = $_SERVER["REMOTE_ADDR"];
    
   /* function getDetails($ip)
    {
        $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
        $details = json_decode($json);
        return $details;
    }*/
   
    require_once ('details.php');
    require_once ('db_data.php');
    
    $details = getDetails($ipaddress);
    $ip = $details->ip;
    $info = get_browser(null, true);
    $browser = $info['browser'];
    $os = $info['platform'];
    $date = date("Y-m-d H:i:s", time());
    $user = strtolower($_POST['user']); // login z formularza
    $password = $_POST['pass']; // hasło z formularza
    /*$connection = mysqli_connect("serwer1829042.home.pl", "28887864_github", "githubzadanie7", "28887864_github");*/ // połączenie z BD – wpisać swoje parametry !!!
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$connection) {
        echo "Błąd: " . mysqli_connect_errno() . " " . mysqli_connect_error();
    } // obsługa błędu połączenia z BD
    mysqli_query($connection, "SET NAMES 'utf8'"); // ustawienie polskich znaków
    $sql = "SELECT * FROM users WHERE login='$user'";
    $result = mysqli_query($connection, $sql); // pobranie z BD wiersza, w którym login=login z formularza
    $row = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
    $idk = $row['id'];
    $sql = "SELECT * FROM logserror WHERE idu='$idk'";
    $result = mysqli_query($connection, $sql);
    $row2 = mysqli_fetch_array($result);
    if (!$row) //Jeśli brak, to nie ma użytkownika o podanym loginie
    {
        echo "Login incorrect<br><br>";
        echo "<a href=\logout.php\">go back</a>";
    } else { // Jeśli $rekord istnieje
        if ($row['haslo'] == $password)// czy hasło zgadza się z BD
        {
            $check = substr($row2['proba'], 0, 2);
            $attempt = $row2['proba'];
            if ($check == "b-") {
                $blockedTime = substr($attempt, 2);
                if (time() < $blockedTime) {
                    echo "<font color=\"red\">Gived three times incorrect data. Account will be locked ", date("Y-m-d H:i:s ", $blockedTime), "</font><br>";
                    echo "<a href=\"logout.php\">go back</a>";
                } else {
                    if ((!isset($_COOKIE['user'])) || ($_COOKIE['user'] != $row['id'])) {
                        setcookie("user", $row['id'], mktime(23, 59, 59, date("m"), date("d"), date("Y")));
                        setcookie("user_n", $row['login'], mktime(23, 59, 59, date("m"), date("d"), date("Y")));
                    }
                    $sql = "INSERT INTO logs VALUES (NULL,$idk,'$ip','$date')";
                    mysqli_query($connection, $sql);
                    $sql = "UPDATE logserror SET proba='0' WHERE idu='$idk'";
                    mysqli_query($connection, $sql);
                    $location = "files.php";
                    header("Location: $location");
                }
            } else {
                if ((!isset($_COOKIE['user'])) || ($_COOKIE['user'] != $row['id'])) {
                    setcookie("user", $row['id'], mktime(23, 59, 59, date("m"), date("d"), date("Y")));
                    setcookie("user_n", $row['login'], mktime(23, 59, 59, date("m"), date("d"), date("Y")));
                }
                $sql = "INSERT INTO logs VALUES (NULL,$idk,'$ip','$date')";
                mysqli_query($connection, $sql);
                $sql = "UPDATE logserror SET proba='0' WHERE idu='$idk'";
                mysqli_query($connection, $sql);
                $location = "files.php";
                header("Location: $location");
            }
        } else {
            $attempt = $row2['proba'];
            if ($attempt == '2') {
                $attempt = "b-" . strtotime("+1 minutes", time());
                $sql = "UPDATE logserror SET proba='$attempt',datagodzina='$date' WHERE idu='$idk'";
                mysqli_query($connection, $sql);
            }
            if (substr($attempt, 0, 2) == "b-") {
                $blockedTime = substr($attempt, 2);
                if (time() < $blockedTime) {
                    echo "<font color=\"red\">Gived three times incorrect data. Account will be locked ", date("Y-m-d H:i:s ", $blockedTime), "</font><br>";
                } else {
                    $sql = "UPDATE logserror SET proba='1',datagodzina='$date' WHERE idu='$idk'";
                    mysqli_query($connection, $sql);
                    echo "Password incorrect<br><br>";
                }
            } else {
                if (IsSet($row2)) {
                    $attempt = $row2['proba'] + 1;
                    $sql = "UPDATE logserror SET proba='$attempt',datagodzina='$date' WHERE idu='$idk'";
                    mysqli_query($connection, $sql);
                    echo "Password incorrect<br><br>";
                } else {
                    $attempt = $row2['proba'] + 1;
                    $sql = "INSERT INTO logserror VALUES (NULL,$idk,'$ip','$date','$attempt')";
                    mysqli_query($connection, $sql);
                    echo "Password incorrect<br><br>";
                }
            }
            mysqli_close($connection);
            echo $row['idk'];
            echo "<a href=\"logout.php\">go back</a>";
        }
    }
?>

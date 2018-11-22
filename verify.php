<?php
$ipaddress = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}
$details = ip_details($ipaddress);
$ip=$details -> ip;
$info = get_browser(null,true);
$przegladarka = $info['browser'];
$system = $info['platform'];
$godzina = date("Y-m-d H:i:s", time());
$user=strtolower($_POST['user']); // login z formularza
 $pass=$_POST['pass']; // hasło z formularza 
 $link = mysqli_connect("serwer1829042.home.pl", "28887864_github","githubzadanie7", "28887864_github"); // połączenie z BD – wpisać swoje parametry !!!
 if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
 mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
 $query ="SELECT * FROM users WHERE login='$user'";
 $result = mysqli_query($link, $query); // pobranie z BD wiersza, w którym login=login z formularza
 $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
 $idk=$rekord['id'];
 $query ="SELECT * FROM logserror WHERE idu='$idk'";
 $result = mysqli_query($link, $query); 
 $rekord1 = mysqli_fetch_array($result); 
 if(!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
{
     echo "Login incorrect<br><br>";
 echo "<a href=\logout.php\">go back</a>";  
 }
else
 { // Jeśli $rekord istnieje
 if($rekord['haslo']==$pass )// czy hasło zgadza się z BD
 {  
     $spr=substr($rekord1['proba'], 0, 2);
     $pr=$rekord1['proba'];
     if($spr=="b-"){
            $blockedTime = substr($pr, 2);
            if(time() < $blockedTime){
            echo "<font color=\"red\">Gived three times incorrect data. Account will be locked ",date("Y-m-d H:i:s ", $blockedTime),"</font><br>"; 
            echo "<a href=\"logout.php\">go back</a>"; 
            }else{
 if ((!isset($_COOKIE['user'])) || ($_COOKIE['user']!=$rekord['id'])){
            setcookie("user", $rekord['id'], mktime(23,59,59,date("m"),date("d"),date("Y")));
            setcookie("user_n", $rekord['login'], mktime(23,59,59,date("m"),date("d"),date("Y")));
    }
          $query="INSERT INTO logs VALUES (NULL,$idk,'$ip','$godzina')";
          mysqli_query($link, $query);
          $query="UPDATE logserror SET proba='0' WHERE idu='$idk'";
          mysqli_query($link, $query);
          $dalej="files.php";
          header("Location: $dalej");
 }}else{
      if ((!isset($_COOKIE['user'])) || ($_COOKIE['user']!=$rekord['id'])){
            setcookie("user", $rekord['id'], mktime(23,59,59,date("m"),date("d"),date("Y")));
            setcookie("user_n", $rekord['login'], mktime(23,59,59,date("m"),date("d"),date("Y")));
    }
          $query="INSERT INTO logs VALUES (NULL,$idk,'$ip','$godzina')";
          mysqli_query($link, $query);
          $query="UPDATE logserror SET proba='0' WHERE idu='$idk'";
          mysqli_query($link, $query);
          $dalej="files.php";
          header("Location: $dalej");
 }}
 else
 {
      $pr=$rekord1['proba'];
     if ($pr=='2'){
              $pr="b-" . strtotime("+1 minutes", time());
              $query="UPDATE logserror SET proba='$pr',datagodzina='$godzina' WHERE idu='$idk'";
              mysqli_query($link, $query);
          }
          if(substr($pr, 0, 2) == "b-"){
            $blockedTime = substr($pr, 2);
            if(time() < $blockedTime){
                echo "<font color=\"red\">Gived three times incorrect data. Account will be locked ",date("Y-m-d H:i:s ", $blockedTime),"</font><br>"; 
            }else{
                $query="UPDATE logserror SET proba='1',datagodzina='$godzina' WHERE idu='$idk'";
                mysqli_query($link, $query);
                echo "Password incorrect<br><br>";
            }}else{  
            if (IsSet($rekord1)){
                $pr=$rekord1['proba']+1;
                $query="UPDATE logserror SET proba='$pr',datagodzina='$godzina' WHERE idu='$idk'";
                mysqli_query($link, $query);
                 echo "Password incorrect<br><br>";
            }else{
         $pr=$rekord1['proba']+1;
          $query="INSERT INTO logserror VALUES (NULL,$idk,'$ip','$godzina','$pr')";
          mysqli_query($link, $query);
           echo "Password incorrect<br><br>";
            }
            }
 mysqli_close($link);
 echo $rekord['idk'];
 echo "<a href=\"logout.php\">go back</a>"; 
 }
}
?>

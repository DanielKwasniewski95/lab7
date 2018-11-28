<?php
$ipaddress = $_SERVER["REMOTE_ADDR"];

/*function getDetails($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}*/

require_once ('details.php');
require_once ('db_data.php');

$details = getDetails($ipaddress);
$ip=$details -> ip;
    /*$dbhost="serwer1829042.home.pl"; $dbuser="28887864_github"; $dbpassword="githubzadanie7"; $dbname="28887864_github";*/
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$connection) {
            echo "Błąd połączenia z MySQL." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }    
        $idk=$_COOKIE['user'];
      $sql ="SELECT * FROM logserror WHERE idu=$idk order by datagodzina desc limit 1";
      $result = mysqli_query($connection, $sql);
      $row = mysqli_fetch_array($result);
      ?>
<html>
<head>
    <title>Kwasniewski</title>
</head>

<body>
<a href="logout.php">Log out</a>

<?php
 //echo "Zalogowany jako: <b>",$_COOKIE['user_n'],"</b>";
 ?>
<p><b><font color="yellow">
<?php
$user=$_COOKIE['user_n'];
if(isset($user)){
    if(!empty($row)){
    echo "Last incorrect sign in was - ",$row['datagodzina'],"";
   
    }
?>
</font></b></p>
List of directories<br>
<?php
$user=$_COOKIE['user_n'];
$directory= "/z7/users/$user";
$files = scandir($directory);
$arrlength = count($files);
for($x = 2; $x < $arrlength; $x++) {
    
  if (is_file("/z7/users/$user/$files[$x]")){
    echo "<a href='/z7/users/$user/$files[$x]' download='$files[$x]'>$files[$x]</a><br>";
  }else{ 
      echo $files[$x],"<br>";
      $directory2= "/z7/users/$user/$files[$x]";
      $files2 = scandir($directory2);
      $arrlength2 = count($files2);
        for($y = 2; $y < $arrlength2; $y++) {
        
        if (is_file("/z7/users/$user/$files[$x]/$files2[$y]")){
        echo "&#8970 <a href='/z7/users/$user/$files[$x]/$files2[$y]' download='$files2[$y]'>$files2[$y]</a>";
        }else{ 
            echo "&#8594",$files2[$y];
        }
            echo "<br>";
            }
   }
  }
    echo "<br>";

?>
select directory<br>
<form action="get.php" method="POST" ENCTYPE="multipart/form-data">
<?php
if (is_dir($directory)) {
    if ($dh = opendir($directory)) {
        while (($file = readdir($dh)) !== false) {
            if(is_dir("/z7/users/$user/$file") && $file != '.' && $file != '..'){
            echo "<input type=\"checkbox\" name=\"folder\" value =$file>$file<br><br>";
            }
        }
        closedir($dh);
    }
}
}else{
    echo "<script>location.href='index.php';</script>";
}
?>
 <input type="file" name="plik"/>
 <input type="submit" value="Send file"/>
 </form>
Create directory
<form method="POST" action="create.php">
        Name:<input type="text" name="n_kat">
        <input type="submit" value="Create"/>
    </form>
</body>
</html>
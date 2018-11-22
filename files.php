<?php
$ipaddress = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}
$details = ip_details($ipaddress);
$ip=$details -> ip;
    $dbhost="serwer1829042.home.pl"; $dbuser="28887864_github"; $dbpassword="githubzadanie7"; $dbname="28887864_github";
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$polaczenie) {
            echo "Błąd połączenia z MySQL." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }    
        $idk=$_COOKIE['user'];
      $query ="SELECT * FROM logs_fail WHERE idu=$idk order by datagodzina desc limit 1";
      $result = mysqli_query($polaczenie, $query); 
      $rekord1 = mysqli_fetch_array($result); 
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
$usr=$_COOKIE['user_n'];
if(isset($usr)){
    if(!empty($rekord1)){
    echo "Last incorrect sign in was - ",$rekord1['datagodzina'],"";
   
    }
?>
</font></b></p>
List of directories<br>
<?php
$usr=$_COOKIE['user_n'];
$dir= "/z7/users/$usr";
$files = scandir($dir);
$arrlength = count($files);
for($x = 2; $x < $arrlength; $x++) {
    
  if (is_file("/z7/users/$usr/$files[$x]")){
    echo "<a href='/z7/users/$usr/$files[$x]' download='$files[$x]'>$files[$x]</a><br>";
  }else{ 
      echo $files[$x],"<br>";
      $dir2= "/z7/users/$usr/$files[$x]";
      $files2 = scandir($dir2);
      $arrlength2 = count($files2);
        for($y = 2; $y < $arrlength2; $y++) {
        
        if (is_file("/z7/users/$usr/$files[$x]/$files2[$y]")){
        echo "&#8594<a href='/z7/users/$usr/$files[$x]/$files2[$y]' download='$files2[$y]'>$files2[$y]</a>";
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
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if(is_dir("/z7/users/$usr/$file") && $file != '.' && $file != '..'){
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
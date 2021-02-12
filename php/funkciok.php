<?php
function menu ($aktual_oldal) {
	$kosar_termek_szam = isset($_SESSION['kosar']) ? count($_SESSION['kosar']) : 0;
echo <<<EOT
	<header>
  <div class = menu-egyben>
    <h1 id="focim"> <img id = "mlogo" src = "kepek/main-logo.jpg" alt = "logo képe" width="40" height="40"> Webáruház </h1>
    <h2 id = "alcim">A legjobb választék olcsó termékekből!</h2>
    <ul>
EOT;
		if($aktual_oldal == 1){
		echo '<li class = menuelem id = "aktiv-oldal"> <a href = "index.php?oldal=fooldal"> Kezdőoldal </a> </li>';
		}
		else{
			echo '<li class = menuelem> <a href = "index.php?oldal=fooldal"> Kezdőoldal </a> </li>';
		}
        echo '<div class = menuelem>'; 
        if($aktual_oldal == 2){
			echo <<<EOT
		<div class="legordulo">
            <button class="legordulo-gomb" id="aktiv-oldal" >Kategóriák</button>
            <div class="legordulo-tartalom-kategoriak">
              <a href="index.php?oldal=konyvek"> Könyvek </a>
               <a href="index.php?oldal=autogumik">Autógumik</a>
              <a href="index.php?oldal=vegyes">Vegyes</a>
            </div>
          </div>
        </div>
EOT;
		}
		else{
		echo <<<EOT
		<div class="legordulo">
            <button class="legordulo-gomb">Kategóriák</button>
            <div class="legordulo-tartalom-kategoriak">
              <a href="index.php?oldal=konyvek"> Könyvek </a>
               <a href="index.php?oldal=autogumik">Autógumik</a>
              <a href="index.php?oldal=vegyes">Vegyes</a>
            </div>
          </div>
        </div>
EOT;
		}
		if($aktual_oldal == 3){
        echo '<li class = menuelem id="aktiv-oldal"> <a href = "index.php?oldal=szallitas"> Szállítás </a></li>';
		}
		else{
		echo '<li class = menuelem > <a href = "index.php?oldal=szallitas"> Szállítás </a></li>';
		}
		if($aktual_oldal == 4){
        echo '<li class = menuelem id="aktiv-oldal"><a href = index.php?oldal=elerhetoseg> Elérhetőség </a> </li>';}
		else{
		echo '<li class = menuelem><a href = index.php?oldal=elerhetoseg> Elérhetőség </a> </li>';	
		}
		echo <<<EOT
        <li id = "kijelentkezes"><a href = "php/kijelentkezes.php"><img src = "kepek/kijelentkezes.png" alt = "kijelentkezés képe" width="40" height="40"></a></li>
        <li id = "udv"> </li>
		<li id = "profil"><a href = "index.php?oldal=profil">Adataim</a> </li>
		<li id = "rendelesek" ><a href = "index.php?oldal=rendelesek">Rendelések</a></li>
		<li id = "termekv"><a href = "index.php?oldal=termekvaltoztatas">Termék változtatás</a></li>
        <li id = "bejelentkezes"><a href = "index.php?oldal=bejelentkezes"><img src = "kepek/bejelentkezes.png" alt = "Bejelentkezés képe" width="40" height="40"></a></li>
EOT;
		echo '<li id = "kosar">';
          echo'<a href = "index.php?oldal=kosar">';
          echo'<img src="kepek/kosar.png" alt="Kosár képe" width="40" height="40">';
		  echo'<i class = "kosar-kep"></i>';
		  echo "<span id = 'kosar_jelzo'>".$kosar_termek_szam."</span>";
         echo'</a>'; 
        echo'</li>';  
    echo'</ul>';
echo'</div>';
echo'</header>';
echo'<main>';

}
function fejlec($stringvaltozo){
echo <<<EOT
<!DOCTYPE html>
<html lang = "hu">
<head>
<meta charset="utf-8">
<meta name="description" content='Kiemelt ajánlatok a P Webáruházban!'>
<title>P Webáruház</title>
<meta name='viewport' content='width=device-width, initial-scale=1'>
EOT;
$stringalap = "css/";
$stringalap = $stringalap.$stringvaltozo.".css";
	echo "<link rel='stylesheet' type='text/css' media='screen' href='".$stringalap."'>";
$stringalap = "scripts/";
$stringalap = $stringalap.$stringvaltozo.".js";
	echo "<script type='text/javascript' src='".$stringalap."'></script>";
	echo "</head>";	
	echo "<body>";
}

function lablec(){
$evszam = date('Y');
echo<<<EOT

</main>
<footer id = "lablec"> 
<p>&copy; $evszam P Webáruház</p>
</footer>
</body>
</html>
EOT;
}

function adatb_csatlakozas(){
$szerver = "localhost";
$felhasz = "root";
$jelszo = "";
$adatb = "webapplication-database";
$conn = new mysqli($szerver, $felhasz, $jelszo, $adatb);
if ($conn->connect_error) {
  die("A szerverhez való csatlakozás meghiúsult: " . $conn->connect_error);
}
else{
	return $conn;
}	
}
?>
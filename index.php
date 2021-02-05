<!DOCTYPE html>
<html lang = "hu">
<head>
    <meta charset='utf-8'>
    <meta name="description" content="Kiemelt ajánlatok a P Webáruházban!">
    <title>P Webáruház</title>
    
    
    <meta name='viewport' content='width=device-width, initial-scale=1'>
      <link rel='stylesheet' type='text/css' media='screen' href='css/index.css'>
 <script type="text/javascript" src='scripts/index.js'></script>
</head>
<body>
    <!-- Menu -->
  <div class = menu-egyben>
    <h1 id="focim"> <img id = "mlogo" src = "kepek/main-logo.jpg" alt = "logo képe" width="40" height="40"> Webáruház </h1>
    <h2 id = "alcim">A legjobb választék olcsó termékekből!</h2>
    <ul>
        <li class = menuelem id = "aktiv-oldal"> <a href = "index.php"> Kezdőoldal </a> </li>
        <div class = menuelem> 
        <div class="legordulo">
            <button class="legordulo-gomb" >Kategóriák</button>
            <div class="legordulo-tartalom-kategoriak">
              <a href="konyvek.html"> Könyvek </a>
               <a href="autogumik.html">Autógumik</a>
              <a href="vegyes.html">Vegyes</a>
            </div>
          </div>
        </div>
        <li class = menuelem> <a href = "szallitas.html"> Szállítás </a></li>
        <li class = menuelem><a href = elerhetoseg.html> Elérhetőség </a> </li>
        <li id = "kijelentkezes"><a href = "php/kijelentkezes.php"><img src = "kepek/kijelentkezes.png" alt = "kijelentkezés képe" width="40" height="40"></a></li>
        <li id = "udv"> </li>
		<li id = "profil"><a href = "profil.php">Adataim</a> </li>
		<li id = "rendelesek" ><a href = "rendelesek.html">Rendelések</a></li>
		<li id = "termekv"><a href = "termekvaltoztatas.html">Termék változtatás</a></li>
        <li id = "bejelentkezes"><a href = "bejelentkezes.html"><img src = "kepek/bejelentkezes.png" alt = "Bejelentkezés képe" width="40" height="40"></a></li>
        <li id = "kosar">
          <a href = "kosar.html">
          <img src="kepek/kosar.png" alt="Kosár képe" width="40" height="40">
          </a>
        </li>  
    </ul>
</div>
<!-- Menu vege -->
<?php
session_start();
if (isset($_SESSION['bejelentkezve'])) {
echo "<script>";
echo "bejelentkezve(\"".$_SESSION['keresztnev']."\",".$_SESSION['id'].");";
echo "</script>";
}
?>
<article>
<!-- Adatok -->
<h3> Üdvözöljük Webáruházunkban! </h3>
<p> E-heti akcióink: </p>
<!-- at alakitani a statement-et-->
<?php
$szerver = "localhost";
$felhasz = "root";
$jelszo = "";
$adatb = "webapplication-database";

$conn = new mysqli($szerver, $felhasz, $jelszo, $adatb);
if ($conn->connect_error) {
  die("A szerverhez való csatlakozás meghiúsult: " . $conn->connect_error);
}

$sql = "SELECT kep FROM termekek";
$er = $conn->query($sql);

if ($er->num_rows > 0) {
  while($row = $er->fetch_assoc()) {
	echo "<img src = '".$row["kep"]."' alt = 'valami' id = 'akcioskep'>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>
</article>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['bejelentkezve'])) {
	header('Location: bejelentkezes.html');
	exit;
}
$szerver = "localhost";
$felhasz = "root";
$jelszo = "";
$adatb = "webapplication-database";
$conn = new mysqli($szerver, $felhasz, $jelszo, $adatb);
if ($conn->connect_error) {
  die("A szerverhez való csatlakozás meghiúsult: " . $conn->connect_error);
}
$stmt = $conn->prepare('SELECT veznev,jelszo FROM felhasznalok WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($veznev,$jelszo);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare('SELECT irsz,varos,utca,hazszam FROM cimek WHERE fid = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($irsz,$varos,$utca,$hazszam);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
    <meta name="description" content="Kiemelt ajánlatok a P Webáruházban!">
    <title>P Webáruház</title>
    
    
    <meta name='viewport' content='width=device-width, initial-scale=1'>
      <link rel='stylesheet' type='text/css' media='screen' href='css/profil.css'>
 <script type="text/javascript" src='scripts/main.js'></script>
</head>
<body>
<div class = menu-egyben>
    <h1 id="focim">P Webáruház</h1>
    <h2 id = "alcim">A legjobb választék olcsó termékekből!</h2>
    <ul>
        <li class = menuelem> <a href = "index.php"> Kezdőoldal </a> </li>
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
        <li id = "bejelentkezes"><a href = "bejelentkezes.html"><img src = "kepek/bejelentkezes.png" alt = "Bejelentkezés képe" width="40" height="40"></a></li>
        <li id = "kosar">
          <a href = "kosar.html">
          <img src="kepek/kosar.png" alt="Kosár képe" width="40" height="40">
          </a>
        </li>  
    </ul>
</div>
<p>Adataid</p>
<table>
 <tr>
   <td>E-mail cím:</td>
   <td><?=$_SESSION['email']?></td>
 </tr>
 <tr>
	<td>Jelszó::</td>
	<td><?=$jelszo?></td>
 </tr>
 <tr>
	<td>Vezetéknév:</td>
	<td><?=$veznev?></td>
 </tr>
  <tr>
	<td>Keresztnév:</td>
	<td><?=$_SESSION['keresztnev']?></td>
 </tr>
   <tr>
	<td>Keresztnév:</td>
	<td><?=$_SESSION['keresztnev']?></td>
 </tr>
  <tr>
	<td>Cím:</td>
 </tr>
    <tr>
	<td>Irányítószám:</td>
	<td><?=$irsz?></td>
 </tr>
    <tr>
	<td>Város:</td>
	<td><?=$varos?></td>
 </tr>
    <tr>
	<td>Utca:</td>
	<td><?=$utca?></td>
 </tr>
    <tr>
	<td>Házszám::</td>
	<td><?=$hazszam?></td>
 </tr>
</table>
</body>
</html>
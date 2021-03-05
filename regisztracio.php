<?php
//regisztracio oldala

//alapfunkciok hasznalata
include 'php/funkciok.php';
//oldal fejlecenek beallitasa(css es js script fajl is)
fejlec("regisztracio");
//menu beallitasa (a szam csak az aktiv oldal jelzo)(0, akkor nincs aktiv)
menu(0);
//javascript az ui megvaltoztatasahoz, ha bevagyunk jelentkezve
	echo "<script>";
	echo 'var x = window.matchMedia("(max-width: 900px)");';
	echo "nincs_bejelentkezve(x);";
	echo 'x.addListener(nincs_bejelentkezve);';
	echo "</script>";
?> 
<!-- regisztracio form -->   
<form action = "index.php?oldal=reg" method = "POST">
    <label>Vezetéknév</label><br>
    <input type="text" id = "veznev" name = "veznev"><br>
    <label>Keresztnév</label><br>
    <input type="text" id = "keresztnev" name = "keresztnev"><br>
    <label>E-mail cím</label><br>
    <input type="email" id = "email" name = "email"><br>
    <label>Jelszó</label><br>
    <input type="password" id = "jelszo" name = "jelszo"><br>
    <label>Jelszó megerősítése</label><br>
    <input type="password" id = "jelszom" name = "jelszom"><br> 
    <label>Írányítószám</label><br>
    <input type="number" id = "irsz" name = "irsz"><br>
    <label>Város</label><br>
    <input type="text" id = "varos" name = "varos"><br>
    <label>Utca</label><br>
    <input type="text" id = "utca" name = "utca"><br>   
    <label>Házszám</label><br>
    <input type="number" id = "hazszam" name = "hazszam"><br> 
    <input type="submit" value="Regisztráció" name = "submit">
</form>
<?php
//lablec
lablec();
?>
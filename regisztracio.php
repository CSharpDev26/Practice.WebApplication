<?php
include 'php/funkciok.php';
fejlec("regisztracio");
menu(0);
echo "<script>";
echo "nincs_bejelentkezve();";
echo "</script>";
?>    
<form action = "php/reg.php" method = "POST">
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
lablec();
?>
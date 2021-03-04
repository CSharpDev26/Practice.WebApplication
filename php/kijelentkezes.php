<?php
//kijelentkezes, egyeszeru unset

session_start();
unset($_SESSION['bejelentkezve']);
unset($_SESSION['email']);
unset($_SESSION['id']);
unset($_SESSION['keresztnev']);
header('Location: ../index.php?oldal=fooldal');
?>
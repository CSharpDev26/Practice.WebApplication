<?php
session_start();
$oldal = isset($_GET['oldal']) && file_exists($_GET['oldal'] . '.php') ? $_GET['oldal'] : 'fooldal';
include $oldal . '.php';
?>

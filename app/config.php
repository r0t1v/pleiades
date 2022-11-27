<?php
# ------------------------------------------------------------------------------
# Pleiades
# ------------------------------------------------------------------------------
date_default_timezone_set('America/Belem');
$servername = 'Pleiades';
$releaseversion ='v0.1.1';
# ------------------------------------------------------------------------------
# Database config
# ------------------------------------------------------------------------------
$dbserver = "127.0.0.1:3306";
$username = "root";
$password = "";
$db= "pleiades";

$conn = mysqli_connect($dbserver, $username, $password, $db);
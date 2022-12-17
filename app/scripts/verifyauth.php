<?php 
if(!isset($_SESSION['IsLogged']))
{
    header("Location: ..\index.php");
    exit;
}
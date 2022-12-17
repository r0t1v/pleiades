<?php
if(isset($_SESSION['IsLogged']))
{
    header("Location: ..\app\pages\system.php");
    exit;
}
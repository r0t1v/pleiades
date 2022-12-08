<?php
if(isset($_SESSION['IsLogged']))
{
    header("Location: ../pleiades/pages/system.php");
    exit;
}
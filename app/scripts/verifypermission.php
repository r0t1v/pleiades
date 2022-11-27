<?php 
session_start();
if($_SESSION['classeuser']==0)
{
    header("Location: ../pages/systemadmin.php");
    exit;
}
else{
    header("Location: ../pages/system.php");
    exit;
}
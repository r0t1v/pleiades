<?php 
session_start();
if($_SESSION['ClasseUser']==0)
{
    header("Location: ..\system\systemadmin.php");
    exit;
}
else{
    header("Location: ..\system.php");
    exit;
}
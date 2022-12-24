<?php 
session_start();
if($_SESSION['DataAccount']['classe']==0)
{
    header("Location: ..\system\systemadmin.php");
    exit;
}
else{
    header("Location: ..\system.php");
    exit;
}
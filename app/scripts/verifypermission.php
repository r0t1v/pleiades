<?php 
session_start();
if($_SESSION['DataAccount']['classe']==0)
{
    header("Location: ..\system\SystemAdmin.php");
    exit;
}
else{
    header("Location: ..\System.php");
    exit;
}
<?php 
if(!isset($_SESSION['DataAccount']['id']))
{
    header("Location: ..\index.php");
    exit;
}
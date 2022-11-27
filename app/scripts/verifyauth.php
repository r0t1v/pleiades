<?php 
if(!isset($_SESSION['islogged']))
{
    header("Location: ../index.php");
    exit;
}
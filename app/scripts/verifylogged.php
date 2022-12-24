<?php
if(isset($_SESSION['DataAccount']['id']))
{
    header("Location: ..\app\pages\system.php");
    exit;
}
<?php
if(isset($_SESSION['islogged']))
{
    header("Location: ../pleiades/pages/system.php");
    exit;
}
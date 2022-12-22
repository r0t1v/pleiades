<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts\verifyauth.php';

if($_SESSION['ContNotify']>=1){
    $QueryCleanTopNotifications = "UPDATE notifications SET visualizado='1' WHERE id_conta='".$_SESSION['IsLogged']."' AND visualizado='0' ORDER BY data_notification DESC";
    $QueryCleanTopNotificationsExec = mysqli_query($CONNECTION_DB, $QueryCleanTopNotifications);
	$_SESSION['ContNotify'] = 0;
	$_SESSION['NotificationTop1'] = null;
	$_SESSION['NotificationTop2'] = null;
	$_SESSION['NotificationTop3'] = null;
		
    $Fallback = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/system.php';
    header("Location: {$Fallback}");
    exit;
}else{
    $Fallback = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/system.php';
    header("Location: {$Fallback}");
    exit;
}

mysqli_close($CONNECTION_DB);
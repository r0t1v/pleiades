<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts\verifyauth.php';

if($_SESSION['DataNotifications']['CountNotifications']>=1){
    $QueryCleanNotifications = "UPDATE notifications SET visualizado='1' WHERE id_conta='".$_SESSION['DataAccount']['id']."' AND visualizado='0' ORDER BY data_notification DESC";
    $QueryCleanNotificationsExec = mysqli_query($CONNECTION_DB, $QueryCleanNotifications);

    /* Update Notifications */
    unset($_SESSION['DataNotifications']);
    $QueryNotifications = "SELECT descricao,tipo_notification FROM notifications WHERE visualizado='0' AND id_conta='".$_SESSION['DataAccount']['id']."' ORDER BY data_notification DESC";
    $QueryNotificationsExec = mysqli_query($CONNECTION_DB, $QueryNotifications);
    for($j=0; $j<mysqli_num_rows($QueryNotificationsExec); $j++){
        $DataTools = mysqli_fetch_assoc($QueryNotificationsExec);
        $_SESSION['DataNotifications'][$j][] = $DataTools['descricao'];
        $_SESSION['DataNotifications'][$j][] = $DataTools['tipo_notification'];
    }
    $_SESSION['DataNotifications']['CountNotifications'] = mysqli_num_rows($QueryNotificationsExec);
    /* Update Notifications */

    $Fallback = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/System.php';
    header("Location: {$Fallback}");
    exit;
}else{
    $Fallback = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/System.php';
    header("Location: {$Fallback}");
    exit;
}

mysqli_close($CONNECTION_DB);
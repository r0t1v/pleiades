<?php
session_start();
require __DIR__.'\..\..\config.php';
include __DIR__.'\..\..\scripts\verifyauth.php';

$QueryDeleteExists = "DELETE FROM usertools WHERE tipotool=2 AND id_conta='".$_SESSION['DataAccount']['id']."'";
$QueryDeleteExistsExec = mysqli_query($CONNECTION_DB, $QueryDeleteExists);

$QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['DataAccount']['id']."','Deleção em ferramentas','4','".date('Y-m-d H:i:s')."','0')";
$QueryInsertNotificationExec = mysqli_query($CONNECTION_DB, $QueryInsertNotification);

/* Update Tools */
unset($_SESSION['UserTools']);
$QueryAnydeskUser = "SELECT login,pass,tipotool FROM usertools WHERE id_conta='".$_SESSION['DataAccount']['id']."'";
$QueryAnydeskUserExec = mysqli_query($CONNECTION_DB, $QueryAnydeskUser);

for($k=0; $k<mysqli_num_rows($QueryAnydeskUserExec); $k++){
    $DataTools = mysqli_fetch_assoc($QueryAnydeskUserExec);
    $_SESSION['UserTools'][$k][] = $DataTools['login'];
    $_SESSION['UserTools'][$k][] = $DataTools['pass'];
    $_SESSION['UserTools'][$k][] = $DataTools['tipotool'];
}
$_SESSION['UserTools']['CountTools'] = mysqli_num_rows($QueryAnydeskUserExec);
/* Update Tools */

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

$_SESSION['Msg'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram salvas com sucesso no banco de dados!</div>';
header("Location: ..\..\pages\Corporate_page.php");
exit;

mysqli_close($CONNECTION_DB);
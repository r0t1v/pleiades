<?php
session_start();
require __DIR__.'\..\..\config.php';
include __DIR__.'\..\..\scripts\verifyauth.php';

$QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['IsLogged']."','Mudança em ferramentas','4','".date('Y-m-d H:i:s')."','0')";
$QueryInsertNotificationExec = mysqli_query($CONNECTION_DB, $QueryInsertNotification);
$_SESSION['ContNotify'] = 0;
$_SESSION['NotificationTop1'] = null;
$_SESSION['NotificationTop2'] = null;
$_SESSION['NotificationTop3'] = null;
$_SESSION['UserAnyDeskId']=null;
$QueryDeleteExists = "DELETE FROM usertools WHERE tipotool=1 AND id_conta='".$_SESSION['IsLogged']."'";
$QueryDeleteExistsExec = mysqli_query($CONNECTION_DB, $QueryDeleteExists);

/* Notifications*/
$QueryCountNotifications = "SELECT COUNT(id_notification)cont FROM notifications WHERE visualizado='0' AND id_conta='".$_SESSION['IsLogged']."'";
$QueryCountNotificationsExec = mysqli_query($CONNECTION_DB, $QueryCountNotifications);
$QueryCountNotificationsResult = $QueryCountNotificationsExec->fetch_assoc();
$_SESSION['ContNotify'] = $QueryCountNotificationsResult['cont'];

$QueryNotifications = "SELECT descricao,tipo_notification FROM notifications WHERE visualizado='0' AND id_conta='".$_SESSION['IsLogged']."' ORDER BY data_notification DESC LIMIT 3";
$QueryNotificationsExec = mysqli_query($CONNECTION_DB, $QueryNotifications);
$QueryNotificationsRows = mysqli_num_rows($QueryNotificationsExec);

if($QueryNotificationsRows>=1){

    for($i=0; $i<$QueryNotificationsRows; $i++){
        
        $QueryNotificationsResult = $QueryNotificationsExec->fetch_assoc();

        switch ($QueryNotificationsResult['tipo_notification']) {
            case 1:
                $SaveNotificationArray[$i] = '<li><a class="dropdown-item" href="system.php"><span class="badge rounded-pill text-bg-danger"><i class="bi bi-bell-fill"></i> Novo</span> '.$QueryNotificationsResult['descricao'].'<br><small>Você tem um alerta do sistema!</small></a></li>';
                break;
            case 2:
                $SaveNotificationArray[$i] = '<li><a class="dropdown-item" href="mytickets.php"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-bell-fill"></i> Novo</span> '.$QueryNotificationsResult['descricao'].'<br><small>Você tem uma nova notificação!</small></a></li>';
                break;
            case 3:
                $SaveNotificationArray[$i] = '<li><a class="dropdown-item" href="myprofile.php"><span class="badge rounded-pill text-bg-info"><i class="bi bi-bell-fill"></i> Novo</span> '.$QueryNotificationsResult['descricao'].'<br><small>Nova alteração efetuada na conta!</small></a></li>';
                break;
            case 4:
                $SaveNotificationArray[$i] = '<li><a class="dropdown-item" href="corporate_page.php"><span class="badge rounded-pill text-bg-success"><i class="bi bi-bell-fill"></i> Novo</span> '.$QueryNotificationsResult['descricao'].'<br><small>Nova alteração efetuada na conta!</small></a></li>';
                break;
        }
    }

    if(count($SaveNotificationArray)==3){
        $_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
        $_SESSION['NotificationTop2'] = $SaveNotificationArray[1];
        $_SESSION['NotificationTop3'] = $SaveNotificationArray[2];
    }elseif(count($SaveNotificationArray)==2){
        $_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
        $_SESSION['NotificationTop2'] = $SaveNotificationArray[1];
    }else{
        $_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
    }

}else{
    $_SESSION['NotificationTop1'] = null;
    $_SESSION['NotificationTop2'] = null;
    $_SESSION['NotificationTop3'] = null;
}
/* Notifications*/

$_SESSION['MsgCorpPage'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram salvas com sucesso no banco de dados!</div>';
header("Location: ..\..\pages\corporate_page.php");
exit;

mysqli_close($CONNECTION_DB);
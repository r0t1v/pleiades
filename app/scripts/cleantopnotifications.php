<?php
session_start();
require __DIR__.'/../config.php';
include __DIR__.'/../scripts/verifyauth.php';

if($_SESSION['ContNotify']>=1){
    $QueryCleanTopNotifications = "UPDATE notifications SET visualizado='1' WHERE id_conta='".$_SESSION['IsLogged']."' ORDER BY data_notification DESC LIMIT 3";
    $QueryCleanTopNotificationsExec = mysqli_query($CONNECTION_DB, $QueryCleanTopNotifications);

    $QueryNotifications = "SELECT descricao,tipo_notification FROM notifications WHERE visualizado='0' AND id_conta='".$_SESSION['IsLogged']."' ORDER BY data_notification DESC LIMIT 3";
	$QueryNotificationsExec = mysqli_query($CONNECTION_DB, $QueryNotifications);
	$QueryNotificationsRows = mysqli_num_rows($QueryNotificationsExec);

		if($QueryNotificationsRows>=1){

			for($i=0; $i<$QueryNotificationsRows; $i++){
				
				$QueryNotificationsResult = $QueryNotificationsExec->fetch_assoc();
				
				if($QueryNotificationsResult['tipo_notification']==1){
					$SaveNotificationArray[$i] = '<li><a class="dropdown-item" href="system.php"><span class="badge rounded-pill text-bg-danger"><i class="bi bi-bell-fill"></i> Novo</span> '.$QueryNotificationsResult['descricao'].'<br><small>Você tem um alerta do sistema!</small></a></li>';
				}
				elseif($QueryNotificationsResult['tipo_notification']==2){
					$SaveNotificationArray[$i] = '<li><a class="dropdown-item" href="mytickets.php"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-bell-fill"></i> Novo</span> '.$QueryNotificationsResult['descricao'].'<br><small>Você tem uma nova notificação!</small></a></li>';
				}
				else{
					$SaveNotificationArray[$i] = '<li><a class="dropdown-item" href="myprofile.php"><span class="badge rounded-pill text-bg-info"><i class="bi bi-bell-fill"></i> Novo</span> '.$QueryNotificationsResult['descricao'].'<br><small>Nova alteração efetuada na conta!</small></a></li>';
				}
			}

			if(count($SaveNotificationArray)==3){
				$_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
				$_SESSION['NotificationTop2'] = $SaveNotificationArray[1];
				$_SESSION['NotificationTop3'] = $SaveNotificationArray[2];
			}
			elseif(count($SaveNotificationArray)==2){
				$_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
				$_SESSION['NotificationTop2'] = $SaveNotificationArray[1];
			}
			else{
				$_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
			}

		}
		else{
			$_SESSION['MsgNotifications']='<p class="text-center">Você não tem notificações!</p>';
		}

    $fallback = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/system.php';
    header("Location: {$fallback}");
    exit;
}
else{
    $fallback = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pages/system.php';
    header("Location: {$fallback}");
    exit;
}
mysqli_close($CONNECTION_DB);
<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts\verifyauth.php';

$ChangeNewPass = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING);
$ChangeNewPassConfirm = filter_var($_POST['newpassconfirm'], FILTER_SANITIZE_STRING);

if($ChangeNewPass==$ChangeNewPassConfirm and strlen($ChangeNewPass)>=8 and strlen($ChangeNewPass)<=32 and strpbrk($ChangeNewPass,'!@#$%¨&*()')){
        
        $SenhaEncrypt = md5($ChangeNewPass);

        if($_SESSION['SenhaUser']!=$SenhaEncrypt){
            
            $QueryUpdatePass = "UPDATE users SET senha='$SenhaEncrypt' WHERE email='".$_SESSION['EmailUser']."'";
            $QueryUpdatePassExec = mysqli_query($CONNECTION_DB, $QueryUpdatePass);

            $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['IsLogged']."','Senha trocada','1','".date('Y-m-d H:i:s')."','0')";
            $QueryInsertNotificationExec = mysqli_query($CONNECTION_DB, $QueryInsertNotification);
            $_SESSION['ContNotify'] = 0;
            $_SESSION['NotificationTop1'] = null;
            $_SESSION['NotificationTop2'] = null;
            $_SESSION['NotificationTop3'] = null;

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
                $_SESSION['NotificationTop1'] = null;
			    $_SESSION['NotificationTop2'] = null;
			    $_SESSION['NotificationTop3'] = null;
            }

            $_SESSION['MsgChangePass'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> As condições foram atendidas e a senha foi trocada!</div>';
            header("Location: ..\pages\change_password.php");
            exit;
        }
        else{
            $_SESSION['MsgChangePass'] = '<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> A nova senha não pode ser igual a atual!</div>';
            header("Location: ..\pages\change_password.php");
	        exit;
        }
}
else{
    $_SESSION['MsgChangePass'] = '<div class="alert alert-danger" role="alert"><i class="bi bi-x-circle-fill"></i> As condições não foram atendidas! Por favor, tente novamente.</div>';
    header("Location: ..\pages\change_password.php");
	exit;
}

mysqli_close($CONNECTION_DB);
<?php
session_start();
require __DIR__.'\..\config.php';

$UserData = filter_var($_POST['loginuser'], FILTER_SANITIZE_EMAIL);
$PassData = md5(filter_var($_POST['loginpass'], FILTER_SANITIZE_STRING));

$QueryEmailExists = "SELECT email FROM users WHERE email='$UserData'";
$QueryEmailExistsExec = mysqli_query($CONNECTION_DB, $QueryEmailExists);
$QueryEmailExistsResult = mysqli_num_rows($QueryEmailExistsExec);

if($QueryEmailExistsResult){
	$QueryAccountData = "SELECT id,nome,social,classe,tag,urlprofile,email,senha,emailverificado,datacriacao FROM users WHERE email='$UserData' AND senha='$PassData'";
	$QueryAccountDataExec = mysqli_query($CONNECTION_DB, $QueryAccountData);
	$QueryAccountDataResult = mysqli_num_rows($QueryAccountDataExec);

	if ($QueryAccountDataResult) {
        $dados = $QueryAccountDataExec->fetch_assoc();
        $_SESSION['IsLogged'] = $dados['id'];
		$_SESSION['NomeUser'] = $dados['nome'];
		$_SESSION['SocialUser'] = $dados['social'];
		$_SESSION['ClasseUser'] = $dados['classe'];
		$_SESSION['TagUser'] = $dados['tag'];
		$_SESSION['UrlUser'] = $dados['urlprofile'];
		$_SESSION['EmailUser'] = $dados['email'];
		$_SESSION['SenhaUser'] = $dados['senha'];
		$_SESSION['EmailVerificadoUser'] = $dados['emailverificado'];
		$_SESSION['DataCriacaoUser'] = $dados['datacriacao'];

		$QueryUpdateLastView = "UPDATE users SET ultimovisto='".date('Y-m-d H:i:s')."' WHERE email='$UserData'";
		$QueryUpdateLastViewExec = mysqli_query($CONNECTION_DB, $QueryUpdateLastView);
		
		/* Contagem dos tickets*/
		$QueryCountTicketClosed = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['IsLogged']."' AND ticket_status='Finalizado'";
		$QueryCountTicketClosedExec = mysqli_query($CONNECTION_DB, $QueryCountTicketClosed);
		$QueryCountTicketClosedResult = $QueryCountTicketClosedExec->fetch_assoc();
		$_SESSION['TktConcluidoUser'] = $QueryCountTicketClosedResult['cont'];

		$QueryCountTicketPending = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['IsLogged']."' AND ticket_status='Pendente'";
		$QueryCountTicketPendingExec = mysqli_query($CONNECTION_DB, $QueryCountTicketPending);
		$QueryCountTicketPendingResult = $QueryCountTicketPendingExec->fetch_assoc();
		$_SESSION['TktPendenteUser'] = $QueryCountTicketPendingResult['cont'];

		$QueryCountTicketRejected = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['IsLogged']."' AND ticket_status='Rejeitado'";
		$QueryCountTicketRejectedExec = mysqli_query($CONNECTION_DB, $QueryCountTicketRejected);
		$QueryCountTicketRejectedResult = $QueryCountTicketRejectedExec->fetch_assoc();
		$_SESSION['TktRejeitadoUser'] = $QueryCountTicketRejectedResult['cont'];

		$QueryCountTicketCanceled = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['IsLogged']."' AND ticket_status='Cancelado'";
		$QueryCountTicketCanceledExec = mysqli_query($CONNECTION_DB, $QueryCountTicketCanceled);
		$QueryCountTicketCanceledResult = $QueryCountTicketCanceledExec->fetch_assoc();
		$_SESSION['TktCanceladoUser'] = $QueryCountTicketCanceledResult['cont'];
		/* Contagem dos tickets*/

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
		/* Tools*/
		$QueryAnydeskUser = "SELECT login,pass FROM usertools WHERE tipotool=1 AND id_conta='".$_SESSION['IsLogged']."'";
		$QueryAnydeskUserExec = mysqli_query($CONNECTION_DB, $QueryAnydeskUser);
		$QueryAnydeskUserRow = mysqli_num_rows($QueryAnydeskUserExec);
		
		if($QueryAnydeskUserRow){
			$QueryAnydeskUserResult = $QueryAnydeskUserExec->fetch_assoc();
			$_SESSION['UserAnyDeskId'] = $QueryAnydeskUserResult['login'];
			$_SESSION['UserAnyDeskPass'] = $QueryAnydeskUserResult['pass'];
		}else{
			$_SESSION['UserAnyDeskId'] = null;
			$_SESSION['UserAnyDeskPass'] = null;
		}
		
		$QueryTeamwUser = "SELECT login,pass FROM usertools WHERE tipotool=2 AND id_conta='".$_SESSION['IsLogged']."'";
		$QueryTeamwUserExec = mysqli_query($CONNECTION_DB, $QueryTeamwUser);
		$QueryTeamwUserRow = mysqli_num_rows($QueryTeamwUserExec);
		
		if($QueryTeamwUserRow){
			$QueryTeamwUserResult = $QueryTeamwUserExec->fetch_assoc();
			$_SESSION['UserTeamwId'] = $QueryTeamwUserResult['login'];
			$_SESSION['UserTeamwPass'] = $QueryTeamwUserResult['pass'];
		}else{
			$_SESSION['UserTeamwId'] = null;
			$_SESSION['UserTeamwPass'] = null;
		}

		$QueryRealVNCUser = "SELECT login,pass FROM usertools WHERE tipotool=3 AND id_conta='".$_SESSION['IsLogged']."'";
        $QueryRealVNCUserExec = mysqli_query($CONNECTION_DB, $QueryRealVNCUser);
        $QueryRealVNCUserRow = mysqli_num_rows($QueryRealVNCUserExec);
                
        if($QueryRealVNCUserRow){
            $QueryRealVNCUserResult = $QueryRealVNCUserExec->fetch_assoc();
            $_SESSION['UserRealVNCId'] = $QueryRealVNCUserResult['login'];
			$_SESSION['UserRealVNCPass'] = $QueryRealVNCUserResult['pass'];
        }else{
            $_SESSION['UserRealVNCId'] = null;
            $_SESSION['UserRealVNCPass'] = null;
        }

		$QueryNetCfgUser = "SELECT login,pass FROM usertools WHERE tipotool=4 AND id_conta='".$_SESSION['IsLogged']."'";
        $QueryNetCfgUserExec = mysqli_query($CONNECTION_DB, $QueryNetCfgUser);
        $QueryNetCfgUserRow = mysqli_num_rows($QueryNetCfgUserExec);
                
        if($QueryNetCfgUserRow){
            $QueryNetCfgUserResult = $QueryNetCfgUserExec->fetch_assoc();
            $_SESSION['UserNetCfgName'] = $QueryNetCfgUserResult['login'];
            $_SESSION['UserNetCfgIp'] = $QueryNetCfgUserResult['pass'];
        }else{
            $_SESSION['UserNetCfgName'] = null;
            $_SESSION['UserNetCfgIp'] = null;
        }
		/* Tools*/
	
			if($_SESSION['ClasseUser']==0){
				header("Location: ../pages/systemadmin.php");
				exit;
			}else{
				header("Location: ../pages/system.php");
				exit;
			}
	}else{
		$_SESSION['MsgLogin'] = '<div class="alert alert-danger" role="alert"><i class="bi bi-x-circle-fill"></i> A senha informada está incorreta!</div>';
		header("Location: ..\index.php");
		exit;
	}
}else{
	$_SESSION['MsgLogin'] = '<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> O email informado não está no banco de dados do servidor!</div>';
	header("Location: ..\index.php");
	exit;
}

mysqli_close($CONNECTION_DB);
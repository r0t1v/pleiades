<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts\verifyauth.php';

$ChangeProfileUsername = filter_var($_POST['profileusername'], FILTER_SANITIZE_STRING);
$ChangeProfileSocial = filter_var($_POST['profileusersocial'], FILTER_SANITIZE_STRING);
$ChangeProfileEmail = filter_var($_POST['profileuseremail'], FILTER_SANITIZE_STRING);
$ChangeProfileUrl = filter_var($_POST['profileuserurl'], FILTER_SANITIZE_STRING);

if(strlen($ChangeProfileUsername)>=3 and strlen($ChangeProfileUsername)<100 and strlen($ChangeProfileSocial)>=4 and strlen($ChangeProfileSocial)<50 and strlen($ChangeProfileEmail)>=5 and strlen($ChangeProfileEmail)<100 and strlen($ChangeProfileUrl)>=5 and strlen($ChangeProfileUrl)<100){
   
    if($ChangeProfileSocial==$_SESSION['SocialUser'] and $ChangeProfileEmail==$_SESSION['EmailUser']){
        $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',urlprofile='$ChangeProfileUrl' WHERE id='".$_SESSION['IsLogged']."'";
        $QueryUpdateProfileExec = mysqli_query($CONNECTION_DB, $QueryUpdateProfile);

        $QueryAccountDataRefresh = "SELECT nome,urlprofile FROM users WHERE id='".$_SESSION['IsLogged']."'";
	    $QueryAccountDataRefreshExec = mysqli_query($CONNECTION_DB, $QueryAccountDataRefresh);
        $data = $QueryAccountDataRefreshExec->fetch_assoc();
		$_SESSION['NomeUser'] = $data['nome'];
		$_SESSION['UrlUser'] = $data['urlprofile'];

        $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['IsLogged']."','Mudança no Cadastro','3','".date('Y-m-d H:i:s')."','0')";
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
			}elseif(count($SaveNotificationArray)==2){
				$_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
				$_SESSION['NotificationTop2'] = $SaveNotificationArray[1];
			}else{
				$_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
			}

		}else{
			$_SESSION['MsgNotifications'] = '<p class="text-center">Você não tem notificações!</p>';
		}

        $_SESSION['MsgUpdateProfile'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas no banco de dados!</div>';
        header("Location: ..\pages\myprofile.php");
        exit;

    }elseif($ChangeProfileSocial==$_SESSION['SocialUser'] and $ChangeProfileEmail!=$_SESSION['EmailUser']){
        $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',email='$ChangeProfileEmail',urlprofile='$ChangeProfileUrl',emailverificado='0' WHERE id='".$_SESSION['IsLogged']."'";
        $QueryUpdateProfileExec = mysqli_query($CONNECTION_DB, $QueryUpdateProfile);

        $QueryAccountDataRefresh = "SELECT nome,urlprofile,email,emailverificado FROM users WHERE id='".$_SESSION['IsLogged']."'";
	    $QueryAccountDataRefreshExec = mysqli_query($CONNECTION_DB, $QueryAccountDataRefresh);
        $data = $QueryAccountDataRefreshExec->fetch_assoc();
		$_SESSION['NomeUser'] = $data['nome'];
		$_SESSION['UrlUser'] = $data['urlprofile'];
		$_SESSION['EmailUser'] = $data['email'];
		$_SESSION['EmailVerificadoUser'] = $data['emailverificado'];

        $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['IsLogged']."','Mudança no Cadastro','3','".date('Y-m-d H:i:s')."','0')";
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
			}elseif(count($SaveNotificationArray)==2){
				$_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
				$_SESSION['NotificationTop2'] = $SaveNotificationArray[1];
			}else{
				$_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
			}

		}else{
			$_SESSION['MsgNotifications'] = '<p class="text-center">Você não tem notificações!</p>';
		}

        $_SESSION['MsgUpdateProfile'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas com sucesso no banco de dados!</div>';
        header("Location: ..\pages\myprofile.php");
        exit;

    }elseif($ChangeProfileSocial!=$_SESSION['SocialUser'] and $ChangeProfileEmail==$_SESSION['EmailUser']){
        $QuerySocialExists = "SELECT social FROM users WHERE social='$ChangeProfileSocial'";
        $QuerySocialExistsExec = mysqli_query($CONNECTION_DB, $QuerySocialExists);
        $QuerySocialExistsResult = mysqli_num_rows($QuerySocialExistsExec);

        if($QuerySocialExistsResult==0){
            $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',social='$ChangeProfileSocial',urlprofile='$ChangeProfileUrl' WHERE id='".$_SESSION['IsLogged']."'";
            $QueryUpdateProfileExec = mysqli_query($CONNECTION_DB, $QueryUpdateProfile);

            $QueryAccountDataRefresh = "SELECT nome,social,urlprofile FROM users WHERE id='".$_SESSION['IsLogged']."'";
	        $QueryAccountDataRefreshExec = mysqli_query($CONNECTION_DB, $QueryAccountDataRefresh);
            $data = $QueryAccountDataRefreshExec->fetch_assoc();
		    $_SESSION['NomeUser'] = $data['nome'];
		    $_SESSION['SocialUser'] = $data['social'];
		    $_SESSION['UrlUser'] = $data['urlprofile'];

            $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['IsLogged']."','Mudança no Cadastro','3','".date('Y-m-d H:i:s')."','0')";
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

            $_SESSION['MsgUpdateProfile'] =' <div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas no banco de dados!</div>';
            header("Location: ..\pages\myprofile.php");
            exit;
        }else{
            $_SESSION['MsgUpdateProfile'] = '<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> O nome de usuário já existe em nosso banco de dados, por favor tente outro!</div>';
            header("Location: ..\pages\myprofile.php");
            exit;
        }

    }else{
        $QuerySocialExists = "SELECT social FROM users WHERE social='$ChangeProfileSocial'";
        $QuerySocialExistsExec = mysqli_query($CONNECTION_DB, $QuerySocialExists);
        $QuerySocialExistsResult = mysqli_num_rows($QuerySocialExistsExec);

        $QueryEmailExists = "SELECT email FROM users WHERE email='$ChangeProfileEmail'";
        $QueryEmailExistsExec = mysqli_query($CONNECTION_DB, $QueryEmailExists);
        $QueryEmailExistsResult = mysqli_num_rows($QueryEmailExistsExec);

        if($QuerySocialExists==0 and $QueryEmailExists==0){
            $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',social='$ChangeProfileSocial',email='$ChangeProfileEmail',urlprofile='$ChangeProfileUrl',emailverificado='0' WHERE id='".$_SESSION['IsLogged']."'";
            $QueryUpdateProfileExec = mysqli_query($CONNECTION_DB, $QueryUpdateProfile);

            $QueryAccountDataRefresh = "SELECT nome,social,urlprofile,email,emailverificado FROM users WHERE id='".$_SESSION['IsLogged']."'";
	        $QueryAccountDataRefreshExec = mysqli_query($CONNECTION_DB, $QueryAccountDataRefresh);
            $data = $QueryAccountDataRefreshExec->fetch_assoc();
		    $_SESSION['NomeUser'] = $data['nome'];
		    $_SESSION['SocialUser'] = $data['social'];
		    $_SESSION['UrlUser'] = $data['urlprofile'];
		    $_SESSION['EmailUser'] = $data['email'];
		    $_SESSION['EmailVerificadoUser'] = $data['emailverificado'];

            $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['IsLogged']."','Mudança no Cadastro','3','".date('Y-m-d H:i:s')."','0')";
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
                }elseif(count($SaveNotificationArray)==2){
                    $_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
                    $_SESSION['NotificationTop2'] = $SaveNotificationArray[1];
                }else{
                    $_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
                }

            }else{
                $_SESSION['MsgNotifications'] = '<p class="text-center">Você não tem notificações!</p>';
            }

            $_SESSION['MsgUpdateProfile'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas com sucesso no banco de dados!</div>';
            header("Location: ..\pages\myprofile.php");
            exit;
        }else{
            $_SESSION['MsgUpdateProfile'] = '<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> O nome de usuário ou e-mail já existe em nosso banco de dados, por favor tente outro!</div>';
            header("Location: ..\pages\myprofile.php");
            exit;
        }
    }
}else{
    $_SESSION['MsgUpdateProfile'] = '<div class="alert alert-danger" role="alert"><i class="bi bi-x-circle-fill"></i> As condições não foram atendidas! Por favor, tente novamente.</div>';
    header("Location: ..\pages\myprofile.php");
	exit;
}

mysqli_close($CONNECTION_DB);
<?php
session_start();
require __DIR__.'/../config.php';

$UserData = filter_var($_POST['loginuser'], FILTER_SANITIZE_EMAIL);
$PassData = md5(filter_var($_POST['loginpass'], FILTER_SANITIZE_STRING));

$QueryEmailExists = "SELECT email FROM users WHERE email='$UserData'";
$QueryEmailExistsExec = mysqli_query($conn, $QueryEmailExists);
$QueryEmailExistsResult = mysqli_num_rows($QueryEmailExistsExec);

if($QueryEmailExistsResult){
	$QueryAccountData = "SELECT id,nome,social,classe,tag,urlprofile,email,emailverificado,datacriacao FROM users WHERE email='$UserData' AND senha='$PassData'";
	$QueryAccountDataExec = mysqli_query($conn, $QueryAccountData);
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
		$_SESSION['EmailVerificadoUser'] = $dados['emailverificado'];
		$_SESSION['DataCriacaoUser'] = $dados['datacriacao'];

		$QueryUpdateLastView = "UPDATE users SET ultimovisto='".date('Y-m-d')."' WHERE email='$UserData'";
		$QueryUpdateLastViewExec = mysqli_query($conn, $QueryUpdateLastView);
		
		/* Contagem dos tickets*/
		$QueryCountTicketClosed = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['IsLogged']."' AND ticket_status='Finalizado'";
		$QueryCountTicketClosedExec = mysqli_query($conn, $QueryCountTicketClosed);
		$QueryCountTicketClosedResult = $QueryCountTicketClosedExec->fetch_assoc();
		$_SESSION['TktConcluidoUser'] = $QueryCountTicketClosedResult['cont'];

		$QueryCountTicketPending = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['IsLogged']."' AND ticket_status='Pendente'";
		$QueryCountTicketPendingExec = mysqli_query($conn, $QueryCountTicketPending);
		$QueryCountTicketPendingResult = $QueryCountTicketPendingExec->fetch_assoc();
		$_SESSION['TktPendenteUser'] = $QueryCountTicketPendingResult['cont'];

		$QueryCountTicketRejected = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['IsLogged']."' AND ticket_status='Rejeitado'";
		$QueryCountTicketRejectedExec = mysqli_query($conn, $QueryCountTicketRejected);
		$QueryCountTicketRejectedResult = $QueryCountTicketRejectedExec->fetch_assoc();
		$_SESSION['TktRejeitadoUser'] = $QueryCountTicketRejectedResult['cont'];

		$QueryCountTicketCanceled = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['IsLogged']."' AND ticket_status='Cancelado'";
		$QueryCountTicketCanceledExec = mysqli_query($conn, $QueryCountTicketCanceled);
		$QueryCountTicketCanceledResult = $QueryCountTicketCanceledExec->fetch_assoc();
		$_SESSION['TktCanceladoUser'] = $QueryCountTicketCanceledResult['cont'];
		/* Contagem dos tickets*/

		/* Notifications*/
		$QueryCountNotifications = "SELECT COUNT(id_notification)cont FROM notifications WHERE visualizado='0' AND id_conta=".$_SESSION['IsLogged']." ORDER BY data_notification DESC LIMIT 3";
		$QueryCountNotificationsExec = mysqli_query($conn, $QueryCountNotifications);
		$QueryCountNotificationsResult = $QueryCountNotificationsExec->fetch_assoc();
		$_SESSION['ContNotify'] = $QueryCountNotificationsResult['cont'];
		/* Notifications*/

			if($_SESSION['ClasseUser']==0){
				header("Location: ../pages/systemadmin.php");
				exit;
			}
			else{
				header("Location: ../pages/system.php");
				exit;
			}
		}
		else{
		$_SESSION['MsgLogin']='<div class="alert alert-danger" role="alert"><i class="bi bi-x-circle-fill"></i> A senha informada está incorreta!</div>';
		header("Location: ../index.php");
		exit;
	}
}
else{
	$_SESSION['MsgLogin']='<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> O email informado não está no banco de dados do servidor!</div>';
	header("Location: ../index.php");
	exit;
}

mysqli_close($conn);
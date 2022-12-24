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

	if ($QueryAccountDataResult){
		$_SESSION['DataAccount'] = $QueryAccountDataExec->fetch_assoc();

		/* AccountUpdate */
		$QueryUpdateLastView = "UPDATE users SET ultimovisto='".date('Y-m-d H:i:s')."' WHERE email='$UserData'";
		$QueryUpdateLastViewExec = mysqli_query($CONNECTION_DB, $QueryUpdateLastView);
		/* AccountUpdate */

		/* Tickets */
		$QueryTicketData = "SELECT ticketstatus FROM tickets WHERE solicitante='".$_SESSION['DataAccount']['id']."' AND ticketstatus='Finalizado'";
		$QueryTicketDataExec = mysqli_query($CONNECTION_DB, $QueryTicketData);
		$_SESSION['DataTicket'] = $QueryTicketDataExec->fetch_assoc();
		/* Tickets */

		/* Notifications*/
		$QueryNotifications = "SELECT descricao,tipo_notification FROM notifications WHERE visualizado='0' AND id_conta='".$_SESSION['DataAccount']['id']."' ORDER BY data_notification";
		$QueryNotificationsExec = mysqli_query($CONNECTION_DB, $QueryNotifications);
		$_SESSION['DataNotifications'] = $QueryNotificationsExec->fetch_assoc();
		$_SESSION['DataNotifications']['CountNotifications'] = mysqli_num_rows($QueryNotificationsExec);
		/* Notifications*/
	
			if($_SESSION['DataAccount']['classe']==0){
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

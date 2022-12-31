<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts/verifyauth.php';

$NewTicketTitle = filter_var($_POST['newtickettitle'], FILTER_SANITIZE_STRING);
$NewTicketMsg = filter_var($_POST['newticketmsg'], FILTER_SANITIZE_STRING);
$NewTicketDesign = filter_var($_POST['newticketdesign'], FILTER_SANITIZE_STRING);
$NewTicketSLA = filter_var($_POST['newticketsla'], FILTER_SANITIZE_NUMBER_INT);
$TICKET_GEN = date('ymd').'.'.date('Hi').$_SESSION['DataAccount']['id'].mt_rand(1, 99);
$TICKET_HASH = '#'.md5($TICKET_GEN);
$TICKET_CHAT = str_replace('.','',$TICKET_GEN);

if(strlen($NewTicketTitle)>5 and strlen($NewTicketTitle)<=80 and strlen($NewTicketMsg)>=5 and strlen($NewTicketMsg)<1000 and strlen($NewTicketDesign)>=2 and strlen($NewTicketDesign)<50 and strlen($NewTicketSLA)>0 and strlen($NewTicketSLA)<10){

    $DataSLA = strtotime(date('Y-m-d H:i:s')) + $NewTicketSLA*3600;
    $CreateTicketNew = "INSERT INTO tickets(protocolo,solicitante,tickethash,designacao,nometicket,sla,ticketstatus,datapedido,datasla,datafinalizado,avaliation,chatcode) VALUES ('".$TICKET_GEN."','".$_SESSION['DataAccount']['id']."','".$TICKET_HASH."','".$NewTicketDesign."','".$NewTicketTitle."','".$NewTicketSLA."','Pendente','".date('Y-m-d H:i:s')."','".$DataSLA."','','','".$TICKET_CHAT."')";
    $CreateTicketNewQuery = mysqli_query($CONNECTION_DB, $CreateTicketNew);

    $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['DataAccount']['id']."','Ticket criado','2','".date('Y-m-d H:i:s')."','0')";
    $QueryInsertNotificationExec = mysqli_query($CONNECTION_DB, $QueryInsertNotification);

    $_SESSION['Msg'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Ticket criado!</div>';
	header("Location: ..\pages\ticket.php");
	exit;
}
else{
    $_SESSION['Msg'] = '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> As condições não foram atendidas! Por favor, tente novamente!</div>';
	header("Location: ..\pages\create_ticket.php");
	exit;
}
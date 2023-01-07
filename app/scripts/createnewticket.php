<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts/verifyauth.php';

$NewTicketTitle = filter_var($_POST['newtickettitle'], FILTER_SANITIZE_STRING);
$NewTicketMsg = filter_var($_POST['newticketmsg'], FILTER_SANITIZE_STRING);
$NewTicketDesign = filter_var($_POST['newticketdesign'], FILTER_SANITIZE_STRING);
$NewTicketSLA = filter_var($_POST['newticketsla'], FILTER_SANITIZE_NUMBER_INT);
$NewTicketFile = $_FILES['newfileattach'];

$TICKET_GEN = date('ymd').'.'.date('Hi').$_SESSION['DataAccount']['id'].mt_rand(1, 99);
$TICKET_HASH = '#'.md5($TICKET_GEN);
$FileNameUpload = $_SESSION['DataAccount']['id'].'_'.time().'_'.mt_rand(1, 99).'_'.$_FILES['newfileattach']['name'];

if($NewTicketFile['name']!=''){

    if(strlen($NewTicketTitle)>5 and strlen($NewTicketTitle)<=80 and strlen($NewTicketMsg)>=5 and strlen($NewTicketMsg)<1000 and strlen($NewTicketDesign)>=2 and strlen($NewTicketDesign)<50 and strlen($NewTicketSLA)>0 and strlen($NewTicketSLA)<10 and $NewTicketFile['size']<=$FILE_MAX_SIZE){

        $DataSLA = strtotime(date('Y-m-d H:i:s')) + $NewTicketSLA*3600;
        $CreateTicketNew = "INSERT INTO tickets(protocolo,solicitante,tickethash,designacao,nometicket,sla,ticketstatus,datapedido,datasla,datafinalizado,avaliation) VALUES ('".$TICKET_GEN."','".$_SESSION['DataAccount']['id']."','".$TICKET_HASH."','".$NewTicketDesign."','".$NewTicketTitle."','".$NewTicketSLA."','Pendente','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s',$DataSLA)."','','')";
        $CreateTicketNewQuery = mysqli_query($CONNECTION_DB, $CreateTicketNew);

        $CreateTicketChat = "INSERT INTO chat(id,msgcontent,enviadapor,ticketprotocolo,datamsg) VALUES ('','".$NewTicketMsg."','".$_SESSION['DataAccount']['id']."','".$TICKET_GEN."','".date('Y-m-d H:i:s')."')";
        $CreateTicketChatQuery = mysqli_query($CONNECTION_DB, $CreateTicketChat);

        $InsertTicketAttach = "INSERT INTO chat(id,msgcontent,enviadapor,ticketprotocolo,datamsg) VALUES ('','".$FileNameUpload."','".$_SESSION['DataAccount']['id']."','".$TICKET_GEN."','".date('Y-m-d H:i:s')."')";
        $InsertTicketAttachQuery = mysqli_query($CONNECTION_DB, $InsertTicketAttach);

        ftp_put($CONNECTION_FTP, $FileNameUpload, $_FILES['newfileattach']['tmp_name'], FTP_BINARY);

        $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['DataAccount']['id']."','Ticket criado','2','".date('Y-m-d H:i:s')."','0')";
        $QueryInsertNotificationExec = mysqli_query($CONNECTION_DB, $QueryInsertNotification);

        $_SESSION['Msg'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Ticket criado!</div>';
        header("Location: ..\pages\Ticket.php");
        exit;
    }else{
        $_SESSION['Msg'] = '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> As condições não foram atendidas! Por favor, tente novamente!</div>';
        header("Location: ..\pages\Create_ticket.php");
        exit;
    }

}else{

    if(strlen($NewTicketTitle)>5 and strlen($NewTicketTitle)<=80 and strlen($NewTicketMsg)>=5 and strlen($NewTicketMsg)<1000 and strlen($NewTicketDesign)>=2 and strlen($NewTicketDesign)<50 and strlen($NewTicketSLA)>0 and strlen($NewTicketSLA)<10 and $NewTicketFile['size']){

        $DataSLA = strtotime(date('Y-m-d H:i:s')) + $NewTicketSLA*3600;
        $CreateTicketNew = "INSERT INTO tickets(protocolo,solicitante,tickethash,designacao,nometicket,sla,ticketstatus,datapedido,datasla,datafinalizado,avaliation) VALUES ('".$TICKET_GEN."','".$_SESSION['DataAccount']['id']."','".$TICKET_HASH."','".$NewTicketDesign."','".$NewTicketTitle."','".$NewTicketSLA."','Pendente','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s',$DataSLA)."','','')";
        $CreateTicketNewQuery = mysqli_query($CONNECTION_DB, $CreateTicketNew);

        $CreateTicketChat = "INSERT INTO chat(id,msgcontent,enviadapor,ticketprotocolo,datamsg) VALUES ('','".$NewTicketMsg."','".$_SESSION['DataAccount']['id']."','".$TICKET_GEN."','".date('Y-m-d H:i:s')."')";
        $CreateTicketChatQuery = mysqli_query($CONNECTION_DB, $CreateTicketChat);

        $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['DataAccount']['id']."','Ticket criado','2','".date('Y-m-d H:i:s')."','0')";
        $QueryInsertNotificationExec = mysqli_query($CONNECTION_DB, $QueryInsertNotification);

        $_SESSION['Msg'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Ticket criado!</div>';
        header("Location: ..\pages\Ticket.php");
        exit;
    }else{
        $_SESSION['Msg'] = '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> As condições não foram atendidas! Por favor, tente novamente!</div>';
        header("Location: ..\pages\Create_ticket.php");
        exit;
    }

}

mysqli_close($CONNECTION_DB);
ftp_close($CONNECTION_FTP);
<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts/verifyauth.php';

$NewTicketNum = filter_var($_POST['newnumticket'], FILTER_SANITIZE_STRING);
$NewTicketHash = filter_var($_POST['newtickethash'], FILTER_SANITIZE_STRING);
$NewTicketTitle = filter_var($_POST['newtickettitle'], FILTER_SANITIZE_STRING);
$NewTicketMsg = filter_var($_POST['newticketmsg'], FILTER_SANITIZE_STRING);
$NewTicketDesign = filter_var($_POST['newticketdesign'], FILTER_SANITIZE_STRING);
$NewTicketSLA = filter_var($_POST['newticketsla'], FILTER_SANITIZE_NUMBER_INT);

echo $_POST['newnumticket'].'<br>',$_POST['newtickethash'].'<br>',$NewTicketTitle.'<br>',$NewTicketMsg.'<br>',$NewTicketDesign.'<br>',$NewTicketSLA;
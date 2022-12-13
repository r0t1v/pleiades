<?php
session_start();
require __DIR__.'/../config.php';
include __DIR__.'/../scripts/verifyauth.php';

$ChangeNewPass = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING);
$ChangeNewPassConfirm = filter_var($_POST['newpassconfirm'], FILTER_SANITIZE_STRING);

if($ChangeNewPass==$ChangeNewPassConfirm and strlen($ChangeNewPass)>=8 and strlen($ChangeNewPass)<=32 and strpbrk($ChangeNewPass,'!@#$%¨&*()')){
    $SenhaEncrypt = md5($changenewpass);
    $QueryUpdatePass = "UPDATE users SET senha='$SenhaEncrypt' WHERE email='".$_SESSION['EmailUser']."'";
    $QueryUpdatePassExec = mysqli_query($CONNECTION_DB, $QueryUpdatePass);
    $_SESSION['MsgChangePass']="<div class='alert alert-success' role='alert'><i class='bi bi-check-circle-fill'></i> As condições foram atendidas e a senha foi trocada!</div>";
    header("Location: ../pages/change_password.php");
	exit;
}
else{
    $_SESSION['MsgChangePass']="<div class='alert alert-danger' role='alert'><i class='bi bi-x-circle-fill'></i> As condições não foram atendidas! Por favor, tente novamente.</div>";
    header("Location: ../pages/change_password.php");
	exit;
}

mysqli_close($CONNECTION_DB);
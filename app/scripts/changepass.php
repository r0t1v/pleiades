<?php
session_start();
require __DIR__.'/../config.php';
include __DIR__.'/../scripts/verifyauth.php';

$a = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING);
$b = filter_var($_POST['newpassconfirm'], FILTER_SANITIZE_STRING);
$conta = $_SESSION['emailuser'];

if($a==$b and strlen($a)>=8 and strlen($a)<=32 and strpbrk($a,'!@#$%¨&*()')){
    $senhacript=md5($a);
    $c = "UPDATE users SET senha='$senhacript' WHERE email='$conta'";
	$d = mysqli_query($conn, $c);
    $_SESSION['msgchangepass']="<div class='alert alert-success' role='alert'><i class='bi bi-check-circle-fill'></i> As condições foram atendidas e a senha foi trocada!</div>";
    header("Location: ../pages/change_password.php");
	exit;
}
else{
    $_SESSION['msgchangepass']="<div class='alert alert-danger' role='alert'><i class='bi bi-x-circle-fill'></i> As condições não foram atendidas! Por favor, tente novamente.</div>";
    header("Location: ../pages/change_password.php");
	exit;
}
mysqli_close($conn);
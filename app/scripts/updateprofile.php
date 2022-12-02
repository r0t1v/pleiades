<?php
session_start();
require __DIR__.'/../config.php';
include __DIR__.'/../scripts/verifyauth.php';

$a = filter_var($_POST['profileusername'], FILTER_SANITIZE_STRING);
$b = filter_var($_POST['profileusersocial'], FILTER_SANITIZE_STRING);
$c = filter_var($_POST['profileuseremail'], FILTER_SANITIZE_STRING);
$d = filter_var($_POST['profileuserurl'], FILTER_SANITIZE_STRING);

if(strlen($a)>=3 and strlen($a)<100 and strlen($b)>=4 and strlen($b)<50 and strlen($c)>=5 and strlen($c)<100 and strlen($d)>=5 and strlen($d)<100){
    $conta = $_SESSION['islogged'];
    $e = "SELECT social FROM users WHERE social='$b'";
    $f = mysqli_query($conn, $e);
    $g = mysqli_num_rows($f);

    if($g==0){
        if($_SESSION['profileuseremail']==$_SESSION['emailuser']){
            $h = "UPDATE users SET nome='$a',social='$b',email='$c',urlprofile='$d' WHERE id='$conta'";
            $i = mysqli_query($conn, $h);
            $_SESSION['msgupdateprofile']='<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas  no banco de dados!</div>';
            header("Location: ../pages/myprofile.php");
            exit;
        }
        else{
            $j = "UPDATE users SET nome='$a',social='$b',email='$c',urlprofile='$d',emailverificado='0' WHERE id='$conta'";
            $k = mysqli_query($conn, $j);
            $_SESSION['msgupdateprofile']='<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas com sucesso no banco de dados!</div>';
            header("Location: ../pages/myprofile.php");
            exit;
        }
    }
    else{
        $_SESSION['msgupdateprofile']='<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> O nome de usuário já existe em nosso banco de dados, porfavor tente outro!</div>';
        header("Location: ../pages/myprofile.php");
        exit;
    }
}
else{
    $_SESSION['msgupdateprofile']='<div class="alert alert-danger" role="alert"><i class="bi bi-x-circle-fill"></i> As condições não foram atendidas! Por favor, tente novamente.</div>';
    header("Location: ../pages/myprofile.php");
	exit;
}
mysqli_close($conn);
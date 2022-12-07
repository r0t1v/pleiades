<?php
session_start();
require __DIR__.'/../config.php';
include __DIR__.'/../scripts/verifyauth.php';

$ChangeProfileUsername = filter_var($_POST['profileusername'], FILTER_SANITIZE_STRING);
$ChangeProfileSocial = filter_var($_POST['profileusersocial'], FILTER_SANITIZE_STRING);
$ChangeProfileEmail = filter_var($_POST['profileuseremail'], FILTER_SANITIZE_STRING);
$ChangeProfileUrl = filter_var($_POST['profileuserurl'], FILTER_SANITIZE_STRING);

if(strlen($ChangeProfileUsername)>=3 and strlen($ChangeProfileUsername)<100 and strlen($ChangeProfileSocial)>=4 and strlen($ChangeProfileSocial)<50 and strlen($ChangeProfileEmail)>=5 and strlen($ChangeProfileEmail)<100 and strlen($ChangeProfileUrl)>=5 and strlen($ChangeProfileUrl)<100){
    $QuerySocialExists = "SELECT social FROM users WHERE social='$b'";
    $QuerySocialExistsExec = mysqli_query($conn, $QuerySocialExists);
    $QuerySocialExistsResult = mysqli_num_rows($QuerySocialExistsExec);

    if($QuerySocialExistsResult==0 || $ChangeProfileSocial==$_SESSION['socialuser']){
        if($_SESSION['profileuseremail']==$_SESSION['emailuser']){
            $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',social='$ChangeProfileSocial',email='$ChangeProfileEmail',urlprofile='$ChangeProfileUrl' WHERE id='".$_SESSION['islogged']."'";
            $QueryUpdateProfileExec = mysqli_query($conn, $QueryUpdateProfile);
            $_SESSION['msgupdateprofile']='<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas  no banco de dados!</div>';
            header("Location: ../pages/myprofile.php");
            exit;
        }
        else{
            $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',social='$ChangeProfileSocial',email='$ChangeProfileEmail',urlprofile='$ChangeProfileUrl',emailverificado='0' WHERE id='".$_SESSION['islogged']."'";
            $QueryUpdateProfileExec = mysqli_query($conn, $QueryUpdateProfile);
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
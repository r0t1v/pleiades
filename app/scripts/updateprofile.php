<?php
session_start();
require __DIR__.'/../config.php';
include __DIR__.'/../scripts/verifyauth.php';

$ChangeProfileUsername = filter_var($_POST['profileusername'], FILTER_SANITIZE_STRING);
$ChangeProfileSocial = filter_var($_POST['profileusersocial'], FILTER_SANITIZE_STRING);
$ChangeProfileEmail = filter_var($_POST['profileuseremail'], FILTER_SANITIZE_STRING);
$ChangeProfileUrl = filter_var($_POST['profileuserurl'], FILTER_SANITIZE_STRING);

if(strlen($ChangeProfileUsername)>=3 and strlen($ChangeProfileUsername)<100 and strlen($ChangeProfileSocial)>=4 and strlen($ChangeProfileSocial)<50 and strlen($ChangeProfileEmail)>=5 and strlen($ChangeProfileEmail)<100 and strlen($ChangeProfileUrl)>=5 and strlen($ChangeProfileUrl)<100){
   
    if($ChangeProfileSocial==$_SESSION['SocialUser'] and $ChangeProfileEmail==$_SESSION['EmailUser']){
        $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',urlprofile='$ChangeProfileUrl' WHERE id='".$_SESSION['IsLogged']."'";
        $QueryUpdateProfileExec = mysqli_query($conn, $QueryUpdateProfile);

        $QueryAccountDataRefresh = "SELECT nome,urlprofile FROM users WHERE id='".$_SESSION['IsLogged']."'";
	    $QueryAccountDataRefreshExec = mysqli_query($conn, $QueryAccountDataRefresh);
        $data = $QueryAccountDataRefreshExec->fetch_assoc();
		$_SESSION['NomeUser'] = $data['nome'];
		$_SESSION['UrlUser'] = $data['urlprofile'];

        $_SESSION['MsgUpdateProfile']='<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas no banco de dados!</div>';
        header("Location: ../pages/myprofile.php");
        exit;
    }
    elseif($ChangeProfileSocial==$_SESSION['SocialUser'] and $ChangeProfileEmail!=$_SESSION['EmailUser']){
        $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',email='$ChangeProfileEmail',urlprofile='$ChangeProfileUrl',emailverificado='0' WHERE id='".$_SESSION['IsLogged']."'";
        $QueryUpdateProfileExec = mysqli_query($conn, $QueryUpdateProfile);

        $QueryAccountDataRefresh = "SELECT nome,urlprofile,email,emailverificado FROM users WHERE id='".$_SESSION['IsLogged']."'";
	    $QueryAccountDataRefreshExec = mysqli_query($conn, $QueryAccountDataRefresh);
        $data = $QueryAccountDataRefreshExec->fetch_assoc();
		$_SESSION['NomeUser'] = $data['nome'];
		$_SESSION['UrlUser'] = $data['urlprofile'];
		$_SESSION['EmailUser'] = $data['email'];
		$_SESSION['EmailVerificadoUser'] = $data['emailverificado'];

        $_SESSION['MsgUpdateProfile']='<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas com sucesso no banco de dados!</div>';
        header("Location: ../pages/myprofile.php");
        exit;

    }
    elseif($ChangeProfileSocial!=$_SESSION['SocialUser'] and $ChangeProfileEmail==$_SESSION['EmailUser']){
        $QuerySocialExists = "SELECT social FROM users WHERE social='$ChangeProfileSocial'";
        $QuerySocialExistsExec = mysqli_query($conn, $QuerySocialExists);
        $QuerySocialExistsResult = mysqli_num_rows($QuerySocialExistsExec);

        if($QuerySocialExistsResult==0){
                $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',social='$ChangeProfileSocial',urlprofile='$ChangeProfileUrl' WHERE id='".$_SESSION['IsLogged']."'";
                $QueryUpdateProfileExec = mysqli_query($conn, $QueryUpdateProfile);

                $QueryAccountDataRefresh = "SELECT nome,social,urlprofile FROM users WHERE id='".$_SESSION['IsLogged']."'";
	            $QueryAccountDataRefreshExec = mysqli_query($conn, $QueryAccountDataRefresh);
                $data = $QueryAccountDataRefreshExec->fetch_assoc();
		        $_SESSION['NomeUser'] = $data['nome'];
		        $_SESSION['SocialUser'] = $data['social'];
		        $_SESSION['UrlUser'] = $data['urlprofile'];

                $_SESSION['MsgUpdateProfile']='<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas no banco de dados!</div>';
                header("Location: ../pages/myprofile.php");
                exit;
        }
        else{
            $_SESSION['MsgUpdateProfile']='<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> O nome de usuário já existe em nosso banco de dados, por favor tente outro!</div>';
            header("Location: ../pages/myprofile.php");
            exit;
        }

    }
    else{
        $QuerySocialExists = "SELECT social FROM users WHERE social='$ChangeProfileSocial'";
        $QuerySocialExistsExec = mysqli_query($conn, $QuerySocialExists);
        $QuerySocialExistsResult = mysqli_num_rows($QuerySocialExistsExec);

        $QueryEmailExists = "SELECT email FROM users WHERE email='$ChangeProfileEmail'";
        $QueryEmailExistsExec = mysqli_query($conn, $QueryEmailExists);
        $QueryEmailExistsResult = mysqli_num_rows($QueryEmailExistsExec);

        if($QuerySocialExists==0 and $QueryEmailExists==0){
            $QueryUpdateProfile = "UPDATE users SET nome='$ChangeProfileUsername',social='$ChangeProfileSocial',email='$ChangeProfileEmail',urlprofile='$ChangeProfileUrl',emailverificado='0' WHERE id='".$_SESSION['IsLogged']."'";
            $QueryUpdateProfileExec = mysqli_query($conn, $QueryUpdateProfile);

            $QueryAccountDataRefresh = "SELECT nome,social,urlprofile,email,emailverificado FROM users WHERE id='".$_SESSION['IsLogged']."'";
	        $QueryAccountDataRefreshExec = mysqli_query($conn, $QueryAccountDataRefresh);
            $data = $QueryAccountDataRefreshExec->fetch_assoc();
		    $_SESSION['NomeUser'] = $data['nome'];
		    $_SESSION['SocialUser'] = $data['social'];
		    $_SESSION['UrlUser'] = $data['urlprofile'];
		    $_SESSION['EmailUser'] = $data['email'];
		    $_SESSION['EmailVerificadoUser'] = $data['emailverificado'];

            $_SESSION['MsgUpdateProfile']='<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram atualizadas com sucesso no banco de dados!</div>';
            header("Location: ../pages/myprofile.php");
            exit;
        }
        else{
            $_SESSION['MsgUpdateProfile']='<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> O nome de usuário ou e-mail já existe em nosso banco de dados, por favor tente outro!</div>';
            header("Location: ../pages/myprofile.php");
            exit;
        }
        }
}
else{
    $_SESSION['MsgUpdateProfile']='<div class="alert alert-danger" role="alert"><i class="bi bi-x-circle-fill"></i> As condições não foram atendidas! Por favor, tente novamente.</div>';
    header("Location: ../pages/myprofile.php");
	exit;
}

mysqli_close($conn);
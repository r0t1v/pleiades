<?php
session_start();
require __DIR__.'/../config.php';

$a = filter_var($_POST['loginuser'], FILTER_SANITIZE_EMAIL);
$b = md5(filter_var($_POST['loginpass'], FILTER_SANITIZE_STRING));

$c = "SELECT email FROM users WHERE email='$a'";
$d = mysqli_query($conn, $c);
$e= mysqli_num_rows($d);

if($e){
	$f = "SELECT id,nome,social,classe,tag,urlprofile,email,emailverificado FROM users WHERE email='$a' AND senha='$b'";
	$g = mysqli_query($conn, $f);
	$h = mysqli_num_rows($g);

	if ($h) {
        $dados = $g->fetch_assoc();
        $_SESSION['islogged'] = $dados['id'];
		$_SESSION['nomeuser'] = $dados['nome'];
		$_SESSION['classeuser'] = $dados['classe'];
		$lastview = date('Y-m-d');
		$aa = "UPDATE users SET ultimovisto='$lastview' WHERE email='$a'";
		$bb = mysqli_query($conn, $aa);
			if($_SESSION['classeuser']==0){
				header("Location: ../pages/systemadmin.php");
				exit;
			}
			else{
				header("Location: ../pages/system.php");
				exit;
			}
		}
		else{
		$_SESSION['msglogin']="<div class='alert alert-danger' role='alert'><i class='bi bi-x-circle-fill'></i> A senha informada está incorreta!</div>";
		header("Location: ../index.php");
		exit;
	}
}
else{
	$_SESSION['msglogin']="<div class='alert alert-warning' role='alert'><i class='bi bi-exclamation-triangle-fill'></i> O email informado não está no banco de dados do servidor!</div>";
	header("Location: ../index.php");
	exit;
}

mysqli_close($conn);
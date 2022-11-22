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
		header("Location: ../pages/systemadmin.php");
		exit;
		}
		else{
		$_SESSION['msglogin']="<div class='alert alert-danger' role='alert'>A senha informada está incorreta!</div>";
		header("Location: ../index.php");
		exit;
	}
}
else{
	$_SESSION['msglogin']="<div class='alert alert-warning' role='alert'>O email informado não está em nosso banco de dados.</div>";
	header("Location: ../index.php");
	exit;
}

mysqli_close($conn);
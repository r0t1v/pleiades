<?php
session_start();
require __DIR__.'/../config.php';

$a = filter_var($_POST['loginuser'], FILTER_SANITIZE_EMAIL);
$b = md5(filter_var($_POST['loginpass'], FILTER_SANITIZE_STRING));

$c = "SELECT email FROM users WHERE email='$a'";
$d = mysqli_query($conn, $c);
$e= mysqli_num_rows($d);

if($e){
	$f = "SELECT id,nome,social,classe,tag,urlprofile,email,emailverificado,datacriacao FROM users WHERE email='$a' AND senha='$b'";
	$g = mysqli_query($conn, $f);
	$h = mysqli_num_rows($g);

	if ($h) {
        $dados = $g->fetch_assoc();
        $_SESSION['islogged'] = $dados['id'];
		$_SESSION['nomeuser'] = $dados['nome'];
		$_SESSION['socialuser'] = $dados['social'];
		$_SESSION['classeuser'] = $dados['classe'];
		$_SESSION['taguser'] = $dados['tag'];
		$_SESSION['urluser'] = $dados['urlprofile'];
		$_SESSION['emailuser'] = $dados['email'];
		$_SESSION['emailverificadouser'] = $dados['emailverificado'];
		$_SESSION['datacriacaouser'] = $dados['datacriacao'];
		$lastview = date('Y-m-d');
		$aa = "UPDATE users SET ultimovisto='$lastview' WHERE email=''";
		$bb = mysqli_query($conn, $aa);
		
		/* Contagem dos tickets*/
		$i = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['islogged']."' AND ticket_status='Finalizado'";
		$j = mysqli_query($conn, $i);
		$jj = $j->fetch_assoc();
		$_SESSION['tconcluidouser'] = $jj['cont'];

		$k = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['islogged']."' AND ticket_status='Pendente'";
		$l = mysqli_query($conn, $k);
		$ll = $l->fetch_assoc();
		$_SESSION['tpendenteuser'] = $ll['cont'];

		$m = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['islogged']."' AND ticket_status='Rejeitado'";
		$n = mysqli_query($conn, $m);
		$nn = $n->fetch_assoc();
		$_SESSION['trejeitadouser'] = $nn['cont'];

		$o = "SELECT COUNT(protocolo)cont FROM tickets WHERE solicitante='".$_SESSION['islogged']."' AND ticket_status='Cancelado'";
		$p = mysqli_query($conn, $o);
		$pp = $p->fetch_assoc();
		$_SESSION['tcanceladouser'] = $pp['cont'];
		/* Contagem dos tickets*/

		/* Notifications*/
		$q="SELECT descricao,tipo_notification,data_notification FROM notifications WHERE visualizado='0' AND id_conta=".$_SESSION['islogged']." ORDER BY data_notification DESC LIMIT 3";
		$p = mysqli_query($conn, $q);

		/* Notifications*/

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
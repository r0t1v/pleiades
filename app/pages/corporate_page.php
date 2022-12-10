<?php
session_start();
require __DIR__.'/../config.php';
include __DIR__.'/../scripts/verifyauth.php';

$QueryNotifications = "SELECT descricao, tipo_notification FROM notifications WHERE visualizado='0' AND id_conta=".$_SESSION['IsLogged']." ORDER BY data_notification DESC LIMIT 3";
$QueryNotificationsExec = mysqli_query($conn, $QueryNotifications);
$QueryNotificationsRows = mysqli_num_rows($QueryNotificationsExec);

for($i=0; $i<$QueryNotificationsRows; $i++){
    $QueryNotificationsResult = $QueryNotificationsExec->fetch_assoc();
    
    if($QueryNotificationsResult['tipo_notification']==0){
        $SaveNotificationArray[$i]= $QueryNotificationsResult['descricao'];
    }
    else{
        $SaveNotificationArray[$i]= $QueryNotificationsResult['descricao'];
    }
}
$_SESSION['NotificationTop1'] = $SaveNotificationArray[0];
$_SESSION['NotificationTop2'] = $SaveNotificationArray[1];
echo $QueryNotificationsRows;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Corporativo do <?= $_SESSION['SocialUser'].' - '.$servername; ?></title>
        <meta name="description" content="Pagina principal do Pleiades">
        <meta name="keywords" content="HTML, CSS, Javascript, PHP">
        <meta name="author" content="Vitor G. Dantas">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="../assets/base/favicon.png"/>
        <link rel="stylesheet" href="../styles/style.css"/>
        <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css"/>
    </head>
    <body>
        <div class="menusystemuser" align="center">
            <div class="container">
                <div class="row">
                    <div class="col-sm-1">
                        <a href="system.php">
                            <img src="../assets/base/system_logo.png" width="45px" height="45px" alt="logosystem"/>
                        </a>
                    </div>
                    <div class="col-sm-1">
                        <strong><?= $servername; ?></strong>
                    </div>
                    <div class="col-sm-1">
                        <span class="badge rounded-pill text-bg-warning"><?= $releaseversion; ?></span>
                    </div>
                    <a class="col-sm-2" id="menubuttons" href="system.php" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-clipboard-data"></i></span> Meu dashboard
                    </a>
                    <a class="col-sm-2 dropdown-toggle" id="menubuttons" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-ticket-perforated"></i></span> Tickets
                    </a>
                    <ul class="dropdown-menu" id="normaldropdown">
                        <li><a class="dropdown-item" href="create_ticket.php"><i class="bi bi-plus-circle"></i> Abrir Ticket</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-ticket-perforated-fill"></i> Meus Tickets</a></li>
                    </ul>
                    <a class="col-sm-2" id="menubuttons" href="corporate_page.php" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-person-badge"></i></span> Coorporativo
                    </a>
                    <a class="col-sm-1 dropdown-toggle" id="menubuttons" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-bell"></i><?= $_SESSION['ContNotify']; ?></span>
                    </a>
                    <ul class="dropdown-menu" id="notifydropdown">
                        <?php 
                           /* if(isset($_SESSION['NotificationTop1'])){
                                echo '<li><a class="dropdown-item"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['notificationtop1'].'<br><small>Você tem uma nova Notificação!</small></a></li>';
                                if(isset($_SESSION['NotificationTop2'])){
                                    echo '<li><a class="dropdown-item"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['notificationtop2'].'<br><small>Você tem uma nova Notificação!</small></a></li>';
                                    if(isset($_SESSION['NotificationTop3'])){
                                        echo '<li><a class="dropdown-item"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['notificationtop3'].'<br><small>Você tem uma nova Notificação!</small></a></li>';
                                    }
                                }
                                echo '<li><a class="dropdown-item text-center" href="../scripts/cleannotifications.php"><i class="bi bi-check2-square"></i> Limpar notificações</a></li>';
                                echo '<li><hr class="dropdown-divider"></li>';
                                echo '<li><a class="dropdown-item text-center" href="#"><i class="bi bi-plus-square"></i> Ver todas</a></li>';
                            }
                            */
                                echo '<p class="text-center">Você não tem notificações!</p>';

                        ?>
                    </ul>
                    <a class="col-sm-2 dropdown-toggle" id="accbutton" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $_SESSION['SocialUser']?></span><?php if($_SESSION['EmailVerificadoUser']==1){ $msgemail='<span style="color:#2ecc71">Verificado</span>'; echo ' <i class="bi bi-patch-check-fill" id="verifyicon"></i>'; }else{ $msgemail='<span style="color:#e74c3c">Não verificado</span>';}?>
                    </a>
                    <ul class="dropdown-menu" id="accdropdown">
                        <li><i class="bi bi-envelope-at-fill"></i> E-mail:<?= ' '.$msgemail; ?></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="myprofile.php"><i class="bi bi-person-fill"></i> Meu Perfil</a></li>
                        <li><a class="dropdown-item" href="change_password.php"><i class="bi bi-key-fill"></i> Alterar senha</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../scripts/logout.php"><i class="bi bi-door-open"></i> Deslogar</a></li>
                    </ul>
                </div>
            </div>        
        </div>
        <nav class="backdefault">
            <a href="system.php"><i class="bi bi-arrow-left-circle-fill"></i> Voltar</a>
        </nav>
       <?= $_SESSION['NotificationTop1'].'<br>'.$_SESSION['NotificationTop2'].'<br>'.$_SESSION['NotificationTop3'];
       ?>
        <div class="systemsupport" align="center">
            <p><?= $servername.' '.$releaseversion.' - '.date('Y'); ?></p>
        </div>
        <footer align="center">
            <div class="mainfoot">
                <a href="https://github.com/r0t1v/pleiades" target="blank"><i class="bi bi-github"></i></a>
                <a href="https://github.com/r0t1v/pleiades/wiki" target="blank"><i class="bi bi-book"></i></a>  
            </div>
        </footer>
        <script type="text/javascript" src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    </body>
</html>
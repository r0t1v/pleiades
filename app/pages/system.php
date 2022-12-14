<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts/verifyauth.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Sistema<?= ' - '.$SERVER_NAME; ?></title>
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
                        <a href="System.php">
                            <img src="../assets/base/system_logo.png" width="45px" height="45px" alt="logosystem"/>
                        </a>
                    </div>
                    <div class="col-sm-1">
                        <strong><?= $SERVER_NAME; ?></strong>
                    </div>
                    <div class="col-sm-1">
                        <span class="badge rounded-pill text-bg-warning"><?= $SYSTEM_VERSION; ?></span>
                    </div>
                    <a class="col-sm-2" id="menubuttons" href="System.php" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-clipboard-data"></i></span> Meu dashboard
                    </a>
                    <a class="col-sm-2 dropdown-toggle" id="menubuttons" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-ticket-perforated"></i></span> Tickets
                    </a>
                    <ul class="dropdown-menu" id="normaldropdown">
                        <li><a class="dropdown-item" href="Create_ticket.php"><i class="bi bi-plus-circle"></i> Abrir Ticket</a></li>
                        <li><a class="dropdown-item" href="MyTickets.php"><i class="bi bi-ticket-perforated-fill"></i> Meus Tickets</a></li>
                    </ul>
                    <a class="col-sm-2" id="menubuttons" href="Corporate_page.php" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-person-badge"></i></span> Coorporativo
                    </a>
                    <a class="col-sm-1 dropdown-toggle" id="menubuttons" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-bell"></i><?= $_SESSION['DataNotifications']['CountNotifications']; ?></span>
                    </a>
                    <ul class="dropdown-menu" id="notifydropdown">
                        <?php 
                            if($_SESSION['DataNotifications']['CountNotifications']>=1){
                                echo '<div class="notificationsscroll">';
                                for($i=0; $i<$_SESSION['DataNotifications']['CountNotifications']; $i++){

                                    switch ($_SESSION['DataNotifications'][$i][1]) {
                                        case 1:
                                            echo '<li><a class="dropdown-item" href="System.php"><span class="badge rounded-pill text-bg-danger"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['DataNotifications'][$i][0].'<br><small>Voc?? tem um alerta do sistema!</small></a></li>';
                                            break;
                                        case 2:
                                            echo '<li><a class="dropdown-item" href="MyTickets.php"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['DataNotifications'][$i][0].'<br><small>Voc?? tem uma nova notifica????o!</small></a></li>';
                                            break;
                                        case 3:
                                            echo '<li><a class="dropdown-item" href="MyProfile.php"><span class="badge rounded-pill text-bg-info"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['DataNotifications'][$i][0].'<br><small>Nova altera????o efetuada na conta!</small></a></li>';
                                            break;
                                        case 4:
                                            echo '<li><a class="dropdown-item" href="Corporate_page.php"><span class="badge rounded-pill text-bg-success"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['DataNotifications'][$i][0].'<br><small>Nova altera????o efetuada na conta!</small></a></li>';
                                            break;
                                    }
                                }
                                echo '</div>','<hr class="dropdown-divider">','<a class="dropdown-item text-center" href="../scripts/cleanallnotifications.php"><i class="bi bi-ui-checks"></i> Limpar todas as notifica????es</a>';
                            }else{
                                echo '<p class="text-center">Voc?? n??o tem notifica????es!</p>';
                            }
                        ?>
                    </ul>
                    <a class="col-sm-2 dropdown-toggle" id="accbutton" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $_SESSION['DataAccount']['social']?></span><?php if($_SESSION['DataAccount']['emailverificado']==1){ $msgemail='<span style="color:#2ecc71">Verificado</span>'; echo ' <i class="bi bi-patch-check-fill" id="verifyicon"></i>'; }else{ $msgemail='<span style="color:#e74c3c">N??o verificado</span>';}?>
                    </a>
                    <ul class="dropdown-menu" id="accdropdown">
                        <li><i class="bi bi-envelope-at-fill"></i> E-mail:<?= ' '.$msgemail; ?></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="MyProfile.php"><i class="bi bi-person-fill"></i> Meu Perfil</a></li>
                        <li><a class="dropdown-item" href="Change_password.php"><i class="bi bi-key-fill"></i> Alterar senha</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../scripts/logout.php"><i class="bi bi-door-open"></i> Deslogar</a></li>
                    </ul>
                </div>
            </div>        
        </div>
        <section class="dashboardicons">
            <h2><i class="bi bi-file-bar-graph"></i> Meu dashboard</h2>
            <small>Atualizado ??s<?= ' '.date('H:i:s'); ?></small>
            <div class="container text-center">
                <div class="row">
                    <a class="col" href="#">
                        <img src="../assets/tickets_ok.png" alt="ticketsok"/>
                        <br>
                        <strong><?= '0'; ?></strong>
                        <h5>Tickets Conclu??dos</h5>
                    </a>
                    <a class="col" href="#">
                    <img src="../assets/tickets_pending.png" alt="ticketspending"/>
                        <br>
                        <strong><?= '0'; ?></strong>
                        <h5>Tickets Pendentes</h5>
                    </a>
                    <a class="col" href="#">
                    <img src="../assets/tickets_rejected.png" alt="tickets_rejected"/>
                        <br>
                        <strong><?= '0'; ?></strong>
                        <h5>Tickets Rejeitados</h5>
                    </a>
                    <a class="col" href="#">
                    <img src="../assets/tickets_exited.png" alt="tickets_exited"/>
                        <br>
                        <strong><?= '0'; ?></strong>
                        <h5>Tickets Cancelados</h5>
                    </a>
                </div>
            </div>
        </section>
        <aside class="buttonsinteract" align="center">
            <h2><i class="bi bi-info-circle-fill"></i> Precisa de ajuda?</h2>
            <a class="btn btn-info" href="Create_ticket.php" role="button"><i class="bi bi-plus-circle-dotted"></i> Abrir Ticket</a>
            <a class="btn btn-outline-primary" href="#" role="button"><i class="bi bi-search"></i> Procurar Tickets</a>
        </aside>
        <article class="userview" align="center">
            <h1><i class="bi bi-person-lines-fill"></i> Informa????es da Conta</h1>
            <div class="card">
                <h5 class="card-header">Conta de Usu??rio (Padr??o)</h5>
                <div class="card-body">
                <img src="../assets/cracha_default.png" alt="crachadefault"/>
                    <ul align="left">
                        <li><i class="bi bi-person"></i> Nome:<?= ' '.$_SESSION['DataAccount']['nome']; ?></li>
                        <li><i class="bi bi-person-bounding-box"></i> Usu??rio:<?= ' '.$_SESSION['DataAccount']['social']; ?></li>
                        <li><i class="bi bi-tag-fill"></i> Tag:<?= ' '.$_SESSION['DataAccount']['tag']; ?></li>
                        <li><i class="bi bi-mailbox"></i> Email:<?= ' '.$_SESSION['DataAccount']['email']; ?></li>
                    </ul>
                </div>
                <p><a href="<?= 'http://'.$_SESSION['DataAccount']['urlprofile']; ?>" target="blank"><i class="bi bi-linkedin"></i></a></p>
                <div class="card-footer">
                    <i class="bi bi-calendar2-check"></i> Conta criada em<?php $dataformatada = new DateTime($_SESSION['DataAccount']['datacriacao']); echo ' '.$dataformatada->format('d/m/Y') ?>
                </div>
            </div>
        </article>
        <div class="systemsupport" align="center">
            <p><?= $SERVER_NAME.' '.$SYSTEM_VERSION.' - '.date('Y'); ?></p>
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
<?php
session_start();
require __DIR__.'/../config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title><?= $servername; ?> - Sistema</title>
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
                        <a href="/pleiades/pages/system.php">
                            <img src="../assets/base/system_logo.png" width="45px" height="45px" alt="logosystem"/>
                        </a>
                    </div>
                    <div class="col-sm-1">
                        <strong><?= $servername; ?></strong>
                    </div>
                    <div class="col-sm-1">
                        <span class="badge rounded-pill text-bg-warning"><?= $releaseversion; ?></span>
                    </div>
                    <a class="col-sm-2" id="menubuttons" href="/pleiades/pages/system.php" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-clipboard-data"></i></span> Minha Dashboard
                    </a>
                    <a class="col-sm-2 dropdown-toggle" id="menubuttons" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-ticket-perforated"></i></span> Meus Tickets
                    </a>
                    <ul class="dropdown-menu" id="ticketdropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-plus-circle"></i> Abrir Ticket</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-clock-history"></i> Pendentes</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-check-circle"></i> Finalizados</a></li>
                    </ul>
                    <a class="col-sm-2" id="menubuttons" href="/pleiades/pages/system.php" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-person-bounding-box"></i></span> Coorporativo
                    </a>
                    <a class="col-sm-2 dropdown-toggle" id="accbutton" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $_SESSION['socialuser']?></span><?php if($_SESSION['emailverificadouser']==1){ echo ' <i class="bi bi-patch-check-fill" id="verifyicon"></i>'; }?>
                    </a>
                    <ul class="dropdown-menu" id="accdropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill"></i> Meu Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-key-fill"></i> Alterar senha</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../scripts/logout.php"><i class="bi bi-door-open"></i> Deslogar</a></li>
                    </ul>
                </div>
            </div>        
        </div>
        <section class="dashboardicons">
            <h2><i class="bi bi-file-bar-graph"></i> Minha Dashboard</h2>
            <div class="container text-center">
                <div class="row">
                    <a class="col" href="#">
                        <img src="../assets/tickets_ok.png" alt="ticketsok"/>
                        <br>
                        <strong>10</strong>
                        <h5>Tickets Concluídos</h5>
                        <small>Atualizado ás 20:11</small>
                    </a>
                    <a class="col" href="#">
                    <img src="../assets/tickets_pending.png" alt="ticketspending"/>
                        <br>
                        <strong>2</strong>
                        <h5>Tickets Concluídos</h5>
                        <small>Atualizado ás 20:11</small>
                    </a>
                    <a class="col" href="#">
                    <img src="../assets/tickets_rejected.png" alt="tickets_rejected"/>
                        <br>
                        <strong>0</strong>
                        <h5>Tickets Rejeitados</h5>
                        <small>Atualizado ás 20:11</small>
                    </a>
                    <a class="col" href="#">
                    <img src="../assets/tickets_exited.png" alt="tickets_exited"/>
                        <br>
                        <strong>21</strong>
                        <h5>Tickets Cancelados</h5>
                        <small>Atualizado ás 20:11</small>
                    </a>
                </div>
            </div>
        </section>
        <footer align="center">
            <div class="mainfoot">
                <a href="https://github.com/r0t1v/pleiades" target="blank"><i class="bi bi-github"></i></a>
                <a href="https://github.com/r0t1v/pleiades/wiki" target="blank"><i class="bi bi-book"></i></a>  
            </div>
        </footer>
        <script type="text/javascript" src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    </body>
</html>
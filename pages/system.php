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
        <link rel="stylesheet" href="../styles/components.css"/>
        <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css"/>
    </head>
    <body>
        <div class="menusystemuser" align="center">
            <img src="../assets/base/system_logo.png" alt="logosystem"/>
            <p><?= $servername.' <span class="badge rounded-pill text-bg-warning">'.$releaseversion.'</span>'; ?></p>
            <hr>
            <ul>
                <li>
                    <a class="btn btn-secondary" href="/pleiades/pages/system.php" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-clipboard-data"></i>
                        </span> Minha Dashboard
                    </a>
                </li>
                <li>
                    <a class="btn btn-secondary" href="#mytickets" role="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-ticket-perforated"></i>
                        </span> Meus Tickets
                    </a>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#mytickets">
                        <div class="accordion-body">
                            <ul>
                                <li id="menuaddtickt">
                                    <a class="btn btn-secondary"  href="/" role="button"><i class="bi bi-plus-circle"></i> Criar Ticket</a>
                                </li>
                                <li>
                                    <a class="btn btn-secondary" href="/" role="button"><i class="bi bi-clock-history"></i> Pendentes</a>
                                </li>
                                <li>
                                    <a class="btn btn-secondary" href="/" role="button"><i class="bi bi-check-circle"></i> Finalizados</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <a class="btn btn-secondary" href="" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-people"></i>
                        </span> Corporativo
                    </a>
                </li>
                <li>
                    <a class="btn btn-secondary" href="https://github.com/r0t1v/pleiades/wiki" target="blank" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-book"></i>
                        </span> Wiki
                    </a>
                </li>
                <li>
                    <a class="btn btn-secondary" href="https://github.com/r0t1v/pleiades" target="blank" role="button">
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-github"></i>
                        </span> Sobre
                    </a>
                </li>
            </ul>
        </div>
        <nav class="menuperfil">
            perfil
        </nav>
        <a href="../scripts/logout.php">Sair</a>
        <footer align="center">

        </footer>
        <script type="text/javascript" src="../vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
    </body>
</html>
<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts\verifyauth.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Corporativo do <?= $_SESSION['SocialUser'].' - '.$SERVER_NAME; ?></title>
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
                        <strong><?= $SERVER_NAME; ?></strong>
                    </div>
                    <div class="col-sm-1">
                        <span class="badge rounded-pill text-bg-warning"><?= $SYSTEM_VERSION; ?></span>
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
                            if(isset($_SESSION['NotificationTop1'])){
                                echo $_SESSION['NotificationTop1'];
                                if(isset($_SESSION['NotificationTop2'])){
                                    echo $_SESSION['NotificationTop2'];                                    
                                    if(isset($_SESSION['NotificationTop3'])){
                                        echo $_SESSION['NotificationTop3'];
                                    }
                                }
                                echo '<li><a class="dropdown-item text-center" href="../scripts/cleantopnotifications.php"><i class="bi bi-check2-square"></i> Limpar notificações</a></li>';
                            }
                            else{
                                echo '<p class="text-center">Você não tem notificações!</p>';
                            }
                            echo '<li><hr class="dropdown-divider"></li>','<li><a class="dropdown-item text-center" href="mynotifications.php"><i class="bi bi-plus-square"></i> Ver todas</a></li>';
                        ?>
                    </ul>
                    <a class="col-sm-2 dropdown-toggle" id="accbutton" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $_SESSION['SocialUser']; ?></span><?php if($_SESSION['EmailVerificadoUser']==1){ $msgemail='<span style="color:#2ecc71">Verificado</span>'; echo ' <i class="bi bi-patch-check-fill" id="verifyicon"></i>'; }else{ $msgemail='<span style="color:#e74c3c">Não verificado</span>';}?>
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
        <section class="cardstool">
            <h1><i class="bi bi-tools"></i> Minhas ferramentas</h1>
            <div class="container">
                <div class="row">
                    <div class="col">
                    <?php
                    if(isset($_SESSION['UserAnyDeskID'])){
                        echo'<div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Client Anydesk</h5>
                            <h6 class="card-subtitle mb-2 text-muted">'.$_SESSION['SocialUser'].'</h6>
                            <form class="form-cards">
                                <label for="useranydeskid" class="form-label">ID</label>
                                <input type="text" class="form-control" id="useranydeskid" name="useranydeskid" placeholder="800 800 800">
                                <label for="useranydeskpass" class="form-label">Senha</label>
                                <input type="text" class="form-control" id="useranydeskpass" name="useranydeskpass" placeholder="dasKyal">
                                <a href="#" class="card-link btn btn-primary">Atualizar</a>
                                <a href="#" class="card-link btn btn-outline-danger">Limpar</a>
                                </form>
                            </div>
                        </div>';
                    }
                    else{
                        echo'<div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Client Anydesk</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalanydesk">
                                <i class="bi bi-folder-plus"></i> Registrar
                            </button>
                            </div>
                        </div>
                        <div class="modal fade" id="modalanydesk" tabindex="-1" aria-labelledby="modalanydesk" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title fs-5">Registar AnyDesk</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-cards">
                                        <label for="useranydeskid" class="form-label">ID</label>
                                        <input type="text" class="form-control" id="useranydeskid" name="useranydeskid" placeholder="800 800 800">
                                        <label for="useranydeskpass" class="form-label">Senha</label>
                                        <input type="text" class="form-control" id="useranydeskpass" name="useranydeskpass" placeholder="dasKyal">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="#" class="card-link btn btn-primary">Salvar</a>
                                </div>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>
                    </div>
                    <div class="col">
                        <div class="card">
                                <div class="card-body">
                                <h5 class="card-title">Client Team Viewer</h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= $_SESSION['SocialUser']; ?></h6>
                                <form class="form-cards">
                                    <label for="useranydeskid" class="form-label">ID</label>
                                    <input type="text" class="form-control" id="useranydeskid" name="useranydeskid" placeholder="800 800 800">
                                    <label for="useranydeskpass" class="form-label">Senha</label>
                                    <input type="text" class="form-control" id="useranydeskpass" name="useranydeskpass" placeholder="dasKyal">
                                    <a href="#" class="card-link btn btn-primary">Atualizar</a>
                                    <a href="#" class="card-link btn btn-outline-danger">Limpar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Client RealVNC</h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= $_SESSION['SocialUser']; ?></h6>
                                <form class="form-cards">
                                    <label for="useranydeskid" class="form-label">ID</label>
                                    <input type="text" class="form-control" id="useranydeskid" name="useranydeskid" placeholder="800 800 800">
                                    <label for="useranydeskpass" class="form-label">Senha</label>
                                    <input type="text" class="form-control" id="useranydeskpass" name="useranydeskpass" placeholder="dasKyal">
                                    <a href="#" class="card-link btn btn-primary">Atualizar</a>
                                    <a href="#" class="card-link btn btn-outline-danger">Limpar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Network settings</h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= $_SESSION['SocialUser']; ?></h6>
                                <form class="form-cards">
                                    <label for="useranydeskid" class="form-label">Nome da máquina</label>
                                    <input type="text" class="form-control" id="useranydeskid" name="useranydeskid" placeholder="800 800 800">
                                    <label for="useranydeskpass" class="form-label">Endereço IP</label>
                                    <input type="text" class="form-control" id="useranydeskpass" name="useranydeskpass" placeholder="dasKyal">
                                    <a href="#" class="card-link btn btn-primary">Atualizar</a>
                                    <a href="#" class="card-link btn btn-outline-danger">Limpar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
        </section>
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
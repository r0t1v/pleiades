<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts\verifyauth.php';

/* Format Tools*/
for($a=0; $a<$_SESSION['UserTools']['CountTools']; $a++){

    switch ($_SESSION['UserTools'][$a][2]) {
        case 1:
            $UserAnyDeskID = $_SESSION['UserTools'][$a][0];
            $UserAnyDeskPass = $_SESSION['UserTools'][$a][1];
            break;
        case 2:
            $UserTeamViewerID = $_SESSION['UserTools'][$a][0];
            $UserTeamViewerPass = $_SESSION['UserTools'][$a][1];
            break;
        case 3:
            $UserRealVncID = $_SESSION['UserTools'][$a][0];
            $UserRealVncPass = $_SESSION['UserTools'][$a][1];
            break;
        case 4:
            $UserPcName = $_SESSION['UserTools'][$a][0];
            $UserIP = $_SESSION['UserTools'][$a][1];
            break;
    }
}
/* Format Tools*/

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Corporativo do <?= $_SESSION['DataAccount']['social'].' - '.$SERVER_NAME; ?></title>
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
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-bell"></i><?= $_SESSION['DataNotifications']['CountNotifications']; ?></span>
                    </a>
                    <ul class="dropdown-menu" id="notifydropdown">
                        <?php 
                            if($_SESSION['DataNotifications']['CountNotifications']>=1){
                                for($i=0; $i<$_SESSION['DataNotifications']['CountNotifications']; $i++){

                                    switch ($_SESSION['DataNotifications'][$i][1]) {
                                        case 1:
                                            echo '<li><a class="dropdown-item" href="system.php"><span class="badge rounded-pill text-bg-danger"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['DataNotifications'][$i][0].'<br><small>Você tem um alerta do sistema!</small></a></li>';
                                            break;
                                        case 2:
                                            echo '<li><a class="dropdown-item" href="mytickets.php"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['DataNotifications'][$i][0].'<br><small>Você tem uma nova notificação!</small></a></li>';
                                            break;
                                        case 3:
                                            echo '<li><a class="dropdown-item" href="myprofile.php"><span class="badge rounded-pill text-bg-info"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['DataNotifications'][$i][0].'<br><small>Nova alteração efetuada na conta!</small></a></li>';
                                            break;
                                        case 4:
                                            echo '<li><a class="dropdown-item" href="corporate_page.php"><span class="badge rounded-pill text-bg-success"><i class="bi bi-bell-fill"></i> Novo</span> '.$_SESSION['DataNotifications'][$i][0].'<br><small>Nova alteração efetuada na conta!</small></a></li>';
                                            break;
                                    }
                                }
                                echo '<li><hr class="dropdown-divider"></li>','<li><a class="dropdown-item text-center" href="../scripts/cleanallnotifications.php"><i class="bi bi-ui-checks"></i> Limpar todas as notificações</a></li>';
                            }else{
                                echo '<p class="text-center">Você não tem notificações!</p>';
                            }
                        ?>
                    </ul>
                    <a class="col-sm-2 dropdown-toggle" id="accbutton" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $_SESSION['DataAccount']['social']?></span><?php if($_SESSION['DataAccount']['emailverificado']==1){ $msgemail='<span style="color:#2ecc71">Verificado</span>'; echo ' <i class="bi bi-patch-check-fill" id="verifyicon"></i>'; }else{ $msgemail='<span style="color:#e74c3c">Não verificado</span>';}?>
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
            <?php
                if(isset($_SESSION['MsgCorpPage'])){
                    echo $_SESSION['MsgCorpPage'];
                    unset($_SESSION['MsgCorpPage']);
                }
                else{
                    unset($_SESSION['MsgCorpPage']);
                }
            ?>
            <h1><i class="bi bi-tools"></i> Minhas ferramentas</h1>
            <div class="container">
                <div class="row" align="center">
                    <div class="col">
                        <?php
                        if(isset($UserAnyDeskID)){
                            echo'<div class="card">
                                    <div class="card-body">
                                        <img src="../assets/anydesk_user.png" alt="anydesklogo"/>
                                        <h5 class="card-title">Client Anydesk</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'.$_SESSION['DataAccount']['social'].'</h6>
                                        <form action="../scripts/mytoolsquerys/uploadanydesk.php" method="POST" class="form-cards">
                                            <label for="useranydeskid" class="form-label">ID</label>
                                            <input type="text" class="form-control" id="useranydeskid" name="useranydeskid" minlength="9" maxlength="12" value='.$UserAnyDeskID.' required/>
                                            <label for="useranydeskpass" class="form-label">Senha</label>
                                            <input type="text" class="form-control" id="useranydeskpass" name="useranydeskpass" minlength="8" maxlength="32" value='.$UserAnyDeskPass.' required/>
                                            <button type="submit" class="card-link btn btn-primary">Atualizar</button>
                                            <a href="../scripts/mytoolsquerys/cleananydesk.php" class="card-link btn btn-outline-danger">Limpar</a>
                                        </form>
                                    </div>
                                </div>';
                        }
                        else{
                            echo'<div class="card" align="center">
                                    <div class="card-body">
                                        <img src="../assets/anydesk_user.png" alt="anydesklogo"/>
                                        <h5 class="card-title">Client Anydesk</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalanydesk">
                                            <i class="bi bi-folder-plus"></i> Registrar
                                        </button>
                                        </div>
                                    </div>
                                <div class="modal fade" id="modalanydesk" tabindex="-1" aria-labelledby="modalanydesk" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" align="left">
                                            <div class="modal-header">
                                                <h2 class="modal-title fs-5">Registar AnyDesk</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../scripts/mytoolsquerys/uploadanydesk.php" method="POST" class="form-cards">
                                                    <label for="useranydeskid" class="form-label">ID</label>
                                                    <input type="text" class="form-control" id="useranydeskid" name="useranydeskid" placeholder="Id Anydesk" minlength="9" maxlength="12" required/>
                                                    <label for="useranydeskpass" class="form-label">Senha</label>
                                                    <input type="text" class="form-control" id="useranydeskpass" name="useranydeskpass" placeholder="Senha" minlength="8" maxlength="32" required/>
                                                    <div class="d-grid gap-2 col-6 mx-auto">
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>
                    <div class="col">
                        <?php
                        if(isset($UserTeamViewerID)){
                            echo'<div class="card">
                                    <div class="card-body">
                                        <img src="../assets/teamw_user.png" alt="teamviewerlogo"/>
                                        <h5 class="card-title">Client Team Viewer</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'.$_SESSION['DataAccount']['social'].'</h6>
                                        <form action="../scripts/mytoolsquerys/uploadteamw.php" method="POST" class="form-cards">
                                            <label for="userteamwid" class="form-label">ID</label>
                                            <input type="text" class="form-control" id="userteamwid" name="userteamwid" minlength="9" maxlength="12" value='.$UserTeamViewerID.' required/>
                                            <label for="userteamwpass" class="form-label">Senha</label>
                                            <input type="text" class="form-control" id="userteamwpass" name="userteamwpass" minlength="8" maxlength="32" value='.$UserTeamViewerPass.' required/>
                                            <button type="submit" class="card-link btn btn-primary">Atualizar</button>
                                            <a href="../scripts/mytoolsquerys/cleanteamw.php" class="card-link btn btn-outline-danger">Limpar</a>
                                        </form>
                                     </div>
                                </div>';
                        }
                        else{
                            echo'<div class="card" align="center">
                                    <div class="card-body">
                                        <img src="../assets/teamw_user.png" alt="teamviewerlogo"/>
                                        <h5 class="card-title">Client Team Viewer</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalteamviewer">
                                            <i class="bi bi-folder-plus"></i> Registrar
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalteamviewer" tabindex="-1" aria-labelledby="modalteamviewer" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" align="left">
                                            <div class="modal-header">
                                                <h2 class="modal-title fs-5">Registar Team Viewer</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../scripts/mytoolsquerys/uploadteamw.php" method="POST" class="form-cards">
                                                    <label for="userteamwid" class="form-label">ID</label>
                                                    <input type="text" class="form-control" id="userteamwid" name="userteamwid" placeholder="Id Team Viewer">
                                                    <label for="userteamwpass" class="form-label">Senha</label>
                                                    <input type="text" class="form-control" id="userteamwpass" name="userteamwpass" placeholder="Senha">
                                                    <div class="d-grid gap-2 col-6 mx-auto">
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>
                    <div class="col">
                        <?php
                        if(isset($UserRealVncID)){
                            echo'<div class="card">
                                    <div class="card-body">
                                        <img src="../assets/realvnc_user.png" alt="realvnclogo"/>
                                        <h5 class="card-title">Client RealVNC</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'.$_SESSION['DataAccount']['social'].'</h6>
                                        <form action="../scripts/mytoolsquerys/uploadrealvnc.php" method="POST" class="form-cards">
                                            <label for="userrealvncid" class="form-label">ID</label>
                                            <input type="text" class="form-control" id="userrealvncid" name="userrealvncid" minlength="9" maxlength="12" value='.$UserRealVncID.' required/>
                                            <label for="userrealvncpass" class="form-label">Senha</label>
                                            <input type="text" class="form-control" id="userrealvncpass" name="userrealvncpass" minlength="8" maxlength="32" value='.$UserRealVncPass.' required/>
                                            <button type="submit" class="card-link btn btn-primary">Atualizar</button>
                                            <a href="../scripts/mytoolsquerys/cleanrealvnc.php" class="card-link btn btn-outline-danger">Limpar</a>
                                        </form>
                                    </div>
                                </div>';
                        }
                        else{
                            echo'<div class="card" align="center">
                                    <div class="card-body">
                                        <img src="../assets/realvnc_user.png" alt="realvnclogo"/>
                                        <h5 class="card-title">Client RealVNC</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalrealvnc">
                                            <i class="bi bi-folder-plus"></i> Registrar
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalrealvnc" tabindex="-1" aria-labelledby="modalrealvnc" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" align="left">
                                            <div class="modal-header">
                                                <h2 class="modal-title fs-5">Registar RealVNC</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../scripts/mytoolsquerys/uploadrealvnc.php" method="POST" class="form-cards">
                                                <label for="userrealvncid" class="form-label">ID</label>
                                                <input type="text" class="form-control" id="userrealvncid" name="userrealvncid" placeholder="Id do RealVNC">
                                                <label for="userrealvncpass" class="form-label">Senha</label>
                                                <input type="text" class="form-control" id="userrealvncpass" name="userrealvncpass" placeholder="Senha">
                                                <div class="d-grid gap-2 col-6 mx-auto">
                                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="row" align="center">
                    <div class="col">
                        <?php
                        if(isset($UserPcName)){
                            echo'<div class="card">
                                    <div class="card-body" align="center">
                                        <img src="../assets/network_user.png" alt="networklogo"/>
                                        <h5 class="card-title">Configurações de rede</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'.$_SESSION['DataAccount']['social'].'</h6>
                                        <form action="../scripts/mytoolsquerys/uploadnetcfg.php" method="POST" class="form-cards">
                                            <label for="userpcname" class="form-label">ID</label>
                                            <input type="text" class="form-control" id="userpcname" name="userpcname" minlength="9" maxlength="12" value='.$UserPcName.' required/>
                                            <label for="userpcip" class="form-label">Senha</label>
                                            <input type="text" class="form-control" id="userpcip" name="userpcip" minlength="8" maxlength="32" value='.$UserIP.' required/>
                                            <button type="submit" class="card-link btn btn-primary">Atualizar</button>
                                            <a href="../scripts/mytoolsquerys/cleannetcfg.php" class="card-link btn btn-outline-danger">Limpar</a>
                                        </form>
                                    </div>
                                </div>';
                        }
                        else{
                            echo'<div class="card" align="center">
                                    <div class="card-body">
                                        <img src="../assets/network_user.png" alt="networklogo"/>
                                        <h5 class="card-title">Configurações de rede</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalnetworkuser">
                                            <i class="bi bi-folder-plus"></i> Registrar
                                        </button>
                                        </div>
                                    </div>
                                <div class="modal fade" id="modalnetworkuser" tabindex="-1" aria-labelledby="modalnetworkuser" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" align="left">
                                            <div class="modal-header">
                                                <h2 class="modal-title fs-5">Registrar configurações de rede</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../scripts/mytoolsquerys/uploadnetcfg.php" method="POST" class="form-cards">
                                                    <label for="userpcname" class="form-label">Nome da máquina</label>
                                                    <input type="text" class="form-control" id="userpcname" name="userpcname" placeholder="Nome do computador">
                                                    <label for="userpcip" class="form-label">Endereço IP</label>
                                                    <input type="text" class="form-control" id="userpcip" name="userpcip" placeholder="Ipv4">
                                                    <div class="d-grid gap-2 col-6 mx-auto">
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                        ?>
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
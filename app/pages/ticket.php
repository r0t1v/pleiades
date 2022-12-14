<?php
session_start();
require __DIR__.'\..\config.php';
include __DIR__.'\..\scripts/verifyauth.php';
$TicketInfoQuery = "SELECT protocolo,tickethash,designacao,nometicket,sla,ticketstatus,datapedido,datasla,datafinalizado,avaliation FROM tickets WHERE solicitante='".$_SESSION['DataAccount']['id']."' AND protocolo='".'230107.1120112'."'";
$TicketInfoExec = mysqli_query($CONNECTION_DB, $TicketInfoQuery);
$_SESSION['DataTicketSelected'] = mysqli_fetch_assoc($TicketInfoExec);

$TicketChatQuery = "SELECT id,msgcontent,isfile,enviadapor,datamsg FROM chat WHERE ticketprotocolo='".$_SESSION['DataTicketSelected']['protocolo']."' ORDER BY datamsg ASC";
$TicketChatExec = mysqli_query($CONNECTION_DB, $TicketChatQuery);
for($j=0; $j<mysqli_num_rows($TicketChatExec); $j++){
    $DataTools = mysqli_fetch_assoc($TicketChatExec);
    $_SESSION['DataTicketChatSelected'][$j][] = $DataTools['msgcontent'];
    $_SESSION['DataTicketChatSelected'][$j][] = $DataTools['isfile'];
    $_SESSION['DataTicketChatSelected'][$j][] = $DataTools['enviadapor'];
    $_SESSION['DataTicketChatSelected'][$j][] = $DataTools['datamsg'];
}
$_SESSION['DataTicketChatSelected']['CountMsgs'] = mysqli_num_rows($TicketChatExec);

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Ticket<?= ' - '.$SERVER_NAME; ?></title>
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
        <nav class="backdefault">
            <a href="System.php"><i class="bi bi-arrow-left-circle-fill"></i> Voltar</a>
        </nav>
        <section class="ticketcontent">
            <?php
                if(isset($_SESSION['Msg'])){
                    echo $_SESSION['Msg'];
                    unset($_SESSION['Msg']);
                }
                else{
                    unset($_SESSION['Msg']);
                }
            ?>
            <h3><i class="bi bi-ticket-fill"></i><?= ' '.$_SESSION['DataTicketSelected']['nometicket']; ?></h3>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="ticketlabel"><i class="bi bi-ticket"></i> Ticket N??</span>
                            <input type="text" class="form-control" id="formviewticket" value="<?= $_SESSION['DataTicketSelected']['protocolo']; ?>" aria-describedby="ticketlabel" disabled readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="tickethashlabel"><i class="bi bi-hash"></i> Ticket hash</span>
                            <input type="text" class="form-control" id="formviewticket" value="<?= $_SESSION['DataTicketSelected']['tickethash']; ?>" aria-describedby="tickethashlabel" disabled readonly/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="ticketdesign"><i class="bi bi-cursor"></i> Setor de interesse</span>
                            <input type="text" class="form-control" id="formviewticket" value="<?= $_SESSION['DataTicketSelected']['designacao']; ?>" aria-describedby="ticketdesign" disabled readonly/>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="ticketsla"><i class="bi bi-stopwatch-fill"></i> SLA</span>
                            <input type="text" class="form-control" id="formviewticket" value="<?= $_SESSION['DataTicketSelected']['sla'].'hrs'; ?>" aria-describedby="ticketsla" disabled readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="ticketdateinit"><i class="bi bi-calendar"></i> Data de cria????o</span>
                            <input type="text" class="form-control" id="formviewticket" value="<?php $DataTicketFormatada = new DateTime($_SESSION['DataTicketSelected']['datapedido']); echo $DataTicketFormatada->format('d/m/Y').' ??s '.$DataTicketFormatada->format('H:i:s'); ?>" aria-describedby="ticketdateinit" disabled readonly/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="ticketstatus"><i class="bi bi-stopwatch-fill"></i> Situa????o</span>
                            <input type="text" class="form-control" id="formviewticket" value="<?= 'Ticket '.$_SESSION['DataTicketSelected']['ticketstatus']; ?>" aria-describedby="ticketstatus" disabled readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="ticketdatasla"><i class="bi bi-hourglass-split"></i> Data combinada</span>
                            <input type="text" class="form-control" id="formviewticket" value="<?php $DataTicketFormatadaSla = new DateTime($_SESSION['DataTicketSelected']['datasla']); echo $DataTicketFormatadaSla->format('d/m/Y').' ??s '.$DataTicketFormatadaSla->format('H:i:s'); ?>" aria-describedby="ticketdatasla" disabled readonly/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="newticketmsg" class="form-label"><i class="bi bi-chat-square-text"></i> Bate-papo</label>
                        <div class="chatticket">
                            <div class="container">
                            <?php 
                                for($a=0; $a<$_SESSION['DataTicketChatSelected']['CountMsgs']; $a++){

                                    if($_SESSION['DataTicketChatSelected'][$a][2]==$_SESSION['DataAccount']['id']) {
                                        $DataTicketFormatadaSla = new DateTime($_SESSION['DataTicketChatSelected'][$a][3]);
                                        echo'<div class="row" align="left">
                                                <div class="col">
                                                    <div class="card" id="dialoguser">
                                                        <div class="card-header">
                                                            <strong>'.$_SESSION['DataAccount']['social'].'</strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <p>'.$_SESSION['DataTicketChatSelected'][$a][0].'</p>
                                                            <footer><i class="bi bi-clock"></i>
                                                                '.$DataTicketFormatadaSla->format('d/m/Y').' ??s '.$DataTicketFormatadaSla->format('H:i:s').'
                                                            </footer>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                    }else{
                                        $DataTicketFormatadaSla = new DateTime($_SESSION['DataTicketChatSelected'][$a][3]);
                                        echo'<div class="row" align="right">
                                        <div class="col">
                                            <div class="card" id="dialogpleiade" align="left">>
                                                <div class="card-header">
                                                    <strong>'.$_SESSION['DataAccount']['social'].'</strong>
                                                </div>
                                                <div class="card-body">
                                                    <p>'.$_SESSION['DataTicketChatSelected'][$a][0].'</p>
                                                    <footer><i class="bi bi-clock"></i>
                                                        '.$DataTicketFormatadaSla->format('d/m/Y').' ??s '.$DataTicketFormatadaSla->format('H:i:s').'
                                                    </footer>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                            ?>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Digite sua mensagem aqui" aria-describedby="submitmsg">
                            <label for="submitmsg"><strong class="btn btn-outline-secondary"><i class="bi bi-paperclip"></i></strong></label>
                            <input type="file" id="submitmsg"/>
                            <button class="btn btn-primary" type="submit" id="submitmsg"><i class="bi bi-send"></i> Enviar</button>
                        </div>
                    </div>
                </div>
                <div class="row" align="center">
                    <div class="col">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <a class="btn btn-outline-danger" href="#" role="button"><i class="bi bi-x-square"></i> Cancelar Ticket</a>
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
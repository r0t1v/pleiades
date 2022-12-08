<?php
session_start();
require __DIR__.'/../config.php';
include __DIR__.'/../scripts/verifyauth.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Perfil do <?= $_SESSION['SocialUser'].' - '.$servername; ?></title>
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
                        <span class="badge rounded-pill text-bg-light"><i class="bi bi-bell"></i>+1</span>
                    </a>
                    <ul class="dropdown-menu" id="notifydropdown">
                        <li><a class="dropdown-item"><span class="badge rounded-pill text-bg-warning"><i class="bi bi-bell-fill"></i> Novo</span> Ticket #111<br><small>Você tem uma nova resposta.</small></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="#"><i class="bi bi-plus-square"></i> Ver todas</a></li>
                    </ul>
                    <a class="col-sm-2 dropdown-toggle" id="accbutton" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $_SESSION['SocialUser']?></span><?php if($_SESSION['EmailVerificadoUser']==1){ $msgemail='<span style="color:#2ecc71">Verificado</span>'; echo ' <i class="bi bi-patch-check-fill" id="verifyicon"></i>'; }else{ $msgemail='<span style="color:#e74c3c">Não verificado</span>';}?>
                    </a>
                    <ul class="dropdown-menu" id="accdropdown">
                        <li><i class="bi bi-envelope-at-fill"></i> E-mail:<?= ' '.$msgemail; ?></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item disabled" href="#"><i class="bi bi-person-fill"></i> Meu Perfil</a></li>
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
        <section class="profileinfo">
            <?php
                if(isset($_SESSION['MsgUpdateProfile'])){
                    echo $_SESSION['MsgUpdateProfile'];
                    unset($_SESSION['MsgUpdateProfile']);
                }
                else{
                    unset($_SESSION['MsgUpdateProfile']);
                }
            ?>
            <h1><i class="bi bi-person-square"></i> Informações do Perfil</h1>
            <form action="../scripts/updateprofile.php" method="POST" class="formprofile">
                <label for="profileusername" class="form-label">Nome</label>
                <input class="form-control form-control-lg" type="text" id="profileusername" name="profileusername" placeholder="Nome" minlength="3" maxlength="100" value="<?= $_SESSION['NomeUser']; ?>" required />
                <label for="profileusersocial" class="form-label">Nome de usuário</label>
                <input class="form-control form-control-lg" type="text" id="profileusersocial" name="profileusersocial" placeholder="Nome de usuário" minlength="4" maxlength="50" value="<?= $_SESSION['SocialUser']; ?>" required />
                <label for="form-control" class="form-label">Tag</label>
                <input class="form-control form-control-lg" type="text" placeholder="Tag" id="form-control" name="form-control" value="<?= $_SESSION['TagUser']; ?>" disabled />
                <label for="profileuseremail" class="form-label">E-mail</label>
                <input class="form-control form-control-lg" type="text" id="profileuseremail" name="profileuseremail" placeholder="E-mail" minlength="5" maxlength="100" value="<?= $_SESSION['EmailUser']; ?>" required />
                <label for="profileuserurl" class="form-label">Url do seu perfil profissional</label>
                <input class="form-control form-control-lg" type="text" id="profileuserurl" name="profileuserurl" placeholder="Url" minlength="5" maxlength="100" value="<?= $_SESSION['UrlUser']; ?>" required />              
                <button type="submit" class="btn btn-success"><i class="bi bi-pencil-square"></i> Editar</button>
            </form>
        </section>
        <aside class="emailcheck" align="center">
            <?php
            if($_SESSION['EmailVerificadoUser']==0){
                echo'<a href="" style="color: #e67e22;"><i class="bi bi-shield-x"></i> Verificar e-mail</a>';
            }
            else{
                echo'<p style="color: #2ecc71;"><i class="bi bi-check2-circle"></i> Seu e-mail já foi verificado!</p>';
            }
            ?>
        </aside>
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
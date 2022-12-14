<?php 
session_start();
require __DIR__ .'./config.php';
include __DIR__.'./scripts/verifylogged.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title><?= $SERVER_NAME; ?> - Login</title>
        <meta name="description" content="Pagina principal do Pleiades">
        <meta name="keywords" content="HTML, CSS, Javascript, PHP">
        <meta name="author" content="Vitor G. Dantas">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="assets/base/favicon.png"/>
        <link rel="stylesheet" href="styles/style.css"/>
        <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css"/>
    </head>
    <body>
        <nav class="mainmenu" align="center">
            <img src="assets/base/index_logo.png" alt="indexlogo"/>
            <p><?= $SERVER_NAME.' <cite>'.$SYSTEM_VERSION; ?></cite> <span class="badge rounded-pill text-bg-warning">Beta</span></p>
        </nav>
        <aside class="msglogin" align="center">
            <?php
                if(isset($_SESSION['MsgError'])){
                    echo $_SESSION['MsgError'];
                    unset($_SESSION['MsgError']);
                }
                else{
                    unset($_SESSION['MsgError']);
                }
            ?>
        </aside>
        <section class="formlogin" align="center">
            <form action="scripts/login.php" method="POST">
                <div class="formmodel" align="left">
                    <label for="loginuser"><i class="bi bi-person-square"></i> Email</label> 
                    <input class="form-control" name="loginuser" id="loginuser" type="text" placeholder="Login" maxlength="100" required/>
                    <label for="loginpass"><i class="bi bi-key"></i> Senha</label> 
                    <input class="form-control" name="loginpass" id="loginpass" type="password" placeholder="********" minlength="8" maxlength="32" required/>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </section>
        <div class="systemsupport" align="center">
            <h6>Se voc?? n??o possui acesso ao seu login, entre em contato com o administrador do seu servidor!</h6>
            <p><?= $SERVER_NAME.' '.$SYSTEM_VERSION.' - '.date('Y'); ?></p>
        </div>
        <footer align="center">
            <div class="mainfoot">
                <a href="https://github.com/r0t1v/pleiades" target="blank"><i class="bi bi-github"></i></a>
                <a href="https://github.com/r0t1v/pleiades/wiki" target="blank"><i class="bi bi-book"></i></a>  
            </div>
        </footer>
        <script type="text/javascript" src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
    </body>
</html>
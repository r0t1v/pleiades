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
        <link rel="shortcut icon" type="image/png" href="../assets/base/favicon.png"/>
        <link rel="stylesheet" href="../styles/style.css"/>
        <link rel="stylesheet" href="../styles/components.css"/>
        <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css"/>
    </head>
    <body>
        <div class="menusystemuser">
                <img src="../assets/base/system_logo.png" alt="logosystem"/>
                <p><?= $servername.' <cite>'.$releaseversion; ?></cite></p>
        </div>
        <a href="../scripts/logout.php">Sair</a>
        <?= $_SESSION['nomeuser'].' Logou!'; ?>
        <footer align="center">
            <div class="mainfoot">
                <a href="https://github.com/r0t1v/pleiades" target="blank"><i class="bi bi-github"></i></a>
                <a href="https://github.com/r0t1v/pleiades/wiki" target="blank"><i class="bi bi-book"></i></a>
            </div>
        </footer>
        <script type="text/javascript" src="../vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
    </body>
</html>
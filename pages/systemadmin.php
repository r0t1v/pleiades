<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Pleiades - Sistema</title>
        <meta name="description" content="Pagina principal do Pleiades">
        <meta name="keywords" content="HTML, CSS, Javascript, PHP">
        <meta name="author" content="Vitor G. Dantas">
        <link rel="shortcut icon" type="image/png" href="../assets/base/favicon.png"/>
        <link rel="stylesheet" href="../styles/style.css"/>
        <link rel="stylesheet" href="../styles/components.css"/>
        <link rel="stylesheet" href="../libs/bootstrap.css"/>
        <link rel="stylesheet" href="../libs/icons-1.10.2/font/bootstrap-icons.css"/>
    </head>
    <body>
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
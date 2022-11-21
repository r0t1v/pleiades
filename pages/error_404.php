<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>!Ops - Pleiades</title>
    <link rel="shortcut icon" type="image/png" href="../assets/base/favicon.png"/>
    <link rel="stylesheet" href="../styles/style.css"/>
    <link rel="stylesheet" href="../styles/components.css"/>
    <link rel="stylesheet" href="../libs/bootstrap.css"/>
    <link rel="stylesheet" href="../libs/icons-1.10.2/font/bootstrap-icons.css"/>
</head>
<body>
    <div class="errorall" align="center">
        <img src="../assets/base/error_logo.png" alt="errorlogo"/>
            <h1>
                <i class="bi bi-x-square-fill"></i> Página não encontrada!
            </h1>
        <p>
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                Desculpe! Não consegui identificar o que você estava procurando!
            <?php endif ?>
        </p>
        <a href=""><i class="bi bi-arrow-left-circle-fill"></i> Voltar</a>
    </div>
</body>
</html>

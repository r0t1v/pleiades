<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Pleiades - Sistema</title>
        <meta name="description" content="Pagina principal do Pleiades">
        <meta name="keywords" content="HTML, CSS, Javascript, PHP">
        <meta name="author" content="Vitor G. Dantas">
        <link rel="shortcut icon" type="image/png" href="assets/base/favicon.png"/>
        <link rel="stylesheet" href="styles/style.css"/>
        <link rel="stylesheet" href="styles/components.css"/>
        <link rel="stylesheet" href="libs/bootstrap.css"/>
        <link rel="stylesheet" href="libs/icons-1.10.2/font/bootstrap-icons.css"/>
    </head>
    <body>
        <nav class="mainmenu" align="center">
            <img src="assets/base/index_logo.png" alt="indexlogo"/>
            <p>Pleiades <cite>v0.1.1</cite> <span class="badge rounded-pill text-bg-warning">Beta</span></p>
        </nav>
        <section class="formlogin" align="center">
            <form>
                <div class="formmodel" align="left">
                    <label for="loginuser"><i class="bi bi-person-badge"></i> Usuário</label> 
                    <input class="form-control" name="loginuser" id="loginuser" type="text" placeholder="Login" required/>
                    <label for="loginpass"><i class="bi bi-key"></i> Senha</label> 
                    <input class="form-control" name="loginpass" id="loginpass" type="password" placeholder="********" required/>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </section>
        <div class="systemsupport" align="center">
            <h6>Se você não possui acesso ao seu login, entre em contato com o administrador do seu servidor!</h6>
        </div>
        <footer align="center">
            <div class="mainfoot">
                <h6>Desenvolvido com o CodeIgniter <?= CodeIgniter\CodeIgniter::CI_VERSION ?></h6>
                <a href="https://github.com/r0t1v/pleiades" target="blank"><i class="bi bi-github"></i></a>
                <a href="https://github.com/r0t1v/pleiades/wiki" target="blank"><i class="bi bi-book"></i></a>
            </div>
        </footer>
        <script type="text/javascript" src="libs/bootstrap.js"></script>
    </body>
</html>
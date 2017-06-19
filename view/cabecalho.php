<div class="navbar-wrapper" style="margin-bottom: 60px;">
    <div class="container-fluid">
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div id="navbar" class="navbar-collapse collapse text-uppercase">
                    <ul class="nav navbar-nav">
                        <div class="navbar-header">
                            <a href="<?= getRootPath() . '/index.php' ?>">
                                <img class="navbar-brand" src="<?= getRootPath() . '/public/img/logo.png' ?>" alt="logo">
                            </a>
                        </div>
                        <li><a href="<?= getRootPath() . '/view/abrirchamado.php' ?>">Solicitar serviço</a></li>
                        <li><a href="#">Meus chamados</a></li>
                        <li><a href="#">Caixa de entrada</a></li>
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <a href="<?= getRootPath() . '/view/login.php?logout=logoff' ?>" id="logout" style="margin-bottom: -10px; line-height: 13px;">
                                Logout <br>
                                <small style="font-size: 10px;">(<?=strtoupper($_SESSION['username'])?>)</small>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
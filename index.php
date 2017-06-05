<!DOCTYPE html>
<html>
<head>
    <?php
        session_start();
        include_once('includes/libs.php');

        # SE USUÁRIO NÃO ESTIVER LOGADO, REDIRECIONA
        if ( !isset($_SESSION['logado']) ) {
            header("Location: ". getRootPath() ."/view/login.php");
            die();
        }
    ?>
</head>

<body class="background-site">
    <?php
        include_once('view/cabecalho.php');
        include_once('model/Chamados.class.php');
        include_once('model/Usuarios.class.php');

        $setor = mb_strtolower( Usuarios::getSetor(@$_SESSION['userid']), 'UTF-8' );
        $username = mb_strtolower($_SESSION['username'], 'UTF-8');

        $countFinalizado = Chamados::getContagem('finalizados', " AND lower(setores.titulo) = '$setor' ");
        $countAtendimento = Chamados::getContagem('atendimento', " AND lower(setores.titulo) = '$setor' ");
        $countPendente = Chamados::getContagem('pendentes', " AND lower(setores.titulo) = '$setor' ");
        $countEstourado = Chamados::getContagem('estourados', " AND lower(setores.titulo) = '$setor' ");
    ?>    

    <div class="container">

        <div  align="center">
            <div class="alert alert-header">
                <h4>
                    <span class="text-capitalize"><?=$username?></span>, bem-vindo(a) a central de chamados da equipe de <?=$setor?>
                </h4>
            </div>
        </div>

        <div class="jumbotron">
            <div class="row" id="central-chamados">

                <div class="col-md-3">
                    <div style="cursor: pointer" class="alert alert-success" align="center"
                            onclick="window.location.href = '<?=getRootPath() . '/view/chamadosporstatus.php'?>?status=finalizados';">

                        <b>FINALIZADOS <span class="badge"> <?php echo $countFinalizado ?> </span></b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="cursor: pointer" class="alert alert-info" align="center"
                            onclick="window.location.href = '<?=getRootPath() . '/view/chamadosporstatus.php'?>?status=atendimento';">

                        <b>EM ATENDIMENTO <span class="badge active"> <?php echo $countAtendimento ?> </span></b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="cursor: pointer" class="alert alert-warning" align="center"
                            onclick="window.location.href = '<?=getRootPath() . '/view/chamadosporstatus.php'?>?status=pendentes';">

                        <b>PENDENTES <span class="badge"> <?php echo $countPendente ?> </span></b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="cursor: pointer" class="alert alert-danger" align="center"
                            onclick="window.location.href = '<?=getRootPath() . '/view/chamadosporstatus.php'?>?status=estourados';">

                        <b>ESTOURADOS <span class="badge"> <?php echo $countEstourado ?> </span></b>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php include('view/rodape.php'); ?>
</body>
</html>
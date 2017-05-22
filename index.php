<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- CSS CUSTOMIZADO -->
    <link rel="stylesheet" href="public/css/cabecalho.css">
    <link rel="stylesheet" href="public/css/index.css">
</head>

<body>
    <?php
        include('view/cabecalho.php');
        include('model/Chamados.class.php');
        include('model/ConexaoBanco.class.php');
        include('model/Servicos.class.php');

        $countFinalizado = Chamados::getContagem('finalizados');
        $countAtendimento = Chamados::getContagem('atendimento');
        $countPendente = Chamados::getContagem('pendentes');
        $countEstourado = Chamados::getContagem('estourados');
    ?>    

    <div class="container">

        <div  align="center">
            <div class="alert" style="height: 45px; color: white; background-color: rgb(37, 148, 210); border-color: #0781b9;">
                <h4> CENTRAL DE CHAMADOS </h4>
            </div>
        </div>

        <div class="jumbotron">
            <div class="row" id="central-chamados">

                <div class="col-md-3">
                    <div class="alert alert-success" align="center">
                        <b>FINALIZADOS <span class="badge"> <?php echo $countFinalizado ?> </span></b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="alert alert-info" align="center">
                        <b>EM ATENDIMENTO <span class="badge active"> <?php echo $countAtendimento ?> </span></b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="alert alert-warning" align="center">
                        <b>PENDENTES <span class="badge"> <?php echo $countPendente ?> </span></b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="alert alert-danger" align="center">
                        <b>ESTOURADOS <span class="badge"> <?php echo $countEstourado ?> </span></b>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php include('view/rodape.php'); ?>
</body>
</html>
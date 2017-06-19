<html>
<head>
    <?php
        session_start();
        include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/includes/libs.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Usuarios.class.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/controller/chamados.controller.php');

        # SE USUÁRIO NÃO ESTIVER LOGADO, REDIRECIONA
        if ( !isset($_SESSION['logado']) ) {
            header("Location: ". getRootPath() ."/view/login.php");
            die();
        }
    ?>
</head>

<body class="background-site">
    <?php
        include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/view/cabecalho.php');
    ?>

    <div class="well" style="background-color: transparent; border: none; margin-left: 5%; margin-right: 5%;">
        <div align="center">
            <div class="alert alert-header">
                <h4 class="text-uppercase"> Solicitar serviço </h4>
            </div>
        </div>

        <form action="<?= getRootPath() ."/controller/chamados.controller.php?acao=cadastrar" ?>">

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="label-form"> Descreva sua solicitação: </label>
                    <textarea id="descricao" name="descricao" placeholder="Solicito atualização de software..." class="form-control input-lg" rows="5"></textarea>
                </div>
                
                 <div class="form-group col-md-3">
                    <label for="setor" class="label-form">Setor responsável:</label>
                    <select class="form-control input-lg" name="setor" id="setor">
                        <?= getOptionsSetores() ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="categorias" class="label-form">Categoria:</label>
                    <select class="form-control input-lg" name="categorias" id="categorias">
                        <?= getOptionsCategorias() ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="servico" class="label-form">Tipo de Serviço:</label>
                    <select class="form-control input-lg" name="servico" id="servico">
                         <?= getOptionsDescricao() ?>
                    </select>
                </div>

            </div>


            <div class="row">
                <div class="form-group col-md-3">
                </div>

                 <div class="form-group col-md-3">
                    <label for="sla" class="label-form">SLA</label>
                    <select disabled class="form-control input-lg" name="sla" id="sla">
                        <!-- jquery -->
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="prioridade" class="label-form">Prioridade:</label>
                    <select disabled class="form-control input-lg" name="prioridade" id="prioridade">
                        <!-- jquery -->
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="solicitante" class="label-form">Solicitante:</label>
                    <select disabled class="form-control input-lg" name="solicitante" id="solicitante" style="background-color:#CCC">
                        <option value="<?=$_SESSION['userid']?>"> <?= mb_strtoupper($_SESSION['username'], 'UTF-8') ?> </option>
                    </select>
                </div>

            </div>

            <div class="row"> <div class="form-group col-md-12" align="center"> <hr> </div> </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <button type="submit" style="width: 25%;" class="btn btn-primary label-form">Abrir chamado</button>
                </div>
            </div>
            
            <input type="hidden" name="acao" value="cadastrar">
            <input type="hidden" name="usuarioabertura" value="<?=$_SESSION['userid']?>">
        </form>
    </div>

    <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/view/rodape.php'); ?>
</body>

<script type="text/javascript">
    $(document).ready(function(){

        var url = '<?= getRootPath() . "/controller/chamados.controller.php" ?>';
        var usuario = '<?= @$_SESSION["userid"] ?>';

         $('#servico').on('change', function(e) {
            $.get(url, {idservico: $('#servico').val(), usuario: usuario, acao: 'getdados'}).done(function(resp) {
                var resp = JSON.parse(resp);

                $('#sla').html('<option value="2">'+resp.sla+'</option>');
                $('#prioridade').html('<option value="2">'+resp.prioridade+'</option>');

            });
         });

    });
</script>

</html>

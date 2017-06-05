<html>
<head>
    <?php
        session_start();
        include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/includes/libs.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Usuarios.class.php');

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
        @$_GET["status"] = (@$_GET["status"] == 'atendimento') ? 'em atendimento' : @$_GET["status"];
    ?>

    <div style="margin-left: 2%; margin-right: 2%;">
        <div align="center" class="">
            <div class="alert alert-header">
                <h4>
                    Chamados <?= @$_GET["status"] . ' da equipe de ' . mb_strtolower(Usuarios::getSetor($_SESSION['userid']), 'UTF-8'); ?>
                </h4>
            </div>
        </div>

        <table class="table table-condensed table-striped" style="margin-bottom: 50px; background-color: #3b556c">
            <thead>
                <tr style="text-align:center">
                    <td>Serviço</td>
                    <td>Descrição</td>
                    <td>Abertura</td>
                    <td>Solicitante</td>
                    <td>Responsável</td>
                    <td>Status</td>
                    <td>Fechamento</td>
                    <td>Corrente</td>
                    <td>Atraso</td>
                    <td>SLA</td>
                </tr>
            </thead>
            <tbody id="lista-tbody">
                <tr>
                    <td align="center" colspan="50">Nenhum registro encontrado</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/view/rodape.php'); ?>
</body>

<script type="text/javascript">
    $(document).ready(function(){

        var url = '<?= getRootPath() . "/controller/chamados.controller.php" ?>';
        var status = '<?= @$_GET["status"] ?>';
        var usuario = '<?= @$_SESSION["userid"] ?>';

        $.get(url, {status: status, usuario: usuario, acao: 'listarporsetor'}).done(function(resp) {
            var resp = JSON.parse(resp);

            if (resp.registros > 0) {
                $('#lista-tbody').html('');
                resp.dados.forEach(function(e,i,a) {

                    var row = `<tr class="text-uppercase" style="text-align:center; font-size:12px;">
                                   <td>${e.servico == null ? 'Não informado': e.servico}</td>
                                   <td>${e.descricao == null ? 'Não informado': e.descricao}</td>
                                   <td style="width: 80px;">${e.abertura.split(' ')[0]}</td>
                                   <td>${e.solicitante == null ? 'Não informado': e.solicitante}</td>
                                   <td>${e.responsavel == null ? 'Ninguém': e.responsavel}</td>
                                   <td>${e.status == null ? 'Não informado': e.status}</td>
                                   <td>${e.fechamento == null ? 'Aberto': e.fechamento.split(' ')[0]}</td>
                                   <td>${e.tempoaberto == null ? 'Não informado': Math.floor(e.tempoaberto / 24) + ' dias'}</td>
                                   <td>${e.tempoestourado}</td>
                                   <td>${e.sla == null ? 'Não informado': Math.floor(e.sla / 24) + ' dias'}</td>
                               </tr>`;

                    $('#lista-tbody').append(row);
                });

            }
        });

    });
</script>

</html>

<html>
<head>
    <?php include_once('../includes/libs.php'); ?>

    <script type="text/javascript">
        $(document).ready(function(){

            var url = '<?= getRootPath() . "/controller/chamados.controller.php" ?>';
            var status = '<?= @$_GET["status"] ?>';
            var usuario = '<?= @$_SESSION["userid"] ?>';

            $.get(url, {status: status, usuario: usuario}).done(function(resp) {
                $('#lista-tbody').html(resp);
            });

        });
    </script>
</head>

<body>
    <?php include_once('/cabecalho.php'); ?>

    <div class="container" align="center">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="10">Descrição</th>
                    <th>Aberto por</th>
                    <th>Encerrado por</th>
                    <th>Status</th>
                    <th>Abertura</th>
                    <th>Fechamento</th>
                    <th>SLA</th>
                </tr>
            </thead>
            <tbody id="lista-tbody"></tbody>
        </table>
    </div>
    
    <?php include_once('/rodape.php'); ?>
</body>

</html>

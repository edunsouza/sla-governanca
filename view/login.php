<!DOCTYPE html>
<html>
<head>
    <?php
        session_start();
        include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/includes/libs.php');
        
        # SE USUÁRIO JÁ ESTIVER LOGADO, VERIFICA AÇÃO DE LOGOUT OU REDIRECIONA
        if ( isset($_SESSION['logado']) ) {

            if ( isset($_GET['logout']) && $_GET['logout'] == 'logoff' ) {
                session_destroy();
            } else {
                header("Location: ". getRootPath());
                die();
            }

        }
    ?>

    <script>
        $(document).ready(function(e) {
            var index = '<?= getRootPath() . "/index.php" ?>';

            // SUBMIT
            $("#submit").on('click', function(evt) {
                var url = '<?= getRootPath() . "/controller/login.controller.php" ?>';
                $(this).addClass('disabled');

                $.post(url, {usuario: $("#usuario").val(), acao: 'logar' }).done(function(data){
                    var teste = JSON.parse(data);

                    if (teste.sucesso) {
                        window.location.href = index;
                        $("#submit").addClass('disabled');
                        return;
                    }

                    $("#submit").removeClass('disabled');
                    alert('Usuário ou Senha inválidos');
                });

            });
        });
    </script>

</head>
<body style="background-color: #EEE">
    <div class="container">
        <div class="row">
            <div class="jumbotron col-md-4" style="position:fixed; top:20%; left:0; right:0; margin: auto; background:linear-gradient(#0580B7, #58B4FD)">
        
                <h3 align="center" style="color:white; padding-bottom: 20px">Bem-vindo ao Wal-mars</h3>
        
                <input type="text" id="usuario" class="form-control input-lg" placeholder="Usuário" />
                </br>
        
                <input type="password" id="senha" class="form-control input-lg" placeholder="Senha" />
                </br>
        
                <span class="group-btn">
                    <button id="submit" class="btn btn-primary btn-lg btn-block pull-right">
                        Acessar <i class="glyphicon glyphicon-globe"></i>
                    </button>
                </span>

            </div>
        </div>
    </div>

</body>
</html>

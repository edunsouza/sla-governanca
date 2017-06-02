<?php
    # SE USUÁRIO JÁ ESTIVER LOGADO, FICA NA SESSÃO
    if ( @$_SESSION['logado'] ) {
        header("Location: /sla_governanca");
        die();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php include_once('../includes/libs.php'); ?>
    
    <script>
        $(document).ready(function(e) {
            // SUBMIT
            $("#submit").on('click', function(evt) {
                var url = '<?= getRootPath() . "/controller/login.controller.php" ?>';
                $(this).addClass('disabled');

                $.post(url, {usuario: $("#usuario").val(), senha: $("#senha").val() }).done(function(data){
                    var teste = JSON.parse(data);

                    if (teste.sucesso) {
                        window.location.href = $(document).prop('URL').substring(0, $(document).prop('URL').indexOf('/', $(document).prop('origin').length + 1));
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
            <div class="jumbotron col-md-3" style="position:fixed; top:30%; left:0; right:0; margin:auto; background:linear-gradient(#0580B7, #58B4FD)">
        
                <h3 align="center" style="color:white; padding-bottom: 20px">Bem-vindo ao Wal-mars</h3>
        
                <input type="text" id="usuario" class="form-control input-lg" placeholder="Usuário" />
                </br>
        
                <input type="password" id="senha" class="form-control input-lg" placeholder="Senha" />
                </br>
        
                <span class="group-btn">
                    <a id="submit" class="btn btn-primary btn-lg btn-block pull-right">Acessar <i class="glyphicon glyphicon-globe"></i></a>
                </span>

            </div>
        </div>
    </div>

</body>
</html>

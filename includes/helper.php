<?php
    function getRootPath() {
        return "http://{$_SERVER['HTTP_HOST']}/sla_governanca";
    }

    function printStop($valor) {
        echo "<pre>";
        print_r($valor);
        echo "</pre>";
    }

    function redirecionarSeLogado() {
        echo 'edu';

        if ( !isset($_SESSION['logado']) ) {
            header("Location: http://{$_SERVER['HTTP_HOST']}/sla_governanca/view/login.php");
            die();
        }

    }
?>
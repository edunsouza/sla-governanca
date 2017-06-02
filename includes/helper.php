<?php
    function getRootPath() {
        return "http://{$_SERVER['HTTP_HOST']}/sla_governanca";
    }

    function printStop($valor) {
        echo "<pre>";
        print_r($valor);
        echo "</pre>";
    }
?>
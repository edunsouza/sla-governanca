<?php
include_once( $_SERVER['DOCUMENT_ROOT'] . "/sla_governanca/model/ConexaoBanco.class.php" );

class Login {

    public static function validar($usuario, $senha) {
        $usuario = strtolower($usuario);
        
        $rs = ConexaoBanco::query("SELECT * FROM usuarios WHERE LOWER(nome) = '{$usuario}'");

        if (count($rs) > 0) return $rs[0]['id'];

        return false;
    }

}
?>
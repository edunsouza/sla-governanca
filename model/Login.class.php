<?php
include_once( $_SERVER['DOCUMENT_ROOT'] . "/sla_governanca/model/ConexaoBanco.class.php" );

class Login {

    public static function validar($usuario) {
        $usuario = strtolower($usuario);
        
        $rs = ConexaoBanco::query("SELECT * FROM usuarios WHERE LOWER(nome) = '{$usuario}'");

        if (count($rs) > 0) return $rs[0]['id'];

        return false;
    }

    public static function getNome($id) {
        return ConexaoBanco::query("SELECT nome FROM usuarios WHERE id = $id")[0]['nome'];
    }

}
?>
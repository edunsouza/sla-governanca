<?php
include_once( $_SERVER['DOCUMENT_ROOT'] . "/sla_governanca/model/ConexaoBanco.class.php" );

class Usuarios {

    public static function getSetor($userid) {
        return ConexaoBanco::query("SELECT s.titulo
                                    FROM usuarios_setor us
                                        JOIN usuarios u ON u.id = us.idusuario
                                        JOIN setores s ON s.id = us.idsetor
                                    WHERE u.id = $userid")[0]['titulo'];
    }

    public static function getDados($userid) {
        return ConexaoBanco::query("SELECT 
                                        u.id AS idusuario,
                                        u.nome AS nome,
                                        c.titulo AS cargo,
                                        s.titulo AS setor
                                    FROM usuarios_setor us
                                    JOIN usuarios u ON u.id = us.idusuario
                                    JOIN setores s ON us.idsetor = s.id
                                    JOIN cargos c ON c.id = us.idcargo
                                    WHERE u.id = $userid")[0];
    }

    public static function getNome($userid) {
        return ConexaoBanco::query("SELECT nome FROM usuarios WHERE id = $userid")[0]['nome'];
    }

}
?>
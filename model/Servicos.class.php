<?php
include_once( $_SERVER['DOCUMENT_ROOT'] . "/sla_governanca/model/ConexaoBanco.class.php" );

class Servicos {
    
    public static function getServicos() {
        return ConexaoBanco::query("SELECT 
                                        categorias.titulo AS categoria,
                                        descricao,
                                        setores.titulo AS setor,
                                        permissoes.titulo AS permissao,
                                        sla,
                                        prioridade,
                                        SUBSTRING(atendimentode, 1, 5) AS atendimentode,
                                        SUBSTRING(atendimentoate, 1, 5) AS atendimentode
                                    FROM
                                        servicos
                                            JOIN setores ON setores.id = servicos.setorresponsavel
                                            JOIN categorias ON categorias.id = idcategoria
                                            JOIN permissoes ON permissoes.id = permissaoabertura");
    }

    public static function getDados($id) {
        return ConexaoBanco::query( "SELECT sla, prioridade FROM servicos WHERE id = $id");
    }

    public static function getDescricao() {
        return ConexaoBanco::query( "SELECT id, descricao FROM servicos");
    }

    public static function getCategorias() {
        return ConexaoBanco::query( "SELECT id, titulo AS categoria FROM categorias" );
    }

    public static function getSetores() {
        return ConexaoBanco::query( "SELECT id, titulo AS setor FROM setores" );
    }

    public static function getUsuarios() {
        return ConexaoBanco::query("SELECT 
                                        usuarios.nome AS usuario,
                                        cargos.titulo AS cargos,
                                        setores.titulo AS setores
                                    FROM
                                        usuarios_setor
                                        JOIN usuarios ON usuarios.id = usuarios_setor.idusuario
                                        JOIN setores ON setores.id = usuarios_setor.idsetor
                                        JOIN cargos ON cargos.id = usuarios_setor.idcargo");
    }

    public static function getCargos() {
        return ConexaoBanco::query( "SELECT cargos.titulo AS cargo FROM cargos" );
    }

    public static function getPermissoes() {
        return ConexaoBanco::query( "SELECT permissoes.titulo AS permissao FROM permissoes" );
    }

}

?>
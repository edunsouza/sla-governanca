<?php
class Servicos {
    
    public static function getServicos() {
        $sql = "SELECT 
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
                        JOIN permissoes ON permissoes.id = permissaoabertura";

        return ConexaoBanco::query($sql);
    }

    public static function getCategorias() {
        return ConexaoBanco::query( "SELECT titulo AS categoria FROM categorias" );
    }

    public static function getSetores() {
        return ConexaoBanco::query( "SELECT setores.titulo AS setor FROM setores" );
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

    public static function getChamados() {
        return ConexaoBanco::query("SELECT 
                                        chamados.descricao,
                                        servicos.descricao AS servico,
                                        usuarios.nome AS usuarioabertura,
                                        usu2.nome AS usuarioencerramento,
                                        chamados.status,
                                        chamados.abertura,
                                        chamados.fechamento
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    JOIN usuarios usu2 ON usuarios.id = chamados.usuarioencerramento" );
    }

}

?>
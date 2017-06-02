<?php
include_once( $_SERVER['DOCUMENT_ROOT'] . "/sla_governanca/model/ConexaoBanco.class.php" );

class Chamados {

    # PUBLIC

    public static function getContagem($tipo) {
        switch ($tipo) {
            case 'finalizados':
                return self::getFinalizados(true)[0]['quantidade'];
                break;
            
            case 'pendentes':
                return self::getPendentes(true)[0]['quantidade'];
                break;
            
            case 'estourados':
                return self::getEstourados(true)[0]['quantidade'];
                break;
            
            case 'atendimento':
                return self::getAtendimento(true)[0]['quantidade'];
                break;
        }
    }

    public static function getChamados() {
        return ConexaoBanco::query("SELECT 
                                        chamados.descricao,
                                        servicos.descricao AS servico,
                                        servicos.sla AS sla,
                                        usuarios.nome AS usuarioabertura,
                                        usu2.nome AS usuarioencerramento,
                                        chamados.status,
                                        chamados.abertura,
                                        chamados.fechamento
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    LEFT JOIN usuarios usu2 ON usuarios.id = chamados.usuarioencerramento" );
    }


    # PRIVATE

    private static function getFinalizados($contar = false) {
       $campos = " chamados.descricao,
                   servicos.descricao AS servico,
                   servicos.sla AS sla,
                   usuarios.nome AS usuarioabertura,
                   usu2.nome AS usuarioencerramento,
                   chamados.status,
                   chamados.abertura,
                   chamados.fechamento ";

        if ($contar)
            $campos = " COUNT(*) AS quantidade ";

        return ConexaoBanco::query("SELECT
                                        {$campos}
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    LEFT JOIN usuarios usu2 ON usuarios.id = chamados.usuarioencerramento
                                    WHERE chamados.status = 'F'" );
    }

    private static function getPendentes($contar = false) {
        $campos = " chamados.descricao,
                    servicos.descricao AS servico,
                    servicos.sla AS sla
                    usuarios.nome AS usuarioabertura,
                    usu2.nome AS usuarioencerramento,
                    chamados.status,
                    chamados.abertura,
                    chamados.fechamento ";
        
        if ($contar)
            $campos = " COUNT(*) AS quantidade ";

        return ConexaoBanco::query("SELECT
                                        {$campos} 
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    LEFT JOIN usuarios usu2 ON usuarios.id = chamados.usuarioencerramento
                                    WHERE chamados.status = 'P'");
    }

    private static function getEstourados($contar = false) {
        $campos = " chamados.descricao,
                    categorias.titulo AS categoria,
                    IF(chamados.status = 'P', 'PENDENTE',
                        IF(chamados.status = 'A', 'EM ATENDIMENTO',
                            IF(chamados.status = 'F', 'FINALIZADO', 'SEM STATUS')
                        )
                    ) AS status,
                    usuarios.nome AS solicitante,
                    usu2.nome AS responsavel,
                    servicos.sla AS slaoriginal,
                    HOUR(TIMEDIFF(NOW(), chamados.abertura)) AS tempoaberto,
                    (HOUR(TIMEDIFF(NOW(), chamados.abertura)) - servicos.sla) AS tempoestourado ";
        
        if ($contar)
            $campos = " COUNT(*) AS quantidade ";

        return ConexaoBanco::query("SELECT
                                        {$campos}
                                    FROM
                                        chamados
                                            JOIN servicos ON servicos.id = chamados.idservico
                                            LEFT JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                            LEFT JOIN usuarios usu2 ON usu2.id = chamados.usuarioencerramento
                                            JOIN categorias ON categorias.id = servicos.idcategoria
                                    WHERE
                                        ( HOUR(TIMEDIFF( NOW(), chamados.abertura) ) > servicos.sla )");
    }

    private static function getAtendimento($contar = false) {
        $campos = " chamados.descricao,
                    servicos.descricao AS servico,
                    servicos.sla AS sla,
                    usuarios.nome AS usuarioabertura,
                    usu2.nome AS usuarioencerramento,
                    chamados.status,
                    chamados.abertura,
                    chamados.fechamento ";

        if ($contar)
            $campos = " COUNT(*) AS quantidade ";

        return ConexaoBanco::query("SELECT
                                        {$campos}
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    LEFT JOIN usuarios usu2 ON usuarios.id = chamados.usuarioencerramento
                                    WHERE chamados.status = 'A'");
    }

}
?>
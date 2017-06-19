<?php
include_once( $_SERVER['DOCUMENT_ROOT'] . "/sla_governanca/model/ConexaoBanco.class.php" );
include_once( $_SERVER['DOCUMENT_ROOT'] . "/sla_governanca/includes/helper.php" );

class Chamados {

    # PUBLIC

    public static function getContagem($status, $where = '') {
        switch ($status) {
            case 'finalizados':
                return self::getFinalizados(true, $where)[0]['quantidade'];
                break;
            
            case 'pendentes':
                return self::getPendentes(true, $where)[0]['quantidade'];
                break;
            
            case 'estourados':
                return self::getEstourados(true, $where)[0]['quantidade'];
                break;
            
            case 'atendimento':
                return self::getAtendimento(true, $where)[0]['quantidade'];
                break;
        }
    }

    public static function getPorStatus($status, $where = '') {
        switch ($status) {
            case 'finalizados':
                return self::getFinalizados(false, $where);
                break;
            
            case 'pendentes':
                return self::getPendentes(false, $where);
                break;
            
            case 'estourados':
                return self::getEstourados(false, $where);
                break;
            
            case 'atendimento':
                return self::getAtendimento(false, $where);
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
                                    LEFT JOIN usuarios usu2 ON usu2.id = chamados.usuarioencerramento" );
    }


    public static function cadastrar($dados) {
        return ConexaoBanco::query("INSERT INTO chamados (descricao, idservico, usuarioabertura, status, abertura)
                                    VALUES ( '{$dados['descricao']}', {$dados['idservico']}, '{$dados['usuarioabertura']}',
                                    'P',  NOW() )");
    }

    # PRIVATE

    private static function getFinalizados($contar = false, $where = '') {
        $campos = " chamados.descricao AS descricao,
                   setores.titulo AS setor,
                   servicos.descricao AS servico,
                   servicos.sla AS sla,
                   categorias.titulo AS categoria,
                   usuarios.nome AS solicitante,
                   usu2.nome AS responsavel,
                   'FINALIZADO' AS status,
                   chamados.abertura AS abertura,
                   chamados.fechamento AS fechamento,
                   HOUR(TIMEDIFF(COALESCE(chamados.fechamento, NOW()), chamados.abertura)) AS tempoaberto,
                   IF(HOUR(TIMEDIFF(COALESCE(fechamento, NOW()), abertura)) - sla <= 0,
                       'Dentro do SLA',
                       CONCAT(FLOOR((HOUR(TIMEDIFF(COALESCE(fechamento, NOW()), abertura)) - sla) / 24), ' dias')
                   ) AS tempoestourado";

        if ($contar)
            $campos = " COUNT(*) AS quantidade ";

        return ConexaoBanco::query("SELECT {$campos}
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    LEFT JOIN usuarios usu2 ON usu2.id = chamados.usuarioencerramento
                                    JOIN setores ON setores.id = servicos.setorresponsavel
                                    JOIN categorias ON categorias.id = servicos.idcategoria
                                    WHERE chamados.status = 'F'
                                    $where");
    }

    private static function getPendentes($contar = false, $where = '') {
        $campos = " chamados.descricao AS descricao,
                    setores.titulo AS setor,
                    servicos.descricao AS servico,
                    servicos.sla AS sla,
                    categorias.titulo AS categoria,
                    usuarios.nome AS solicitante,
                    usu2.nome AS responsavel,
                    'PENDENTE' AS status,
                    chamados.abertura AS abertura,
                    chamados.fechamento AS fechamento,
                    HOUR(TIMEDIFF(COALESCE(chamados.fechamento, NOW()), chamados.abertura)) AS tempoaberto,
                    IF(HOUR(TIMEDIFF(COALESCE(fechamento, NOW()), abertura)) - sla <= 0,
                        'Dentro do SLA',
                        CONCAT(FLOOR((HOUR(TIMEDIFF(COALESCE(fechamento, NOW()), abertura)) - sla) / 24), ' dias')
                    ) AS tempoestourado";

        if ($contar)
            $campos = " COUNT(*) AS quantidade ";

        return ConexaoBanco::query("SELECT {$campos} 
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    LEFT JOIN usuarios usu2 ON usu2.id = chamados.usuarioencerramento
                                    JOIN setores ON setores.id = servicos.setorresponsavel
                                    JOIN categorias ON categorias.id = servicos.idcategoria
                                    WHERE chamados.status = 'P'
                                    $where");
    }

    private static function getEstourados($contar = false, $where = '') {
        $campos = " chamados.descricao AS descricao,
                    setores.titulo AS setor,
                    servicos.descricao AS servico,
                    servicos.sla AS sla,
                    categorias.titulo AS categoria,
                    usuarios.nome AS solicitante,
                    usu2.nome AS responsavel,
                    IF(chamados.status = 'P', 'PENDENTE',
                        IF(chamados.status = 'A', 'EM ATENDIMENTO',
                            IF(chamados.status = 'F', 'FINALIZADO', 'SEM STATUS')
                        )
                    ) AS status,
                    chamados.abertura AS abertura,
                    chamados.fechamento AS fechamento,
                    HOUR(TIMEDIFF(COALESCE(chamados.fechamento, NOW()), chamados.abertura)) AS tempoaberto,
                    CONCAT(FLOOR((HOUR(TIMEDIFF(COALESCE(fechamento, NOW()), abertura)) - sla) / 24), ' dias') AS tempoestourado";
        
        if ($contar)
            $campos = " COUNT(*) AS quantidade ";

        return ConexaoBanco::query("SELECT {$campos}
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    LEFT JOIN usuarios usu2 ON usu2.id = chamados.usuarioencerramento
                                    JOIN setores ON setores.id = servicos.setorresponsavel
                                    JOIN categorias ON categorias.id = servicos.idcategoria
                                    WHERE (HOUR(TIMEDIFF(COALESCE(chamados.fechamento, NOW()), chamados.abertura)) > servicos.sla)
                                    $where");
    }

    private static function getAtendimento($contar = false, $where = '') {
        $campos = " chamados.descricao AS descricao,
                    setores.titulo AS setor,
                    servicos.descricao AS servico,
                    servicos.sla AS sla,
                    categorias.titulo AS categoria,
                    usuarios.nome AS solicitante,
                    usu2.nome AS responsavel,
                    'EM ATENDIMENTO' AS status,
                    chamados.abertura AS abertura,
                    chamados.fechamento AS fechamento,
                    HOUR(TIMEDIFF(COALESCE(chamados.fechamento, NOW()), chamados.abertura)) AS tempoaberto,
                    IF(HOUR(TIMEDIFF(COALESCE(fechamento, NOW()), abertura)) - sla <= 0,
                        'Dentro do SLA',
                        CONCAT( FLOOR( (HOUR(TIMEDIFF(COALESCE(fechamento, NOW()), abertura)) - sla) / 24), ' dias')
                    ) AS tempoestourado";

        if ($contar)
            $campos = " COUNT(*) AS quantidade ";

        return ConexaoBanco::query("SELECT {$campos}
                                    FROM chamados
                                    JOIN servicos ON servicos.id = chamados.idservico
                                    JOIN usuarios ON usuarios.id = chamados.usuarioabertura
                                    LEFT JOIN usuarios usu2 ON usu2.id = chamados.usuarioencerramento
                                    JOIN setores ON setores.id = servicos.setorresponsavel
                                    JOIN categorias ON categorias.id = servicos.idcategoria
                                    WHERE chamados.status = 'A'
                                    $where");
    }

}
?>
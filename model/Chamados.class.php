<?php
class Chamados {

    public static function getContagem($tipo, $usuario) {

        switch ($tipo) {
            case 'finalizados':
                return getFinalizados();
                break;
            
            case 'pendentes':
                return getPendentes();
                break;
            
            case 'estourados':
                return getEstourados();
                break;
            
            case 'atendimento':
                return getAtendimento();
                break;
        }
    }


    private static function getFinalizados() {
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
                                    JOIN usuarios usu2 ON usuarios.id = chamados.usuarioencerramento
                                    WHERE chamados.status = 'F'" );
    }

}
?>
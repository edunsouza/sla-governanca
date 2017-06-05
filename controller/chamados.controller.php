<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Chamados.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Usuarios.class.php');

if ( isset($_GET['acao']) ) {

    switch ($_GET['acao']) {
        case 'listarporsetor':
            echo json_encode( listarPorSetor() );
            break;
        
        default:
            break;
    }
}


function listarPorSetor() {
    $status = @$_GET['status'];
    $setor = mb_strtolower( Usuarios::getSetor(@$_GET['usuario']), 'UTF-8' );
    $where = " AND lower(setores.titulo) = '$setor' ";
    $dados['sucesso'] = false;

    $dados['dados'] = Chamados::getPorStatus($status, $where);
    $dados['registros'] = count($dados['dados']);
    $dados['sucesso'] = $dados['registros'] > 0;

    return $dados;
}

?>
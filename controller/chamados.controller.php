<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Chamados.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Usuarios.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Servicos.class.php');

if ( isset($_GET['acao']) ) {

    switch ($_GET['acao']) {
        case 'listarporsetor':
            echo json_encode( listarPorSetor() );
            break;
        
        case 'getdados':
            echo json_encode( getDados($_GET['idservico']) );
            break;

        case 'cadastrar':
        header('Location: http://localhost:8080/sla_governanca/index.php');
            try {
                cadastrar();
            } catch (Exception $e) {
                header('Location: http://localhost:8080/sla_governanca/index.php');
            }

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

function getOptionsCategorias() {
    $cats = Servicos::getCategorias();
    $optionsHtml = "";

    foreach ($cats as $row) {
        $optionsHtml .= "<option value=\"{$row['id']}\">{$row['categoria']}</option>";
    }

    echo $optionsHtml;
}

function getOptionsSetores() {
    $setores = Servicos::getSetores();
    $optionsHtml = "";

    foreach ($setores as $row) {
        $optionsHtml .= "<option value=\"{$row['id']}\">{$row['setor']}</option>";
    }

    echo $optionsHtml;
}

function getOptionsDescricao() {
    $descricao = Servicos::getDescricao();
    $optionsHtml = "";

    foreach ($descricao as $row) {
        $optionsHtml .= "<option value=\"{$row['id']}\">{$row['descricao']}</option>";
    }

    echo $optionsHtml;
}

function getDados($id) {
    $sla = Servicos::getDados($id);

    foreach ($sla as $row) {
        $resultado['sla'] = $row['sla'];
        $resultado['prioridade'] = $row['prioridade'];
    }

    return $resultado;
}

function cadastrar() {
    return Chamados::cadastrar(array("descricao" => $_GET['descricao'],
                                     "idservico" => $_GET['servico'],
                                     "usuarioabertura" => $_GET['usuarioabertura']
    ));

}

?>
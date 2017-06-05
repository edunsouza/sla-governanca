<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Login.class.php');

if ( isset($_POST['acao']) ) {
    
    if ( $_POST['acao'] == 'logar' ) {
        echo json_encode( logar() );
    }

}

function logar() {
    if ( isset($_SESSION['logado']) && $_SESSION['logado'] == true ) {
        return array("sucesso" => false, "mensagem" => "Usuário já está logado");
    }

    if ( !isset($_POST['usuario']) ) {
        return array("sucesso" => false, "mensagem" => "Usuário não informado"); 
    }

    $id = Login::validar( $_POST['usuario'] );

    $json['sucesso'] = $id !== false;
    $json['id'] = ($json['sucesso']) ? $id : false;
    $json['mensagem'] = ($json['sucesso']) ? "Sucesso" : "Usuário inválido";

    if ( !isset($_SESSION['logado']) ) {
        $_SESSION['logado'] = true;
        $_SESSION['userid'] = $id;
        $_SESSION['username'] = mb_strtolower( Login::getNome($id), 'UTF-8' );
    }

    return $json;
}

?>
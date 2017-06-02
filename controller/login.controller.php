<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/sla_governanca/model/Login.class.php');

    $usuario = @$_POST['usuario'];
    $senha = @$_POST['senha'];

    $id = Login::validar($usuario, $senha);

    $json['sucesso'] = $id !== false;
    $json['id'] = ($json['sucesso']) ? $id : false;

    if ($json['sucesso'] && !@$_SESSION['logado']) {
        session_start();
        $_SESSION['logado'] = true;
        $_SESSION['userid'] = $id;
    }

    echo json_encode($json);
?>
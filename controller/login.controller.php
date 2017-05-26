<?php
include_once('../model/Login.class.php');

$usuario = @$_POST['usuario'];
$senha = @$_POST['senha'];

$id = Login::validar($usuario, $senha);

$json['sucesso'] = $id !== false;
$json['id'] = ($json['sucesso']) ? $id : false;

echo json_encode($json);

?>
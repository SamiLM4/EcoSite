<?php

require_once "modelo/Usuario.php";

$jsonRecebidoBodyRequest = file_get_contents('php://input');
$obj = json_decode($jsonRecebidoBodyRequest);

$vetor = explode("/", $_SERVER['REQUEST_URI']);
$id_usuario =  $vetor[2];

$nome = $obj->nome_usuario;
$email = $obj->email_usuario;
$senha = $obj->senha_usuario;

/*

{
    "id_prof": ,
    "nome": "",
    "email": "",
    "senha": ""
}

*/

$id_usuario = strip_tags($id_usuario);
$nome = strip_tags($nome);
$email = strip_tags($email);
$senha = strip_tags($senha);


$resposta = array();
$verificador = 0;

if ($nome== '') {
    $resposta['cod'] = 3;
    $resposta['msg'] = "nome nao pode ser vazio";
    $verificador = 1;
} else if ($email == '') {
    $resposta['cod'] = 3;
    $resposta['msg'] = "email nao pode ser vazio";
    $verificador = 1;
} else if ($senha == '') {
    $resposta['cod'] = 3;
    $resposta['msg'] = "senha nao pode ser vazio";
    $verificador = 1;
}


if (!is_numeric($id_usuario)) { 
    $resposta['cod'] = 3;
    $resposta['msg'] = "id_usuario deve ser um número";
    $verificador = 1;
}

if ($verificador == 0) {
    $Usuario = new Usuario();
    $Usuario->setIdUsuario($id_usuario);
    $Usuario->setNomeUsuario($nome);
    $Usuario->setEmailUsuario($email);
    $Usuario->setSenhaUsuario($senha);
 

    $resultado = $Usuario->update();
    if ($resultado == true) {
        header("HTTP/1.1 201 Created");
        $resposta['cod'] = 4;
        $resposta['msg'] = "Atualizado com sucesso!!!";
//        $resposta['Usuario Atualizado'] = $resultado;
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        $resposta['cod'] = 5;
        $resposta['msg'] = "ERRO ao atualizar o Usuario";
    }
}

echo json_encode($resposta);

?>


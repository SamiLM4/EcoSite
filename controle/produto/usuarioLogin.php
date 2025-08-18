<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\MeuTokenJWT2;

require_once "modelo/Usuario.php";
require_once "modelo/MeuTokenJWT2.php";

$jsonRecebidoBodyRequest = file_get_contents('php://input');
$obj = json_decode($jsonRecebidoBodyRequest);

if (!isset($obj->email_usuario) || !isset($obj->senha_usuario)) {
    echo json_encode([
        "cod" => 400,
        "msg" => "Dados incorretos ou incompletos. Por favor, forneça email e senha."
    ]);
    exit();
}

$email = $obj->email_usuario;
$senha = $obj->senha_usuario;

$email = strip_tags($email);

$Usuario = new Usuario();
$Usuario->setEmailUsuario($email);
$Usuario->setSenhaUsuario($senha);


if ($Usuario->login()) {

    $tokenJWT = new MeuTokenJWT2();
    $objectClaimsToken = new stdClass();
    $objectClaimsToken->email = $Usuario->getEmailUsuario();
    $objectClaimsToken->senha = $Usuario->getSenhaUsuario();
    
    $novoToken = $tokenJWT->gerarToken($objectClaimsToken);
    
    echo json_encode([
        "cod" => 200,
        "msg" => "Login realizado com sucesso!!!",
        "Usuario" => [
            "id_usuario" => $Usuario->getIdUsuario(),
            "nome_usuario" => $Usuario->getNomeUsuario(),
            "email_usuario" => $Usuario->getEmailUsuario(),
            "senha_usuario" => $Usuario->getSenhaUsuario()
           
        ],
        "token" => $novoToken
    ]);
} else {
    echo json_encode([
        "cod" => 401,
        "msg" => "ERRO: Login inválido. Verifique suas credenciais."
    ]);
}
?>

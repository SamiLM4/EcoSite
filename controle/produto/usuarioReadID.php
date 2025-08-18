<?php
use Firebase\JWT\MeuTokenJWT2;
require_once "modelo/Usuario.php";
require_once "modelo/MeuTokenJWT2.php";
$vetor = explode("/", $_SERVER['REQUEST_URI']);
$metodo = $_SERVER['REQUEST_METHOD'];

$headers=getallheaders();
    $autorization=$headers['Authorization'];
   $meutoken= new MeuTokenJWT2();

   if($meutoken->validarToken($autorization)==true){
            $payloadRecuperado=$meutoken->getPayload();
        if ($metodo == "GET") {
            $id_usuario = $vetor[2];
            
            $Usuario = new Usuario();
            $Usuario->setIdUsuario($id_usuario);
            $UsuarioSelecionado = $Usuario->readID();
            
            if ($UsuarioSelecionado) {
                header("HTTP/1.1 200 OK");
                echo json_encode([
                    "cod" => 200,
                    "msg" => "Usuario encontrado",
                    "usuario" => [
                        "id_usuario" => $UsuarioSelecionado->getIdUsuario(),
                        "nome_usuario" => $UsuarioSelecionado->getNomeUsuario(),
                        "email_usuario" => $UsuarioSelecionado->getEmailUsuario(),
                        "senha_usuario" =>$UsuarioSelecionado->getSenhaUsuario()
                    
                    ],
                ]);
            } else {
                header("HTTP/1.1 404 Not Found");
                echo json_encode([
                    "cod" => 404,
                    "msg" => "Usuario não encontrado"
                ]);
            }
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode([
                "cod" => 405,
                "msg" => "Método não permitido"
            ]);
        }
   }else{
    
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["mensagem" => "Erro"]);

   }
?>
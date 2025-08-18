<?php
// use Firebase\JWT\MeuTokenJWT2;
    require_once "modelo/Produto.php";

    /*
    require_once "modelo/MeuTokenJWT2.php";
    $headers=getallheaders();
    $autorization=$headers['Authorization'];
   $meutoken= new MeuTokenJWT2();
    
   if($meutoken->validarToken($autorization)==true){
   $payloadRecuperado=$meutoken->getPayload();
    
   */

    $Produto = new Produto();

    $Produtos_busca = $Produto->listarProdutos();

        header("Content-Type: application/json");
        if ($Produtos_busca) {
            header("HTTP/1.1 200 OK");

            echo json_encode([
                "cod" => 200,
                "msg" => "busca realizado com sucesso!!!",
                "Produtos" => [ 
                    "dados" => $Produtos_busca
                ],
            ]);

        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(["mensagem" => "Nenhum Produto encontrado."]);
        }

/*
    }else{
    
        header("HTTP/1.1 404 Not Found");
        echo json_encode(["mensagem" => "Token Invalido!!."]);
    
       }
*/

?>
<?php
require_once "modelo/Produto.php";

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === "DELETE") {
    $vetor = explode("/", $_SERVER['REQUEST_URI']);
    $barcode = $vetor[2];

    $Produto = new Produto();
    $Produto->setBarcode($barcode);
    
    if ($Produto->deletarProduto()) {
        header("HTTP/1.1 204 No Content");
        exit(); 
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode([
            "cod" => 500,
            "msg" => "Erro ao excluir Produto."
        ]);
        exit();
    }
} else {

    header("HTTP/1.1 405 Method Not Allowed");
    header("Allow: DELETE");
    echo json_encode([
        "cod" => 405,
        "msg" => "Método HTTP não permitido. Apenas o método DELETE é suportado para exclusão de Produto."
    ]);
    exit();
}
?>
<?php
require_once "modelo/Produto.php";

$jsonRecebidoBodyRequest = file_get_contents('php://input');
$obj = json_decode($jsonRecebidoBodyRequest);

if (!isset($obj->barcode) || !isset($obj->product_name)) {
    echo json_encode([
        "cod" => 400,
        "msg" => "Dados incompletos. Por favor, código de barras e nome do produto são obrigatórios."
    ]);
    exit();
}

$product_name = $obj->product_name;
$cod = $obj->barcode;
$ecoscore = $obj->ecoscore;
$nutriscore = $obj->nutriscore;

$product_name = strip_tags($product_name);
$cod = strip_tags($cod);
$ecoscore = strip_tags($ecoscore);
$nutriscore = strip_tags($nutriscore);

$Produto = new Produto();
$Produto->setBarcode($cod);
$Produto->setProductName($product_name);
$Produto->setEcoscore($ecoscore);
$Produto->setNutriscore($nutriscore);



if ($Produto->cadastrarProduto()) {
    echo json_encode([
        "cod" => 204,
        "msg" => "Cadastrado com sucesso!!!",
        "Produto" => $Produto
    ]);
} else {
    echo json_encode([
        "cod" => 500,
        "msg" => "ERRO ao cadastrar Produto"
    ]);
}

/*

{
  "barcode": "3017624010701",
  "product_name": "Nutella",
  "ecoscore": "C",
  "nutriscore": "E"
}

*/

?>


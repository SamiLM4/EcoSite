<?php
require_once ("modelo/Router.php");

$roteador = new Router();

/*
$roteador->post("/usuario/login", function () {
    require_once ("controle/usuario/usuarioLogin.php");
});

$roteador->post("/usuario", function () {
    require_once ("controle/usuario/usuarioCadastrar.php");
});


$roteador->get("/usuario/(\d+)", function ($pagina) {
    require_once ("controle/usuario/usuarioRead.php");
});

$roteador->get("/usuarioid/(\d+)", function ($id_usuario) {

    require_once ("controle/usuario/usuarioReadID.php");
});

$roteador->put("/usuario/(\d+)", function ($id_usuario) {
    require_once ("controle/usuario/usuarioUpdate.php");
});

$roteador->delete("/usuario/(\d+)", function ($id_prof) {
    require_once ("controle/usuario/usuarioDelete.php");
});
*/

$roteador->post("/produto", function () {
    require_once ("controle/produto/produtoCadastrar.php");
});
$roteador->get("/produto", function () {
    require_once ("controle/produto/produtoRead.php");
});

/*

$roteador->get("/produto/(\d+)", function ($id_produto) {
    require_once ("controle/produto/produto ReadID.php");
});


$roteador->put("/usuario/(\d+)", function ($id_usuario) {
    require_once ("controle/usuario/usuarioUpdate.php");
});

*/

$roteador->delete("/produto/(\d+)", function ($id_produto) {
    require_once ("controle/produto/produtoDelete.php");
});

$roteador->run();
?>
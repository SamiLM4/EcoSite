<?php
require_once "Banco.php";

class Produto {
    private $id;
    private $barcode;
    private $product_name;
    private $ecoscore;
    private $nutriscore;
    private $data_salvo;

    public function jsonSerialize()
    {
        $objetoResposta = new stdClass();
        $objetoResposta->id = $this->id;
        $objetoResposta->barcode = $this->barcode;
        $objetoResposta->product_name = $this->product_name;
        $objetoResposta->ecoscore = $this->ecoscore;
        $objetoResposta->nutriscore = $this->nutriscore;
        $objetoResposta->data_salvo = $this->data_salvo;
        return $objetoResposta;
    }

    // Cadastrar produto
    public function cadastrarProduto() {
        $meuBanco = new Banco();
        $conexao = $meuBanco->getConexao();

        $stmt = $conexao->prepare("INSERT INTO produtos (barcode, product_name, ecoscore, nutriscore) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("ssss", $this->barcode, $this->product_name, $this->ecoscore, $this->nutriscore);
        return $stmt->execute();
    }

    /*
    // Listar produtos (paginado)
    public function listarProdutos($pagina = 1) {
        $itempaginas = 10;
        $inicio = ($pagina - 1) * $itempaginas;
        $meuBanco = new Banco();
        $stm = $meuBanco->getConexao()->prepare("SELECT * FROM produtos ORDER BY data_salvo DESC LIMIT ?,?");
        $stm->bind_param("ii", $inicio, $itempaginas);
        $stm->execute();
        $executou = $stm->get_result();
        if (!$executou) {
            throw new Exception("Erro ao executar a consulta SQL");
        }
        return $executou->fetch_all(MYSQLI_ASSOC);
    }
    */

    // Listar produtos
    public function listarProdutos() {
        $meuBanco = new Banco();
        $stm = $meuBanco->getConexao()->prepare("SELECT * FROM produtos ORDER BY data_salvo");
        $stm->execute();
        $executou = $stm->get_result();
        if (!$executou) {
            throw new Exception("Erro ao executar a consulta SQL");
        }
        return $executou->fetch_all(MYSQLI_ASSOC);
    }

    // Buscar produto por ID
    public function buscarPorId($id) {
        $meuBanco = new Banco();
        $stm = $meuBanco->getConexao()->prepare("SELECT * FROM produtos WHERE id = ?");
        $stm->bind_param("i", $id);
        $stm->execute();
        $resultado = $stm->get_result();
        if ($resultado->num_rows === 0) {
            return null;
        }
        $linha = $resultado->fetch_object();
        $this->id = $linha->id;
        $this->barcode = $linha->barcode;
        $this->product_name = $linha->product_name;
        $this->ecoscore = $linha->ecoscore;
        $this->nutriscore = $linha->nutriscore;
        $this->data_salvo = $linha->data_salvo;
        return $this;
    }

    // Atualizar produto
    public function atualizarProduto() {
        $meuBanco = new Banco();
        $sql = "UPDATE produtos SET barcode=?, product_name=?, ecoscore=?, nutriscore=? WHERE id = ?";
        $stm = $meuBanco->getConexao()->prepare($sql);
        if ($stm === false) {
            return false;
        }
        $stm->bind_param("ssssi", $this->barcode, $this->product_name, $this->ecoscore, $this->nutriscore, $this->id);
        return $stm->execute();
    }
/*
    // Deletar produto (ID)
    public function deletarProduto() {
        $meuBanco = new Banco();
        $conexao = $meuBanco->getConexao();
        $SQL = "DELETE FROM produtos WHERE id = ?";
        if ($prepareSQL = $conexao->prepare($SQL)) {
            $prepareSQL->bind_param("i", $this->id);
            if ($prepareSQL->execute()) {
                $prepareSQL->close();
                return true;
            } else {
                echo "Erro na execução da consulta: " . $prepareSQL->error;
                return false;
            }
        } else {
            echo "Erro na preparação da consulta: " . $conexao->error;
            return false;
        }
    }
*/

    // Deletar produto (Barcode)
    public function deletarProduto() {
        $meuBanco = new Banco();
        $conexao = $meuBanco->getConexao();
        $SQL = "DELETE FROM produtos WHERE barcode = ?";
        if ($prepareSQL = $conexao->prepare($SQL)) {
            $prepareSQL->bind_param("i", $this->barcode);
            if ($prepareSQL->execute()) {
                $prepareSQL->close();
                return true;
            } else {
                echo "Erro na execução da consulta: " . $prepareSQL->error;
                return false;
            }
        } else {
            echo "Erro na preparação da consulta: " . $conexao->error;
            return false;
        }
    }

    // Getters e Setters
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getBarcode() {
        return $this->barcode;
    }
    public function setBarcode($barcode) {
        $this->barcode = $barcode;
    }

    public function getProductName() {
        return $this->product_name;
    }
    public function setProductName($product_name) {
        $this->product_name = $product_name;
    }

    public function getEcoscore() {
        return $this->ecoscore;
    }
    public function setEcoscore($ecoscore) {
        $this->ecoscore = $ecoscore;
    }

    public function getNutriscore() {
        return $this->nutriscore;
    }
    public function setNutriscore($nutriscore) {
        $this->nutriscore = $nutriscore;
    }

    public function getDataSalvo() {
        return $this->data_salvo;
    }
    public function setDataSalvo($data_salvo) {
        $this->data_salvo = $data_salvo;
    }
}
?>

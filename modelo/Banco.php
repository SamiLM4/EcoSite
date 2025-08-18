<?php

class Banco {
    private $host = "127.0.0.1";
    private $usuario = "root";
    private $senha = "";
    private $banco = "ecoconsumo";
    private $porta = "3306";
    private $con = null;

    public function conectar() {
        $this->con = new mysqli($this->host, $this->usuario, $this->senha, $this->banco, $this->porta);

        if ($this->con->connect_error) {
            $arrayResposta['status'] = "erro";
            $arrayResposta['cod'] = "1";
            $arrayResposta['msg'] = "Erro ao estabelecer conexão: " . $this->con->connect_error;
            echo json_encode($arrayResposta);
            die();
        }
    }

    public function getConexao() {
        if ($this->con == null) {
            $this->conectar();
        }
        return $this->con;
    }

    public function setConexao($conexao) {
        $this->con = $conexao;
        return $this->con;
    }
}
?>

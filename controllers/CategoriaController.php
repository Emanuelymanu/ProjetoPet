<?php
require "../config/Conexao.php";
require "../models/CategoriaModel.php";

Class CategoriaController{
    private $categoria;

    public function __construct()
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();
        $this->categoria = new CategoriaModel($pdo);
    }

    
        public function salvar() {
            $nome = trim($_POST["nome"] ?? NULL);
            $ativo = trim($_POST["ativo"] ?? NULL);

            if (empty($nome)) {
                echo "<script>mensagem('Preencha o nome','error','')</script>";
                exit;
            } else if (empty($ativo)) {
                echo "<script>mensagem('Selecione o ativo','error','')</script>";
                exit;
            }

            $msg = $this->categoria->cadastrarSalvar($_POST);

            if ($msg == 1) {
                echo "<script>mensagem('Registro Salvo','ok','categoria/listar');</script>";
                exit;
            } else {
                echo "<script>mensagem('Erro ao Salvar','error','')</script>";
                exit;
            }
        }

}
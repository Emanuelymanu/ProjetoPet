<?php
if (!isset($_SESSION)) {
    session_start();
}
require "../config/Conexao.php";
require "../models/CategoriaModel.php";

class CategoriaController
{
    private $categoria;

    public function __construct()
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();
        $this->categoria = new CategoriaModel($pdo);
    }

  
    public function salvar()
    {
        $nome = trim($_POST["nome"] ?? NULL);
        $ativo = trim($_POST["ativo"] ?? NULL);

        if (empty($nome)) {
            echo "<script>mensagem('Preencha o nome','error','')</script>";
            exit;
        } else if (empty($ativo)) {
            echo "<script>mensagem('Selecione o ativo','error','')</script>";
            exit;
        }

        $msg = $this->categoria->salvar($_POST);

        if ($msg == 1) {
            echo "<script>mensagem('Registro Salvo','ok','');</script>";
            exit;
        } else {
            echo "<script>mensagem('Erro ao Salvar','error','')</script>";
            exit;
        }
    }

    public function listar()
    {
        return $this->categoria->listarCategorias();
    }

    public function excluir()
    {
        $id = trim($_GET["id"] ?? NULL);
        if (empty($id)) {
            echo "<script>mensagem('ID inválido','error','');</script>";
            exit;
        }

        if ($this->categoria->excluirCategoria($id)) {
            echo "<script>mensagem('Registro excluído','ok','');</script>";
        } else {
            echo "<script>mensagem('Erro ao excluir registro','error','');</script>";
        }
        exit;
    }

}
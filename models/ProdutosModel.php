<?php

class ProdutoModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function salvar($dados)
    {
        if (empty($dados["id"])) {
            $sql = "INSERT INTO produto (nome, id_categoria, descricao, imagens, valor, destaque, ativo) 
                VALUES (:nome, :id_categoria, :descricao, :imagens, :valor, :destaque, :ativo)";
            $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(":nome", $dados["nome"]);
            $consulta->bindParam(":id_categoria", $dados["id_categoria"]);
            $consulta->bindParam(" :descricao", $dados["descricao"]);
            $consulta->bindParam(":imagens", $dados["imagens"]);
            $consulta->bindParam(":valor", $dados["valor"]);
            $consulta->bindParam(":destaque", $dados["destaque"]);
            $consulta->bindParam(":ativo", $dados["ativo"]);
        } else {
            $sql = "UPDATE produto set nome = :nome, id_categoria = :id_categoria,
                   descricao = :descricao, imagens = :imagens, valor = :valor,
                   destaque = :destaque, ativo = :ativo where id = :id";
            $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(":id", $dados["id"]);
            $consulta->bindParam(":nome", $dados["nome"]);
            $consulta->bindParam(":id_categoria", $dados["id_categoria"]);
            $consulta->bindParam(":descricao", $dados["descricao"]);
            $consulta->bindParam(":imagens", $dados["imagens"]);
            $consulta->bindParam(":valor", $dados["valor"]);
            $consulta->bindParam(":destaque", $dados["destaque"]);
            $consulta->bindParam(":ativo", $dados["ativo"]);

        }
        return $consulta->execute();
    }

    public function listarProdutos()
    {
        $sql = "SELECT * FROM produto";
        $consulta = $this->pdo->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public function editarProdutos($id)
    {
        $sql = "SELECT * FROM produto WHERE id = :id";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    public function deletarProdutos($id)
    {
        $sql = "DELETE FROM produto WHERE id = :id";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        return $consulta->execute();
    }
}
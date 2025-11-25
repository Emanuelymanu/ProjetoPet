<?php

class CategoriaModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function salvar($dados)
    {
        if (empty($dados["id_categoria"])) {
            $sql = "INSERT INTO categoria (nome_categoria, ativo) VALUES (:nome_categoria, :ativo)";
            $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(":nome_categoria", $dados["nome_categoria"]);
            $consulta->bindParam(":ativo", $dados["ativo"]);

        } else {
            $sql = "UPDATE categoria SET nome = :nome, ativo = :ativo WHERE id = :id";
            $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(":id", $dados["id_categoria"]);
            $consulta->bindParam(":nome", $dados["nome"]);
            $consulta->bindParam(":ativo", $dados["ativo"]);

        }
        return $consulta->execute();
    }

    public function excluirCategoria($id)
    {
        $sql = "DELETE FROM categoria WHERE id_categoria = :id_categoria";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id_categoria", $id);
        return $consulta->execute();
    }

    public function listarCategorias()
    {
        $sql = "SELECT id_categoria, nome_categoria, ativo FROM categoria ORDER BY nome_categoria ASC";
        $consulta = $this->pdo->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }
}
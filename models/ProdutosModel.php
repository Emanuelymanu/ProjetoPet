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
            $sql = "INSERT INTO produto (nome_produto, id_categoria, descricao, imagem, valor, destaque, ativo) 
                VALUES (:nome_produto, :id_categoria, :descricao, :imagem, :valor, :destaque, :ativo)";
            $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(":nome_produto", $dados["nome_produto"]);
            $consulta->bindParam(":id_categoria", $dados["id_categoria"]);
            $consulta->bindParam(":descricao", $dados["descricao"]);
            $consulta->bindParam(":imagem", $dados["imagens"]);
            $consulta->bindParam(":valor", $dados["valor"]);
            $consulta->bindParam(":destaque", $dados["destaque"]);
            $consulta->bindParam(":ativo", $dados["ativo"]);
        } else {

            $sql = "UPDATE produto SET nome = :nome_produto, id_categoria = :id_categoria, descricao = :descricao, valor = :valor, destaque = :destaque, ativo = :ativo";

            if (!empty($dados["imagens"])) {
                $sql .= ", imagem = :imagem";
            }

            $sql .= " WHERE id_produto = :id_produto";

            $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(":id", $dados["id_produto"]);
            $consulta->bindParam(":nome", $dados["nome_produto"]);
            $consulta->bindParam(":id_categoria", $dados["id_categoria"]);
            $consulta->bindParam(":descricao", $dados["descricao"]);
            if (!empty($dados["imagens"])) {
                $consulta->bindParam(":imagem", $dados["imagens"]);
            }
            $consulta->bindParam(":valor", $dados["valor"]);
            $consulta->bindParam(":destaque", $dados["destaque"]);
            $consulta->bindParam(":ativo", $dados["ativo"]);

        }
        return $consulta->execute();
    }

    public function listarProdutos()
    {
        
        $sql = "SELECT p.*, c.nome_categoria AS nome_categoria 
           FROM produto p 
           LEFT JOIN categoria c ON p.id_categoria = c.id_categoria 
           ORDER BY p.id_categoria ASC";
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

    public function excluirProduto($id)
    {
        $sql = "DELETE FROM produto WHERE id = :id";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        return $consulta->execute();
    }
}
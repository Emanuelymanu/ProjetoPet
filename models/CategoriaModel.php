<?php

Class CategoriaModel{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function cadastrarSalvar($dados){
        if(empty($dados["id"])){
            $sql = "INSERT INTO categoria (nome, ativo) VALUES (:nome, :ativo)";
            $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(":nome", $dados["nome"]);
            $consulta->bindParam(":ativo", $dados["ativo"]);
            return $consulta->execute();
        }else{
            $sql = "UPDATE categoria SET nome = :nome, ativo = :ativo WHERE id = :id";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id", $dados["id"]);
        $consulta->bindParam(":nome", $dados["nome"]);
        $consulta->bindParam(":ativo", $dados["ativo"]);
        return $consulta->execute();
        }
    }

    public function excluirCategoria($id){
        $sql = "DELETE FROM categoria WHERE id = :id";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        return $consulta->execute();
    }

    public function listarCategorias(){
        $sql = "SELECT id, nome, ativo FROM categoria ORDER BY nome ASC";
        $consulta = $this->pdo->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }
}
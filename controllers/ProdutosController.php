<?php

require "../config/Conexao.php";
require "../models/ProdutosModel.php";

class ProdutosController{
    private $produtoModel;

    public function __construct(){
        $db = new Conexao();
        $pdo = $db->conectar();
        $this->produtoModel = new ProdutosModel($pdo);
    }

    public function salvar(){
        require __DIR__ ."/../views/produtos/salvar.php";
    }

    public function listar(){}

    public function editar($id){}

    public function deletar($id){}
}
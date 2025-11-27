<?php

require "../config/Conexao.php";
require "../models/EstoqueModel";

class EstoqueController
{
    private $estoqueModel;

    public function __construct()
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();

        $this->estoqueModel = new EstoqueModel($pdo);
    }



}
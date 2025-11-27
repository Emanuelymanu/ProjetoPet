<?php

require "../config/Conexao.php";
require "../models/PedidoModel.php";

class PedidoController
{
    private $pedidoModel;

    public function __construct()
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();

        $this->pedidoModel = new PedidoModel($pdo);
    }

    public function listarPedidos($status = null)
{
   
    return $this->pedidoModel->listarPedidos($status);
}
}

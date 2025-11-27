<?php
require "../config/Conexao.php";
require_once "../models/PedidoModel.php";

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
        try {
            return $this->pedidoModel->listarPedidos($status);
        } catch (Exception $e) {
            error_log("Erro ao listar pedidos: " . $e->getMessage());
            return [];
        }
    }

    public function filtrarPedidos()
    {
        $status = $_POST['status'] ?? null;
        
        if (empty($status)) {
            $pedidos = $this->listarPedidos();
        } else {
            $pedidos = $this->listarPedidos($status);
        }
        
        return $pedidos;
    }

    public function obterDetalhesPedido($id_pedido)
    {
        try {
            return $this->pedidoModel->listarItensPorPedido($id_pedido);
        } catch (Exception $e) {
            error_log("Erro ao obter detalhes do pedido: " . $e->getMessage());
            return [];
        }
    }

    public function atualizarStatus($id_pedido, $novo_status)
    {
        try {
            return $this->pedidoModel->atualizarStatusPedido($id_pedido, $novo_status);
        } catch (Exception $e) {
            error_log("Erro ao atualizar status: " . $e->getMessage());
            return false;
        }
    }
}
?>
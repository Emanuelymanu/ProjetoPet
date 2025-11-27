<?php

class PedidoModel
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

    }

    public function listarPedidosEnviados()
    {
        $sql = "SELECT 
                ip.id_item, 
                ip.quantidade,
                ip.preco_unitario,
                p.nome_produto,
                p.imagem
            FROM item_pedido ip
            JOIN produto p ON ip.id_produto = p.id_produto
           WHERE p.status = :status_enviado
           AND ip.id_pedido = :id_pedido
            ORDER BY p.data_pedido DESC";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id_pedido", $_SESSION['id_pedido']);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);

    }

    public function listarPedidosEntregues()
    {
        $sql = "SELECT 
                ip.id_item, 
                ip.quantidade,
                ip.preco_unitario,
                p.nome_produto,
                p.imagem
            FROM item_pedido ip
            JOIN produto p ON ip.id_produto = p.id_produto
           WHERE p.status = :status_entregue
           AND ip.id_pedido = :id_pedido
            ORDER BY p.data_pedido DESC";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id_pedido", $_SESSION['id_pedido']);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);

    }

    public function atualizarStatusPedido($id_pedido, $novo_status)
    {
        $sql = "UPDATE pedido SET status = :novo_status WHERE id_pedido = :id_pedido";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":novo_status", $novo_status);
        $consulta->bindParam(":id_pedido", $id_pedido);
        return $consulta->execute();
    }
}
<?php
class PedidoModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarPedidos($status = null)
    {
        $sql = "SELECT p.id_pedido, u.nome AS nome_usuario, p.data_pedido, p.status 
                FROM pedido p
                JOIN usuario u ON p.id_usuario = u.id_usuario";
        
        $bindParams = [];

        if (!empty($status)) {
            $sql .= " WHERE p.status = :status";
            $bindParams[':status'] = $status;
        }
        
        $sql .= " ORDER BY p.data_pedido DESC";

        $consulta = $this->pdo->prepare($sql);
        
        foreach ($bindParams as $key => $value) {
            $consulta->bindValue($key, $value);
        }
        
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarItensPorPedido($id_pedido) 
    {
        $sql = "SELECT 
                    ip.id_item, 
                    ip.quantidade,
                    ip.preco_unitario,
                    p.nome_produto,
                    p.imagem
                FROM item_pedido ip
                JOIN produto p ON ip.id_produto = p.id_produto
                WHERE ip.id_pedido = :id_pedido"; 
                
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id_pedido", $id_pedido); 
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
?>
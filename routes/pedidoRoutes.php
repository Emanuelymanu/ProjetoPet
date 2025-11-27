<?php
require_once "../controllers/PedidoController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pedidoController = new PedidoController();
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'filtrar':
        $dadosPedidos = $pedidoController->filtrarPedidos();
        $_SESSION['pedidos_filtrados'] = $dadosPedidos;
        $_SESSION['status_filtro'] = $_POST['status'] ?? '';
        header('Location: ../views/pedidos/index.php');
        exit;
        
    case 'detalhes':
        $id_pedido = $_GET['id_pedido'] ?? null;
        if ($id_pedido) {
            $detalhes = $pedidoController->obterDetalhesPedido($id_pedido);
            echo json_encode(['success' => true, 'detalhes' => $detalhes]);
        } else {
            echo json_encode(['success' => false, 'message' => 'ID do pedido não informado']);
        }
        exit;
        
    case 'atualizar_status':
        $id_pedido = $_POST['id_pedido'] ?? null;
        $novo_status = $_POST['novo_status'] ?? null;
        
        if ($id_pedido && $novo_status) {
            $resultado = $pedidoController->atualizarStatus($id_pedido, $novo_status);
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar status']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
        }
        exit;
        
    default:
      
        header('Location: ../views/pedidos/index.php');
        exit;
}
?>
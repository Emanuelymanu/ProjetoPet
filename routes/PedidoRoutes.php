<?php
// routes/pedidoRoutes.php
// Dispatcher para pedidos

require_once __DIR__ . '/../controllers/PedidoController.php';

$ctrl = new PedidoController();

$action = strtolower($_REQUEST['action'] ?? $_REQUEST['acao'] ?? '');

switch ($action) {
    case 'finalizar':
    case 'fechar':
        $ctrl->finalizar();
        break;

    case 'listar':
        $ctrl->listar();
        break;

    case 'detalhes':
    case 'detalhe':
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : null;
        $ctrl->detalhes($id);
        break;

    default:
        // se acessado sem action, mostra instrução simples em JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json; charset=utf-8', true, 400);
            echo json_encode(['sucesso' => false, 'erro' => 'Ação inválida']);
            exit;
        } else {
            header('Location: /ProjetoPet-main/public/index.php');
            exit;
        }
}
?>
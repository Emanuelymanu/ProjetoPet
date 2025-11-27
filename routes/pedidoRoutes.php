<?php
require_once __DIR__ . '/../controllers/PedidoController.php';
$pedidoController = new PedidoController();

if (isset($_POST["action"]) && $_POST["action"] == "filtrar") {
    $status = !empty($_POST['status']) ? $_POST['status'] : null;
    $pedidos = $pedidoController->listarPedidos($status);
  
    
}
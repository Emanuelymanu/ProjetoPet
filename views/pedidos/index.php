

<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../../controllers/PedidoController.php';
$pedidoController = new PedidoController();

$status = null; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'filtrar') {
    
    $status = !empty($_POST['status']) ? $_POST['status'] : null;
} 

$dadosPedidos = $pedidoController->listarPedidos($status);

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="bi bi-box-seam" style="font-size: 4rem;"></i>
                    <h2 class="mt-3 mb-0">Gerenciamento de Pedidos</h2>
                </div>

                <div class="card-body p-4 p-md-5">

                    <h3 class="mb-4 border-bottom pb-2"><i class="bi bi-funnel"></i> Filtro de Pedidos</h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <form method="POST" action="nome_da_sua_pagina.php"> 
                                <div class="input-group">
                                    <select name="status" class="form-select">
                                        <option value=""> Todos os Status </option>
                                        
                                        <option value="pendente" <?= ($statusFiltro == 'pendente') ? 'selected' : '' ?>>Pendente</option>
                                        <option value="enviado" <?= ($statusFiltro == 'enviado') ? 'selected' : '' ?>>Enviado</option>
                                        <option value="cancelado" <?= ($statusFiltro == 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
                                    </select>
                                    <input type="hidden" name="action" value="filtrar">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <hr class="my-5">

                    <h3 class="mb-4 border-bottom pb-2"><i class="bi bi-list-task"></i> Lista de Pedidos</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>ID Pedido</th>
                                    <th>Cliente</th>
                                    <th>Data do Pedido</th>
                                    <th>Status Atual</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dadosPedidos)): ?>
                                    <?php foreach ($dadosPedidos as $pedido): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($pedido->id_pedido) ?></td>
                                            <td><?= htmlspecialchars($pedido->nome_usuario) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($pedido->data_pedido)) ?></td>
                                            <td>
                                                <span class="badge bg-<?= getStatusBadgeColor($pedido->status) ?>">
                                                    <?= ucwords(htmlspecialchars($pedido->status)) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-info btn-sm text-white" 
                                                        onclick="verDetalhes(<?= $pedido->id_pedido ?>)" title="Ver Detalhes e Itens">
                                                    <i class="bi bi-eye"></i> Detalhes
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" 
                                                        onclick="mudarStatus(<?= $pedido->id_pedido ?>)" title="Mudar Status">
                                                    <i class="bi bi-arrow-right-circle"></i> Status
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum pedido encontrado com o filtro atual.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Função auxiliar PHP para cores do status (pode ser colocada no topo com o bloco PHP)
function getStatusBadgeColor($status) {
    switch (strtolower($status)) {
        case 'enviado':
            return 'primary';
        case 'pendente':
            return 'warning';
        case 'cancelado':
            return 'danger';
        case 'entregue':
            return 'success';
        default:
            return 'secondary';
    }
}
?>

<script>
    // Funções de exemplo para os botões de ação (Você precisará implementar as janelas de diálogo/modais)
    
    function verDetalhes(id) {
        // Implementar AJAX para buscar itens do pedido ou redirecionar para uma página de detalhes
        alert("Buscando detalhes do Pedido #" + id);
        // Ex: window.location.href = 'detalhes_pedido.php?id=' + id;
    }

    function mudarStatus(id) {
        // Implementar modal ou prompt para selecionar o novo status
        alert("Abrindo seletor de status para o Pedido #" + id);
    }
</script>
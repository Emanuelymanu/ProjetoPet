<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../../controllers/PedidoController.php";

$pedidoController = new PedidoController();


$status = $_SESSION['status_filtro'] ?? '';
if (isset($_SESSION['pedidos_filtrados'])) {
    $dadosPedidos = $_SESSION['pedidos_filtrados'];
    unset($_SESSION['pedidos_filtrados']); 
} else {
    $dadosPedidos = $pedidoController->listarPedidos($status);
}
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
                            <form method="POST" action="../routes/pedidoRoutes.php"> 
                                <div class="input-group">
                                    <select name="status" class="form-select">
                                        <option value=""> Todos os Status </option>
                                        <option value="pendente" <?= ($status == 'pendente') ? 'selected' : '' ?>>Pendente</option>
                                        <option value="enviado" <?= ($status == 'enviado') ? 'selected' : '' ?>>Enviado</option>
                                        <option value="cancelado" <?= ($status == 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
                                        <option value="entregue" <?= ($status == 'entregue') ? 'selected' : '' ?>>Entregue</option>
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


<div class="modal fade" id="modalDetalhes" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Pedido #<span id="pedidoId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalhesPedido">
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Status do Pedido #<span id="pedidoStatusId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formStatus">
                    <input type="hidden" name="id_pedido" id="idPedidoStatus">
                    <input type="hidden" name="action" value="atualizar_status">
                    <div class="mb-3">
                        <label for="novo_status" class="form-label">Novo Status:</label>
                        <select name="novo_status" id="novo_status" class="form-select">
                            <option value="pendente">Pendente</option>
                            <option value="enviado">Enviado</option>
                            <option value="entregue">Entregue</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar Status</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function verDetalhes(id) {
    $('#pedidoId').text(id);
    
    $.ajax({
        url: '../routes/pedidoRoutes.php',
        type: 'GET',
        data: {
            action: 'detalhes',
            id_pedido: id
        },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                let html = '<h6>Itens do Pedido:</h6>';
                if (data.detalhes.length > 0) {
                    html += '<table class="table table-sm">';
                    html += '<thead><tr><th>Produto</th><th>Qtd</th><th>Preço Unit.</th><th>Total</th></tr></thead>';
                    html += '<tbody>';
                    data.detalhes.forEach(item => {
                        const total = item.quantidade * item.preco_unitario;
                        html += `<tr>
                            <td>${item.nome_produto}</td>
                            <td>${item.quantidade}</td>
                            <td>R$ ${parseFloat(item.preco_unitario).toFixed(2)}</td>
                            <td>R$ ${total.toFixed(2)}</td>
                        </tr>`;
                    });
                    html += '</tbody></table>';
                } else {
                    html += '<p>Nenhum item encontrado para este pedido.</p>';
                }
                $('#detalhesPedido').html(html);
            } else {
                $('#detalhesPedido').html('<p>Erro ao carregar detalhes: ' + data.message + '</p>');
            }
            new bootstrap.Modal(document.getElementById('modalDetalhes')).show();
        },
        error: function() {
            $('#detalhesPedido').html('<p>Erro ao carregar detalhes do pedido.</p>');
            new bootstrap.Modal(document.getElementById('modalDetalhes')).show();
        }
    });
}

function mudarStatus(id) {
    $('#pedidoStatusId').text(id);
    $('#idPedidoStatus').val(id);
    
    new bootstrap.Modal(document.getElementById('modalStatus')).show();
}


$('#formStatus').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: '../routes/pedidoRoutes.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            const data = JSON.parse(response);
            alert(data.message);
            if (data.success) {
                location.reload();
            }
        }
    });
});
</script>


<?php 
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
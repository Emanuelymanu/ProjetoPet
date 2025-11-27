<?php
// estoqueView.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../controllers/EstoqueController.php';
$estoqueController = new EstoqueController();
$dadosProdutos = $estoqueController->listarProdutos();

function getQuantidadeBadgeColor($quantidade)
{
    if ($quantidade <= 5) {
        return 'danger';
    } elseif ($quantidade <= 20) {
        return 'warning';
    } else {
        return 'success';
    }
}



?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="bi bi-boxes" style="font-size: 4rem;"></i>
                    <h2 class="mt-3 mb-0">Gerenciamento de Estoque</h2>
                </div>

                <div class="card-body p-4 p-md-5">

                    <div class="d-flex justify-content-between mb-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroMovimentacao" title="Registrar Nova Movimentação de Estoque">
                            <i class="bi bi-plus-circle"></i> Nova Movimentação
                        </button>


                    </div>

                    <h3 class="mb-4 border-bottom pb-2"><i class="bi bi-list-task"></i> Saldo Atual por Produto</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome do produto</th>
                                    <th>Preço Unitário</th>
                                    <th class="text-center">Quantidade Atual</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dadosProdutos)): ?>
                                    <?php foreach ($dadosProdutos as $produto): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($produto->id_produto) ?></td>
                                            <td><?= htmlspecialchars($produto->nome_produto) ?></td>
                                            <td>R$ <?= number_format($produto->preco, 2, ',', '.') ?></td>
                                            <td class="text-center">
                                                <span
                                                    class="badge rounded-pill bg-<?= getQuantidadeBadgeColor($produto->quantidade_estoque) ?> text-white px-3 py-2 fs-6">
                                                    <?= htmlspecialchars($produto->quantidade_estoque) ?> un.
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-success me-1"
                                                    onclick="abrirModalMovimentacao('entrada', <?= $produto->id_produto ?>, '<?= htmlspecialchars($produto->nome_produto) ?>')"
                                                    title="Registrar Nova Entrada (Compra)">
                                                    <i class="bi bi-arrow-up-circle"></i> Entrada
                                                </button>

                                                <button type="button" class="btn btn-sm btn-danger me-1"
                                                    onclick="abrirModalMovimentacao('saida', <?= $produto->id_produto ?>, '<?= htmlspecialchars($produto->nome_produto) ?>')"
                                                    title="Dar Baixa (Venda/Perda)">
                                                    <i class="bi bi-arrow-down-circle"></i> Saída
                                                </button>

                                                <button type="button" class="btn btn-sm btn-info text-white"
                                                    onclick="editarProduto(<?= $produto->id_produto ?>)"
                                                    title="Editar Nome, Preço ou Outros Detalhes">
                                                    <i class="bi bi-pencil-square"></i> Editar
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum produto cadastrado no estoque.</td>
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

<div class="modal fade" id="modalCadastroMovimentacao" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabel"><i class="bi bi-arrow-left-right"></i> Registrar
                    Movimentação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMovimentacao" method="POST" action="/projetopet/routes/estoqueRoutes.php">
                <div class="modal-body">
                    <input type="hidden" name="action" id="actionMovimentacao" value="salvar_movimentacao">
                    <input type="hidden" name="id_movimentacao" id="id_movimentacao" value="">

                    <div class="mb-3">
                        <label for="tipo_movimentacao" class="form-label">Tipo de Movimentação</label>
                        <select class="form-select" id="tipo_movimentacao" name="status" required>
                            <option value="">Selecione...</option>
                            <option value="entrada">Entrada (Compra/Inventário)</option>
                            <option value="saida">Saída (Venda/Perda)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_produto" class="form-label">Produto</label>
                        <select class="form-select" id="id_produto" name="id_produto" required>
                            <option value="">Selecione o Produto</option>
                            <?php
                            if (!empty($dadosProdutos) && is_iterable($dadosProdutos)) {
                                foreach ($dadosProdutos as $produto) {
                                    $id = htmlspecialchars($produto->id_produto, ENT_QUOTES);
                                    $nome = htmlspecialchars($produto->nome_produto, ENT_QUOTES);
                                    echo "<option value='{$id}'>{$nome}</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Nenhum produto cadastrado</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade</label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="data_movimentacao" class="form-label">Data e Hora da Movimentação</label>
                        <input type="datetime-local" class="form-control" id="data_movimentacao"
                            name="data_movimentacao" value="<?= date('Y-m-d\TH:i') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="observacao" class="form-label">Observação (Opcional)</label>
                        <textarea class="form-control" id="observacao" name="observacao" rows="2"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Movimentação</button>
                </div>
            </form>
        </div>
    </div>
</div>
<<script>

    const searchInput = document.getElementById("search");
    const tabelaEstoque = document.querySelector("#tabelaEstoque tbody");

    if (searchInput && tabelaEstoque) {
    searchInput.addEventListener("keyup", function () {
    let texto = searchInput.value.toLowerCase();
    let linhas = tabelaEstoque.getElementsByTagName("tr");

    for (let i = 0; i < linhas.length; i++) { let colNome=linhas[i].getElementsByTagName("td")[1]; if (colNome) { let
        nome=colNome.textContent.toLowerCase(); linhas[i].style.display=nome.indexOf(texto)> -1 ? "" : "none";
        }
        }
        });
        }



        function abrirModalMovimentacao(tipo, id_produto, nome_produto) {
        // Resetar o formulário ao abrir o modal para nova movimentação
        document.getElementById('formMovimentacao').reset();
        document.getElementById('id_movimentacao').value = '';
        document.getElementById('actionMovimentacao').value = 'salvar_movimentacao';
        document.getElementById('id_produto').value = id_produto;
        document.getElementById('tipo_movimentacao').value = tipo;
        document.getElementById('quantidade').value = '';
        document.getElementById('data_movimentacao').value = '';
        document.getElementById('observacao').value = '';
        const modalTitle = document.getElementById('modalLabel');
        modalTitle.textContent = tipo === 'entrada'
        ? `Registrar ENTRADA para ${nome_produto}`
        : `Registrar SAÍDA para ${nome_produto}`;
        const modalElement = new bootstrap.Modal(document.getElementById('modalCadastroMovimentacao'));
        modalElement.show();
        }


        function abrirModalCadastro() {

        alert("Abrindo modal de Cadastro de Produto.");
        }


        function verHistoricoGeral() {
        alert("Redirecionando para o histórico geral de movimentações.");
        }
        function editarProduto(id_movimentacao) {
        
        var mov = null;
        if (typeof movimentacoes !== 'undefined') {
        mov = movimentacoes.find(m => m.id_movimentacao == id_movimentacao);
        }
        if (mov) {
        document.getElementById('id_movimentacao').value = mov.id_movimentacao;
        document.getElementById('id_produto').value = mov.id_produto;
        document.getElementById('tipo_movimentacao').value = mov.tipo_movimentacao;
        document.getElementById('quantidade').value = mov.quantidade;
        document.getElementById('data_movimentacao').value = mov.data_movimentacao.replace(' ', 'T');
        document.getElementById('observacao').value = mov.observacao;
        document.getElementById('actionMovimentacao').value = 'editar_movimentacao';
        document.getElementById('modalLabel').textContent = 'Editar Movimentação';
        const modalElement = new bootstrap.Modal(document.getElementById('modalCadastroMovimentacao'));
        modalElement.show();
        } else {
        alert('Movimentação não encontrada para edição.');
        }
        }

        
        function abrirModalMovimentacao(tipo, id_produto, nome_produto) {
        document.getElementById('id_movimentacao').value = '';
        document.getElementById('actionMovimentacao').value = 'salvar_movimentacao';
        const modalTitle = document.getElementById('modalLabel');
        modalTitle.textContent = tipo === 'entrada'
        ? `Registrar ENTRADA para ${nome_produto}`
        : `Registrar SAÍDA para ${nome_produto}`;
        document.getElementById('id_produto').value = id_produto;
        document.getElementById('tipo_movimentacao').value = tipo;
        document.getElementById('quantidade').value = '';
        document.getElementById('data_movimentacao').value = '';
        document.getElementById('observacao').value = '';
        const modalElement = new bootstrap.Modal(document.getElementById('modalCadastroMovimentacao'));
        modalElement.show();
        }
        </script>
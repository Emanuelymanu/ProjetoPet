<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclui o controller para buscar os dados
require_once '../controllers/CategoriaController.php';
$categoriaController = new CategoriaController();
$dadosCategoria = $categoriaController->listar();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="bi bi-list-task" style="font-size: 4rem;"></i>
                    <h2 class="mt-3 mb-0">Gerenciamento de Categorias</h2>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Formulário de Cadastro/Edição -->
                    <h3 class="mb-4 border-bottom pb-2">Cadastro</h3>
                    <form method="POST" action="../routes/categoriaRoutes.php" id="form-categoria" data-parsley-validate>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="action" value="salvar">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label fw-bold">Nome da Categoria</label>
                                <input type="text" name="nome" id="nome" class="form-control" required
                                    data-parsley-required-message="Preencha o nome da categoria.">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ativo" class="form-label fw-bold">Status</label>
                                <select name="ativo" id="ativo" class="form-select" required
                                    data-parsley-required-message="Selecione o status.">
                                    <option value="">Selecione...</option>
                                    <option value="S">Ativo</option>
                                    <option value="N">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-outline-secondary" onclick="limparFormulario()">
                                <i class="bi bi-plus-circle"></i> Novo Cadastro
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg"></i> Salvar Categoria
                            </button>
                        </div>
                    </form>

                    <hr class="my-5">

                    <!-- Tabela de Listagem -->
                    <h3 class="mb-4 border-bottom pb-2">Categorias Cadastradas</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome da Categoria</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dadosCategoria as $categoria): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($categoria->id) ?></td>
                                        <td><?= htmlspecialchars($categoria->nome) ?></td>
                                        <td>
                                            <?php if ($categoria->ativo == 'S'): ?>
                                                <span class="badge bg-success">Ativo</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inativo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm" title="Editar"
                                                onclick="editarCategoria(<?= htmlspecialchars(json_encode($categoria), ENT_QUOTES, 'UTF-8') ?>)">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="javascript:excluir(<?= $categoria->id ?>)" class="btn btn-danger btn-sm" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editarCategoria(categoria) {
        document.getElementById('id').value = categoria.id;
        document.getElementById('nome').value = categoria.nome;
        document.getElementById('ativo').value = categoria.ativo;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function limparFormulario() {
        document.getElementById('form-categoria').reset();
        document.getElementById('id').value = '';
    }

    function excluir(id) {
        Swal.fire({
            title: "Deseja realmente excluir esta categoria?",
            text: "Esta ação não pode ser desfeita!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: "Sim, excluir!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = `../routes/categoriaRoutes.php?action=excluir&id=${id}`;
            }
        });
    }
</script>
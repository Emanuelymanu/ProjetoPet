<?php
require_once __DIR__ . '/../../controllers/CategoriaController.php';
require_once __DIR__ . '/../../controllers/ProdutoController.php';


$categoriaController = new CategoriaController();
$produtoController = new ProdutoController();


$dadosCategoria = $categoriaController->listar();
$dadosProdutos = $produtoController->listar();
?>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="bi bi-box-seam" style="font-size: 4rem;"></i>
                    <h2 class="mt-3 mb-0">Gerenciamento de Produtos</h2>
                </div>

                <div class="card-body p-4 p-md-5">
                    <h3 class="mb-4 border-bottom pb-2">Cadastro de Produto</h3>
                    <form action="../routes/produtoRoutes.php" method="POST" data-parsley-validate
                        enctype="multipart/form-data" name="formproduto" id="form-produto">
                        <input type="hidden" name="id_produto" id="id_produto">
                        <input type="hidden" name="action" value="salvar">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nome" class="form-label fw-bold">Nome do Produto</label>
                                <input type="text" name="nome_produto" id="nome_produto" class="form-control" required
                                    data-parsley-required-message="Preencha o nome do produto.">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="id_categoria" class="form-label fw-bold">Categoria</label>
                                <select name="id_categoria" id="id_categoria" required class="form-select"
                                    data-parsley-required-message="Selecione uma categoria.">
                                    <option value="">Selecione...</option>
                                    <?php
                                    if (!empty($dadosCategoria) && is_iterable($dadosCategoria)) {
                                        foreach ($dadosCategoria as $dados) {
                                            $id = htmlspecialchars($dados->id_categoria ?? $dados['id_categoria'], ENT_QUOTES);
                                            $nome = htmlspecialchars($dados->nome_categoria ?? $dados['nome_categoria'], ENT_QUOTES);
                                            echo "<option value='{$id}'>{$nome}</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Nenhuma categoria cadastrada</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label fw-bold">Descrição do Produto</label>
                            <textarea name="descricao" id="descricao" class="form-control" required
                                data-parsley-required-message="Preencha a descrição do produto."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="imagens" class="form-label fw-bold">Imagem do Produto (JPG)</label>
                                <input type="file" name="imagens" id="imagens" class="form-control" accept=".jpg">
                                <input type="hidden" name="imagem_atual" id="imagem_atual">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="valor" class="form-label fw-bold">Valor</label>
                                <input type="text" name="preco" id="preco" class="form-control" required
                                    data-parsley-required-message="Preencha o valor do produto.">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="destaque" class="form-label fw-bold">Destaque</label>
                                <select name="destaque" id="destaque" required class="form-select"
                                    data-parsley-required-message="Selecione uma opção.">
                                    <option value="">Selecione...</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                            
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            
                            <button type="button" class="btn btn-outline-secondary" onclick="limparFormulario()">
                                <i class="bi bi-plus-circle"></i> Novo Cadastro
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg"></i> Salvar Produto
                            </button>
                        </div>
                    </form>

                    <hr class="my-5">


                    <h3 class="mb-4 border-bottom pb-2">Produtos Cadastrados</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">Imagem</th>
                                    <th>ID</th>
                                    <th>Nome do Produto</th>
                                    <th>Categoria</th>
                                    <th>Valor</th>
                                    <th>Destaque</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dadosProdutos)): ?>
                                    <?php foreach ($dadosProdutos as $produto): ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php if (!empty($produto->imagem)): ?>
                                                    <img src="../public/img/produtos/<?= htmlspecialchars($produto->imagem) ?>"
                                                        alt="<?= htmlspecialchars($produto->nome) ?>" width="50"
                                                        class="img-thumbnail">
                                                <?php else: ?>
                                                    <img src="../public/img/produtos/sem-imagem.jpg" alt="Sem Imagem" width="50"
                                                        class="img-thumbnail">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($produto->id_produto) ?></td>
                                            <td><?= htmlspecialchars($produto->nome_produto) ?></td>
                                            <td><?= htmlspecialchars($produto->nome_categoria ?? 'N/A') ?></td>
                                            <td>R$ <?= htmlspecialchars(number_format($produto->preco, 2, ',', '.')) ?></td>
                                            <td><?= $produto->destaque == 'S' ? '<span class="badge bg-info">Sim</span>' : '<span class="badge bg-secondary">Não</span>' ?>
                                            </td>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm" title="Editar"
                                                    onclick='editarProduto(<?= json_encode($produto, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <a href="javascript:void(0)" onclick="excluirProduto(<?= $produto->id_produto ?>)"
                                                    class="btn btn-danger btn-sm" title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Nenhum produto cadastrado.</td>
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

<script>

    function editarProduto(produto) {

        document.getElementById('id_produto').value = produto.id_produto;
        document.getElementById('nome_produto').value = produto.nome_produto;
        document.getElementById('id_categoria').value = produto.id_categoria;
        $('#descricao').summernote('code', produto.descricao);
        $('#preco').val(produto.preco).maskMoney('mask');
        document.getElementById('destaque').value = produto.destaque;
        document.getElementById('imagem_atual').value = produto.imagem;


        window.scrollTo({ top: 0, behavior: 'smooth' });
    }


    function excluirProduto(id_produto) {
        Swal.fire({
            title: "Deseja realmente excluir este produto?",
            text: "Esta ação não pode ser desfeita e removerá o produto permanentemente.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: "Sim, excluir!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {

                location.href = `../routes/produtoRoutes.php?action=excluir&id=${id_produto}`;
            }
        });
    }

    $(document).ready(function () {
        $("#descricao").summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen']]
            ]
        });

        $('#preco').maskMoney({
            prefix: 'R$ ',
            thousands: '.',
            decimal: ',',
            allowZero: true
        });
    });

    function limparFormulario() {
        document.getElementById('form-produto').reset();
        document.getElementById('id').value = '';
        document.getElementById('imagem_atual').value = '';
        $('#descricao').summernote('code', '');
        $('#preco').maskMoney('destroy').maskMoney({
            prefix: 'R$ ',
            thousands: '.',
            decimal: ',',
            allowZero: true
        });
    }

</script>
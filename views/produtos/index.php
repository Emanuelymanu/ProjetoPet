<?php
// carrega o controller usando caminho baseado em __DIR__
require_once __DIR__ . '/../../controllers/CategoriaController.php';
$categoriaController = new CategoriaController();
$dadosCategoria = $categoriaController->listar();
?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Produtos</h2>
            </div>

        </div>

        <div class="card-body">
            <form action="/ProjetoPet/public/painel2.php?page=salvar" method="POST" data-parsley-validate
                enctype="multipart/form-data" name="formproduto">
                <div class="row">
                    <div class="col-12 col-md-1">
                        <label for="id">ID</label>
                        <input type="text" name="id" id="id" class="form-control" readonly>
                    </div>
                    <div class="col-12 col-md-8">
                        <label for="nome">Nome do Produto</label>
                        <input type="text" name="nome" id="nome" class="form-control" required
                            data-parsley-required-message="Preencha este campo">
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="id_categoria">Categoria:</label>
                        <select name="id_categoria" id="id_categoria" required class="form-control"
                            data-parsley-required-message="Selecione">
                            <option value="">Selecione</option>
                            <?php
                            if (!empty($dadosCategoria) && is_iterable($dadosCategoria)) {
                                foreach ($dadosCategoria as $dados) {
                                    $id = htmlspecialchars($dados->id ?? $dados['id'], ENT_QUOTES);
                                    $nome = htmlspecialchars($dados->nome ?? $dados['nome'], ENT_QUOTES);
                                    echo "<option value='{$id}'>{$nome}</option>";
                                }
                            } else {
                                echo "<option value=''>Nenhuma categoria cadastrada</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md--12">
                        <label for="descricao">Descrição do Produto</label>
                        <textarea name="descricao" id="descricao" class="form-control" required
                            data-parsley-required-message="Preencha este campo"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="imagns">Selecione um arquivo JPG</label>
                        <input type="file" name="imagens" id="imagens" class="form-control" accept=".jpg">
                        <input type="hidden" name="imagens" >
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="valor">Valor:</label>
                        <input type="valor" name="valor" id="valor" class="form-control" required
                            data-parsley-required-message="Preencha este campo">
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="destaque">Destaque:</label>
                        <select name="destaque" id="destaque" required class="form-control"
                            data-parsley-required-message="Selecione uma opção">
                            <option value="">Selecione </option>
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="ativo">Ativo:</label>
                        <select name="ativo" id="ativo" required class="form-control"
                            data-parsley-required-message="Selecione uma opção">
                            <option value="">Selecione</option>
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                        </select>
                    </div>
                </div>
                <br>
                <br>
                <button type="submit" class="btn btn-success">
                    
                    <i class="bi bi-check-lg"></i>
                    Salvar
                </button>
                <div class="float-end">
                    <a href="/ProjetoPet/public/painel2.php?page=listar" class="btn btn-outline-primary">Listar Cadastros</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#descricao").summernote({
            height: 200
        });

    })

    $("#valor").maskMoney({ thousands: '.', decimal: ',' });
</script>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Categorias</h2>
            </div>
            <div class="float-end">
                <a href="categoria/listar.php" class="btn btn-info">
                    Novo Registro
                </a>
                <a href="Categoria/listar" class="btn btn-info">
                    Listar Registros
                </a>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="../routes/categoriaRoutes.php" data-parsley-validate>
                <div class="row">
                    <div class="col-12 col-md-2">
                        <label for="id">ID</label>
                        <input type="text" name="id" id="id" class="form-control" readonly>
                    </div>
                    <div class="col-12 col-md-8">
                        <label for="nome">Nome da Categoria</label>
                        <input type="text" name="nome" id="nome" class="form-control" required
                            data-parsley-required-message="Preencha este campo">
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="ativo">Ativo</label>
                        <select name="ativo" id="ativo" class="form-control" required
                            data-parsley-required-message="Selecione">
                            <option value="">Selecione</option>
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                        </select>
                    </div>
                </div>
                <br>
                <input type="hidden" name="action" value="salvar">
                <button type="submit" class="btn btn-success">
                    Enviar Dados
                </button>
            </form>
        </div>

    </div>
</div>
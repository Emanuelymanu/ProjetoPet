<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . "/../../controllers/IndexController.php";
$indexController = new IndexController();
$usuariosAdmin = $indexController->listarUsuariosPorTipo('admin');
$usuariosCliente = $indexController->listarUsuariosPorTipo('cliente');
?>






<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="bi bi-person-badge" style="font-size: 4rem;"></i>
                    <h2 class="mt-3 mb-0">Gerenciamento de Usuários</h2>
                </div>

                <div class="card-body p-4 p-md-5">



                    <hr class="my-5">

                    <h3 class="mb-4 pb-2 text"><i class="bi bi-person-circle"></i> Administradores Cadastrados</h3>
                    <div class="table-responsive mb-5">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="bg-danger text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($usuariosAdmin)): ?>
                                    <?php foreach ($usuariosAdmin as $usuario): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($usuario->id_usuario) ?></td>
                                            <td><?= htmlspecialchars($usuario->nome) ?></td>
                                            <td><?= htmlspecialchars($usuario->email) ?></td>
                                            <td class="text-center">
                                                
                                                <a href="javascript:mudarTipoUsuario(<?= $usuario->id_usuario ?>, 'cliente')"
                                                    class="btn btn-warning btn-sm" title="Tornar Cliente">
                                                    <i class="bi bi-person-down"></i>
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Nenhum administrador cadastrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-5">

                    <h3 class="mb-4 pb-2 text"><i class="bi bi-person-circle"></i> Clientes Cadastrados</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($usuariosCliente)): ?>
                                    <?php foreach ($usuariosCliente as $usuario): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($usuario->id_usuario) ?></td>
                                            <td><?= htmlspecialchars($usuario->nome) ?></td>
                                            <td><?= htmlspecialchars($usuario->email) ?></td>
                                            <td class="text-center">
                                               
                                                <a href="javascript:mudarTipoUsuario(<?= $usuario->id_usuario ?>, 'admin')"
                                                    class="btn btn-success btn-sm" title="Tornar Admin">
                                                    <i class="bi bi-person-up"></i>
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Nenhum cliente cadastrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
       
        function mudarTipoUsuario(id, novoTipo) {
            const acao = novoTipo === 'admin' ? 'promover' : 'rebaixar';
            const confirmacao = confirm(`Tem certeza que deseja ${acao} este usuário para ${novoTipo}?`);

            if (confirmacao) {
                
                window.location.href = '/ProjetoPet/index.php?action=mudarTipoUsuario&id=' + id + '&tipo=' + novoTipo;
            }
        }
    </script>
</div>
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
                                                <button type="button" class="btn btn-primary btn-sm" title="Editar"
                                                    onclick="editarUsuario(<?= htmlspecialchars(json_encode($usuario), ENT_QUOTES, 'UTF-8') ?>)">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <a href="javascript:excluirUsuario(<?= $usuario->id_usuario ?>)"
                                                    class="btn btn-danger btn-sm" title="Excluir">
                                                    <i class="bi bi-trash"></i>
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
                                                <button type="button" class="btn btn-primary btn-sm" title="Editar"
                                                    onclick="editarUsuario(<?= htmlspecialchars(json_encode($usuario), ENT_QUOTES, 'UTF-8') ?>)">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <a href="javascript:excluirUsuario(<?= $usuario->id_usuario ?>)"
                                                    class="btn btn-danger btn-sm" title="Excluir">
                                                    <i class="bi bi-trash"></i>
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
</div>
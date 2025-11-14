<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header('Location: ../../views/login/index.php');
    exit;
}

$nome = htmlspecialchars($_SESSION['admin']['nome'] ?? 'Usuário', ENT_QUOTES);
$email = htmlspecialchars($_SESSION['admin']['email'] ?? 'não informado', ENT_QUOTES);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
             
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
                    <h2 class="mt-3 mb-0">Perfil do Administrador</h2>
                </div>

                <div class="card-body p-5">
                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold">Nome Completo</label>
                        <div class="alert alert-light border-start border-primary border-4 mb-0">
                            <p class="mb-0 fs-5"><?php echo $nome; ?></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold">Email</label>
                        <div class="alert alert-light border-start border-success border-4 mb-0">
                            <p class="mb-0 fs-5">
                                <i class="bi bi-envelope"></i>
                                <?php echo $email; ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold">Status</label>
                        <div class="alert alert-light border-start border-success border-4 mb-0">
                            <p class="mb-0 fs-5">
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Ativo
                                </span>
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button">
                            <i class="bi bi-pencil-square"></i> Editar Perfil
                        </button>
                        <button class="btn btn-outline-danger" type="button" onclick="location.href='sair.php'">
                            <i class="bi bi-door-closed"></i> Sair
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .alert {
        border-radius: 8px;
        padding: 1rem;
    }

    .form-label {
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    
</style>


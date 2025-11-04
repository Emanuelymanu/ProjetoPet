<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Topbar -->
    <?php include 'includes/topbar.php'; ?>

    <div class="container-fluid flex-grow-1">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo Dinâmico -->
                <div class="container-fluid">
                    <?php
                    $pageParam = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                    $pageFile = '';

                    switch ($pageParam) {
                        case 'dashboard':
                            $pageFile = '../views/dashboard/index.php';
                            break;
                        case 'categorias':
                            $pageFile = '../views/categoria/index.php';
                            break;
                        case 'produtos':
                            $pageFile = '../views/produtos/index.php';
                            break;
                        case 'pedidos':
                            $pageFile = '../views/pedidos/index.php';
                            break;
                        case 'usuarios':
                            $pageFile = '../views/usuarios/index.php';
                            break;
                        case 'estoque':
                            $pageFile = '../views/estoque/index.php';
                            break;
                        default:
                            $pageFile = '../views/dashboard/index.php';
                            break;
                    }

                    if (file_exists($pageFile)) {
                        require $pageFile;
                    } else {
                        echo "Página não encontrada!";
                    }

                    ?>
                </div>

            </main>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
<style>
    body {
        font-size: 0.875rem;
        padding-top: 60px;
        /* Compensa a altura da topbar fixa */
    }

    /* Sidebar corrigida */
    .sidebar {
        position: fixed;
        top: 60px;
        /* Começa depois da topbar */
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 20px 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        overflow-y: auto;
        height: calc(100vh - 60px);
        /* Altura total menos topbar */
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
        padding: 0.75rem 1rem;
    }

    .sidebar .nav-link.active {
        color: #007bff;
        background-color: rgba(0, 123, 255, 0.1);
    }

    .sidebar .nav-link:hover {
        color: #007bff;
        background-color: rgba(0, 123, 255, 0.05);
    }

    .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
    }

    /* Topbar fixa */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        height: 60px;
    }

    /* Conteúdo principal */
    main {
        margin-left: 0;
        /* Para mobile first */
        padding-top: 20px;
        min-height: calc(100vh - 120px);
        /* Altura menos topbar e footer */
    }

    /* Para desktop */
    @media (min-width: 768px) {
        main {
            margin-left: 16.666667%;
            /* Largura da sidebar no desktop */
        }

        .sidebar {
            width: 16.666667%;
            /* 2/12 colunas */
        }
    }

    .navbar-brand {
        padding-top: .75rem;
        padding-bottom: .75rem;
        font-size: 1rem;
    }

    /* Footer corrigido */
    .footer {
        position: relative;
        z-index: 1020;
        margin-top: auto;
    }
</style>

</html>
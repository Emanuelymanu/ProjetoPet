<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header('Location: ../views/login/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="css/style.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Império Animal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="icon" href="img/icone.png">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>
    <script src="js/jquery.maskedinput-1.2.1.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script>

        function mensagem(titulo, icone, pagina) {
            Swal.fire({
                title: titulo,
                icon: icone,
            }).then((result) => {

                if (icone == "error") {
                    history.back();
                } else {
                    location.href = pagina;
                }

            });
        }
    </script>
    <style>
        /* ===== TEMA CLARO (PADRÃO) ===== */
        body[data-theme="light"] {
            background-color: #f8f9fa;
            color: #333;
        }

        body[data-theme="light"] .navbar {
            background-color: #343a40 !important;
        }

        body[data-theme="light"] .sidebar {
            background-color: #f8f9fa;
            color: #333;
        }

        body[data-theme="light"] .sidebar .nav-link {
            color: #333;
        }

        body[data-theme="light"] .sidebar .nav-link:hover,
        body[data-theme="light"] .sidebar .nav-link.active {
            background-color: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        body[data-theme="light"] .card {
            background-color: #fff;
            color: #333;
            border-color: #dee2e6;
        }

        body[data-theme="light"] .card-header {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #333;
        }

        body[data-theme="light"] .card-body {
            background-color: #fff;
            color: #333;
        }

        body[data-theme="light"] .alert-light {
            background-color: #f8f9fa !important;
            border-color: #dee2e6 !important;
            color: #333;
        }

        body[data-theme="light"] .form-control,
        body[data-theme="light"] .form-select {
            background-color: #fff;
            color: #333;
            border-color: #dee2e6;
        }

        body[data-theme="light"] .table {
            color: #333;
        }

        body[data-theme="light"] .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        body[data-theme="light"] .footer {
            background-color: #343a40 !important;
            color: #fff;
        }

        body[data-theme="light"] .form-label {
            color: #6c757d;
        }

        /* ===== TEMA ESCURO ===== */
        body[data-theme="dark"] {
            background-color: #1a1a1a;
            color: #e0e0e0;
        }

        body[data-theme="dark"] .navbar {
            background-color: #0d1117 !important;
            border-bottom: 1px solid #444;
        }

        body[data-theme="dark"] .sidebar {
            background-color: #1e1e1e;
            color: #e0e0e0;
            border-right: 1px solid #444;
        }

        body[data-theme="dark"] .sidebar .nav-link {
            color: #b0b0b0;
        }

        body[data-theme="dark"] .sidebar .nav-link:hover,
        body[data-theme="dark"] .sidebar .nav-link.active {
            background-color: rgba(0, 123, 255, 0.15);
            color: #64b5f6;
        }

        body[data-theme="dark"] .card {
            background-color: #2d2d2d;
            color: #e0e0e0;
            border-color: #444;
        }

        body[data-theme="dark"] .card-header {
            background-color: #1e3a5f;
            border-color: #444;
            color: #e0e0e0;
        }

        body[data-theme="dark"] .card-body {
            background-color: #2d2d2d;
            color: #e0e0e0;
        }

        body[data-theme="dark"] .alert-light {
            background-color: #3a3a3a !important;
            border-color: #555 !important;
            color: #e0e0e0;
        }

        body[data-theme="dark"] .form-control,
        body[data-theme="dark"] .form-select {
            background-color: #3a3a3a;
            color: #e0e0e0;
            border-color: #555;
        }

        body[data-theme="dark"] .form-control:focus,
        body[data-theme="dark"] .form-select:focus {
            background-color: #3a3a3a;
            color: #e0e0e0;
            border-color: #64b5f6;
            box-shadow: 0 0 0 0.2rem rgba(100, 181, 246, 0.25);
        }

        body[data-theme="dark"] .table {
            color: #e0e0e0;
        }

        body[data-theme="dark"] .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        body[data-theme="dark"] .table-dark {
            background-color: #1e3a5f;
            color: #e0e0e0;
        }

        body[data-theme="dark"] .table-dark thead th {
            background-color: #1e3a5f;
            border-color: #444;
        }

        body[data-theme="dark"] .footer {
            background-color: #0d1117 !important;
            color: #e0e0e0;
            border-top: 1px solid #444;
        }

        body[data-theme="dark"] .form-label {
            color: #b0b0b0;
        }

        body[data-theme="dark"] .btn-outline-secondary {
            color: #e0e0e0;
            border-color: #666;
        }

        body[data-theme="dark"] .btn-outline-secondary:hover {
            background-color: #444;
            border-color: #888;
        }

        body[data-theme="dark"] .text-muted {
            color: #999 !important;
        }

        body[data-theme="dark"] hr {
            border-color: #555;
        }

        body[data-theme="dark"] .border-bottom {
            border-color: #444 !important;
        }

        /* Transições suaves */
        body,
        .card,
        .sidebar,
        .navbar,
        .form-control,
        .form-select,
        .alert {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>


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
                    <h1>Bem-Vindo, <?php echo $_SESSION["admin"]["nome"]; ?>!</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                    </div>
                </div>

                <!-- Conteúdo Dinâmico -->
                <div class="container-fluid">
                    <?php
                    $routes = require '../routes/routes.php';
                    $page = $_GET['page'] ?? 'dashboard';

                    if (isset($routes[$page]) && file_exists($routes[$page])) {
                        include $routes[$page];
                    } else {
                        include '../views/erro.php';
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
<script>
    // Inicializa o tema ao carregar a página
    document.addEventListener('DOMContentLoaded', function () {
        const theme = localStorage.getItem('theme') || 'light';
        document.body.setAttribute('data-theme', theme);
        updateThemeButton(theme);
    });

    // Toggle do tema
    const themeToggleBtn = document.getElementById('themeToggle');
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function () {
            const currentTheme = document.body.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeButton(newTheme);
        });
    }

    // Atualiza o ícone do botão
    function updateThemeButton(theme) {
        const btn = document.getElementById('themeToggle');
        if (btn) {
            if (theme === 'dark') {
                btn.innerHTML = '<i class="bi bi-sun"></i>';
                btn.title = 'Ativar modo claro';
            } else {
                btn.innerHTML = '<i class="bi bi-moon-stars"></i>';
                btn.title = 'Ativar modo escuro';
            }
        }
    }
</script>

</html>
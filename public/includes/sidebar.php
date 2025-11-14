<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="?page=dashboard">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=usuarios">
                    <i class="bi bi-people"></i>
                    Usuários
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=produtos">
                    <i class="bi bi-box-seam"></i>
                    Produtos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=categorias">
                    <i class="bi bi-list-task"></i>
                    Categorias
                </a>
            <li class="nav-item">
                <a class="nav-link" href="?page=pedidos">
                    <i class="bi bi-basket3"></i>
                    Pedidos
                </a>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=estoque">
                    <i class="bi bi-boxes"></i>
                    Estoque
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=perfil">
                    <i class="bi bi-person-circle"></i>
                    Meu Prefil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=sair">
                    <i class="bi bi-door-closed"></i>
                    Sair
                </a>
            </li>

        </ul>


    </div>
</nav>
<style>
    /* Dark mode específico para sidebar */
    body[data-theme="dark"] .sidebar {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
    }

    body[data-theme="dark"] .sidebar .nav-link {
        color: #b0b0b0 !important;
    }

    body[data-theme="dark"] .sidebar .nav-link:hover {
        color: #64b5f6 !important;
        background-color: rgba(0, 123, 255, 0.15) !important;
    }

    body[data-theme="dark"] .sidebar .nav-link.active {
        color: #64b5f6 !important;
        background-color: rgba(0, 123, 255, 0.15) !important;
    }

    /* Light mode específico para sidebar */
    body[data-theme="light"] .sidebar {
        background-color: #f8f9fa !important;
        color: #333 !important;
    }

    body[data-theme="light"] .sidebar .nav-link {
        color: #333 !important;
    }

    body[data-theme="light"] .sidebar .nav-link:hover {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.1) !important;
    }

    body[data-theme="light"] .sidebar .nav-link.active {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.1) !important;
    }
</style>

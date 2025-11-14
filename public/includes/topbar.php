<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Botão toggle para sidebar -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Brand -->
        <a class="navbar-brand" href="#">
            <i class="bi bi-speedometer2"></i> Painel Admin
        </a>

        <!-- Itens da topbar -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                   <li class="nav-item">
                    <button class="btn btn-outline-light ms-2" id="themeToggle" type="button" title="Alternar tema">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                </li>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Configurações</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i>
                                Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
        <!-- botão visível em telas pequenas -->
        <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
            ☰
        </button>
        <a class="navbar-brand ms-2" href="#">ProjetoPet - Painel</a>
    </div>
</nav>

<div class="d-flex">
    <!-- Sidebar desktop (md+) -->
    <aside id="sidebar-desktop" class="d-none d-md-block bg-light border-end vh-100 position-fixed">
        <div class="p-3">
            <h5 class="mb-3">Menu</h5>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action">Pets</a>
                <a href="#" class="list-group-item list-group-item-action">Clientes</a>
                <a href="#" class="list-group-item list-group-item-action">Consultas</a>
                <a href="#" class="list-group-item list-group-item-action">Configurações</a>
            </div>
        </div>
    </aside>

    <!-- Offcanvas sidebar mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action">Pets</a>
                <a href="#" class="list-group-item list-group-item-action">Clientes</a>
                <a href="#" class="list-group-item list-group-item-action">Consultas</a>
                <a href="#" class="list-group-item list-group-item-action">Configurações</a>
            </div>
        </div>
    </div>

    <!-- Conteúdo principal -->
    <main class="flex-fill ms-md-240 p-4" style="margin-left:0;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2>Bem-vindo ao Painel</h2>
                    <p>Conteúdo principal aqui.</p>
                </div>
            </div>
        </div>
    </main>
</div>
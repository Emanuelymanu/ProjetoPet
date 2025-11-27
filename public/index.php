<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop | Home</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
<body>

<header class="bg-dark text-white p-3 shadow-lg">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0">PetShop</h1>
        <nav>
            <a href="#" class="text-white mx-2 text-decoration-none">Home</a>
            <a href="#" class="text-white mx-2 text-decoration-none">Produtos</a>
            <a href="#" class="text-white mx-2 text-decoration-none"><i class="bi bi-person-circle"></i> Minha Conta</a>
            <a href="/routes/carrinhoRoutes.php?action=index" class="btn btn-warning btn-sm"><i class="bi bi-cart"></i> Carrinho</a>
        </nav>
    </div>
</header>

<div class="container mt-5">
    
    <div class="row mb-5">
        <div class="col-12 text-center py-4 bg-light rounded-3 shadow-sm">
            <h1 class="display-4 text-primary fw-bold">
                Bem-vindo(a) ao Seu PetShop Online 🐾
            </h1>
            <p class="lead text-muted">Tudo o que seu pet precisa em um só lugar.</p>
        </div>
    </div>

    <h2 class="mb-4 text-center pb-2 border-bottom border-danger">🔥 Produtos em Destaque</h2>

    <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
        
        <div class="col">
            <div class="card h-100 shadow-sm border-danger border-2">
                <img src="public/img/produtos/produto-racao.jpg" 
                     class="card-img-top" alt="Ração Super Premium" style="height: 200px; object-fit: cover;">
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate">Ração Super Premium para Cães Adultos</h5>
                    <p class="card-text text-success fw-bold fs-4 mt-auto">R$ 129,90</p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="detalhes.php?id=1" class="btn btn-danger w-100">
                        <i class="bi bi-bag-plus"></i> Comprar
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="public/img/produtos/produto-brinquedo.jpg" 
                     class="card-img-top" alt="Brinquedo de Corda" style="height: 200px; object-fit: cover;">
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate">Kit Brinquedos de Corda e Borracha</h5>
                    <p class="card-text text-success fw-bold fs-4 mt-auto">R$ 49,99</p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="detalhes.php?id=2" class="btn btn-primary w-100">
                        <i class="bi bi-bag-plus"></i> Comprar
                    </a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="public/img/produtos/produto-cama.jpg" 
                     class="card-img-top" alt="Cama Ortopédica" style="height: 200px; object-fit: cover;">
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate">Cama Ortopédica para Cães de Grande Porte</h5>
                    <p class="card-text text-success fw-bold fs-4 mt-auto">R$ 219,00</p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="detalhes.php?id=3" class="btn btn-primary w-100">
                        <i class="bi bi-bag-plus"></i> Comprar
                    </a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow-sm border-danger border-2">
                <img src="public/img/produtos/produto-areia.jpg" 
                     class="card-img-top" alt="Areia Higiênica" style="height: 200px; object-fit: cover;">
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate">Areia Higiênica Biodegradável (Promoção!)</h5>
                    <p class="card-text text-success fw-bold fs-4 mt-auto">R$ 55,50</p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="detalhes.php?id=4" class="btn btn-danger w-100">
                        <i class="bi bi-bag-plus"></i> Comprar
                    </a>
                </div>
            </div>
        </div>
        
    </div>
    
    <hr class="my-5">

    <h2 class="mb-4 text-center pb-2 border-bottom border-primary">🏷️ Navegue por Categoria</h2>

    <div class="row row-cols-2 row-cols-md-4 g-4 justify-content-center">
        
        <div class="col text-center">
            <a href="produtos.php?cat=1" class="card h-100 shadow-sm category-card text-decoration-none p-3 border-info">
                <i class="bi bi-dog text-info" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-dark">Alimentos</h5>
            </a>
        </div>
        
        <div class="col text-center">
            <a href="produtos.php?cat=2" class="card h-100 shadow-sm category-card text-decoration-none p-3 border-info">
                <i class="bi bi-scissors text-info" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-dark">Higiene e Beleza</h5>
            </a>
        </div>
        
        <div class="col text-center">
            <a href="produtos.php?cat=3" class="card h-100 shadow-sm category-card text-decoration-none p-3 border-info">
                <i class="bi bi-house-door text-info" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-dark">Camas e Casinhas</h5>
            </a>
        </div>

        <div class="col text-center">
            <a href="produtos.php?cat=4" class="card h-100 shadow-sm category-card text-decoration-none p-3 border-info">
                <i class="bi bi-heart-pulse text-info" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-dark">Saúde e Suplementos</h5>
            </a>
        </div>
        
    </div>

</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; <?= date('Y') ?> PetShop. Todos os direitos reservados.
</footer>

<style>
/* Estilo simples para dar destaque ao hover das categorias */
.category-card:hover {
    transform: translateY(-5px);
    transition: transform 0.3s;
    background-color: #f8f9fa; /* Levemente cinza no hover */
    border-color: #0dcaf0 !important;
}
</style>

</body>
</html>
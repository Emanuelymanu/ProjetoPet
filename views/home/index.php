<?php
// Simulação de sessão e dados
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = null;
}

// Dados de exemplo
$products = [
    1 => [
        'id' => 1,
        'name' => 'Ração Premium para Cães',
        'price' => 89.90,
        'old_price' => 99.90,
        'category' => 'caes',
        'image' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        'badge' => 'Promoção',
        'description' => 'Ração premium para cães adultos de todas as raças'
    ],
    2 => [
        'id' => 2,
        'name' => 'Brinquedo para Gatos',
        'price' => 24.90,
        'old_price' => null,
        'category' => 'gatos',
        'image' => 'https://images.unsplash.com/photo-1591946614720-90a587da4a36?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        'badge' => null,
        'description' => 'Brinquedo interativo para gatos'
    ],
    3 => [
        'id' => 3,
        'name' => 'Aquário 50 Litros',
        'price' => 199.90,
        'old_price' => 249.90,
        'category' => 'peixes',
        'image' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        'badge' => 'Oferta',
        'description' => 'Aquário completo 50 litros com acessórios'
    ],
    4 => [
        'id' => 4,
        'name' => 'Coleira Antipulgas',
        'price' => 39.90,
        'old_price' => null,
        'category' => 'caes',
        'image' => 'https://images.unsplash.com/photo-1596461404964-483dfb1c4326?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
        'badge' => null,
        'description' => 'Coleira antipulgas e carrapatos para cães'
    ]
];

// Processar ações
if ($_POST) {
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        if (isset($products[$product_id])) {
            $_SESSION['cart'][] = $product_id;
            $message = "Produto adicionado ao carrinho!";
        }
    }
    
    if (isset($_POST['newsletter_email'])) {
        $email = $_POST['newsletter_email'];
        $message = "Obrigado por se cadastrar na nossa newsletter!";
    }
}

$cart_count = count($_SESSION['cart']);
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop Online - Tudo para seu animal de estimação</title>
    <style>
        /* Reset e estilos gerais */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
        }
        
        .btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        /* Header */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .logo span {
            color: #3498db;
        }
        
        .search-bar {
            flex: 1;
            max-width: 500px;
            margin: 0 20px;
            position: relative;
        }
        
        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            outline: none;
            font-size: 16px;
        }
        
        .search-bar button {
            position: absolute;
            right: 5px;
            top: 5px;
            background: #3498db;
            border: none;
            color: white;
            padding: 7px 20px;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .user-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-actions a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        .user-actions a:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .cart-count {
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Navigation */
        nav ul {
            display: flex;
            list-style: none;
            margin-top: 15px;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        nav ul li a {
            padding: 10px 20px;
            border-radius: 4px;
            transition: background 0.3s;
            font-weight: 500;
        }
        
        nav ul li a:hover,
        nav ul li a.active {
            background: rgba(255,255,255,0.1);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Sections */
        .section {
            padding: 80px 0;
        }
        
        .section-light {
            background: white;
        }
        
        .section-gray {
            background: #ecf0f1;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            font-size: 36px;
            color: #2c3e50;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #3498db;
            margin: 15px auto;
            border-radius: 2px;
        }
        
        /* Grid Systems */
        .category-grid,
        .product-grid,
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        
        /* Cards */
        .category-card,
        .product-card,
        .service-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .category-card:hover,
        .product-card:hover,
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .category-img,
        .product-img {
            height: 200px;
            background-size: cover;
            background-position: center;
            background-color: #f8f9fa;
        }
        
        .product-img {
            position: relative;
            overflow: hidden;
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .product-info,
        .service-content {
            padding: 25px;
        }
        
        .product-info h3,
        .service-content h3 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #2c3e50;
        }
        
        .product-price {
            font-size: 24px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .product-price .old-price {
            font-size: 16px;
            color: #7f8c8d;
            text-decoration: line-through;
        }
        
        .product-rating {
            color: #f39c12;
            margin-bottom: 15px;
        }
        
        .add-to-cart {
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            transition: background 0.3s;
            font-size: 16px;
        }
        
        .add-to-cart:hover {
            background: #219653;
        }
        
        /* Service Cards */
        .service-icon {
            font-size: 50px;
            color: #3498db;
            margin-bottom: 20px;
        }
        
        .service-content p {
            color: #7f8c8d;
            line-height: 1.8;
        }
        
        /* Newsletter */
        .newsletter {
            background: #2c3e50;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        
        .newsletter h2 {
            margin-bottom: 20px;
            font-size: 32px;
        }
        
        .newsletter p {
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            font-size: 18px;
            opacity: 0.9;
        }
        
        .newsletter-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
            gap: 10px;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
        }
        
        .newsletter-form button {
            background: #3498db;
            color: white;
            border: none;
            padding: 0 30px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #2980b9;
        }
        
        /* Footer */
        footer {
            background: #1a252f;
            color: white;
            padding: 80px 0 30px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-column h3 {
            margin-bottom: 25px;
            font-size: 20px;
            color: #3498db;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 12px;
        }
        
        .footer-column ul li a {
            transition: color 0.3s;
            opacity: 0.8;
        }
        
        .footer-column ul li a:hover {
            color: #3498db;
            opacity: 1;
        }
        
        .contact-info li {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: #3498db;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            opacity: 0.7;
        }
        
        /* Message */
        .message {
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 5px;
            background: #27ae60;
            color: white;
            text-align: center;
        }
        
        /* Responsividade */
        @media (max-width: 768px) {
            .header-top {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-bar {
                max-width: 100%;
                margin: 10px 0;
                order: 3;
                width: 100%;
            }
            
            .user-actions {
                width: 100%;
                justify-content: center;
            }
            
            nav ul {
                justify-content: center;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .section-title {
                font-size: 28px;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .newsletter-form input,
            .newsletter-form button {
                width: 100%;
            }
            
            .product-price {
                font-size: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                width: 95%;
            }
            
            .category-grid,
            .product-grid,
            .service-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .hero {
                padding: 60px 0;
            }
            
            .hero h1 {
                font-size: 28px;
            }
            
            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <a href="#">Pet<span>Shop</span></a>
                </div>
                <div class="search-bar">
                    <form action="#" method="GET">
                        <input type="text" name="search" placeholder="O que seu pet precisa hoje?">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="user-actions">
                    <?php if ($_SESSION['user_id']): ?>
                        <a href="#"><i class="fas fa-user"></i> Minha Conta</a>
                        <a href="#"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    <?php else: ?>
                        <a href="#"><i class="fas fa-sign-in-alt"></i> Entrar</a>
                        <a href="#"><i class="fas fa-user-plus"></i> Cadastrar</a>
                    <?php endif; ?>
                    <a href="#"><i class="fas fa-shopping-cart"></i> Carrinho <span class="cart-count"><?php echo $cart_count; ?></span></a>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Início</a></li>
                    <li><a href="#">Cachorros</a></li>
                    <li><a href="#">Gatos</a></li>
                    <li><a href="#">Pássaros</a></li>
                    <li><a href="#">Peixes</a></li>
                    <li><a href="#">Promoções</a></li>
                    <li><a href="#">Serviços</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Mensagem -->
    <?php if (isset($message)): ?>
        <div class="container">
            <div class="message">
                <?php echo $message; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Banner Principal -->
    <section class="hero">
        <div class="container">
            <h1>Tudo para o seu animal de estimação</h1>
            <p>Encontre os melhores produtos, rações, brinquedos e acessórios com os melhores preços!</p>
            <a href="#" class="btn">Comprar Agora</a>
        </div>
    </section>

    <!-- Categorias -->
    <section class="section section-light">
        <div class="container">
            <h2 class="section-title">Categorias</h2>
            <div class="category-grid">
                <div class="category-card">
                    <a href="#">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1552053831-71594a27632d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');"></div>
                        <div class="product-info">
                            <h3>Cachorros</h3>
                        </div>
                    </a>
                </div>
                <div class="category-card">
                    <a href="#">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');"></div>
                        <div class="product-info">
                            <h3>Gatos</h3>
                        </div>
                    </a>
                </div>
                <div class="category-card">
                    <a href="#">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1552728089-57bdde30beb3?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');"></div>
                        <div class="product-info">
                            <h3>Pássaros</h3>
                        </div>
                    </a>
                </div>
                <div class="category-card">
                    <a href="#">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');"></div>
                        <div class="product-info">
                            <h3>Peixes</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Produtos em Destaque -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">Produtos em Destaque</h2>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-img" style="background-image: url('<?php echo $product['image']; ?>');">
                        <?php if ($product['badge']): ?>
                            <span class="product-badge"><?php echo $product['badge']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3><?php echo $product['name']; ?></h3>
                        <p style="color: #7f8c8d; margin-bottom: 15px; font-size: 14px;"><?php echo $product['description']; ?></p>
                        <div class="product-price">
                            R$ <?php echo number_format($product['price'], 2, ',', '.'); ?>
                            <?php if ($product['old_price']): ?>
                                <span class="old-price">R$ <?php echo number_format($product['old_price'], 2, ',', '.'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="add_to_cart" class="add-to-cart">
                                Adicionar ao Carrinho
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="#" class="btn">Ver Todos os Produtos</a>
            </div>
        </div>
    </section>

    <!-- Serviços -->
    <section class="section section-light">
        <div class="container">
            <h2 class="section-title">Nossos Serviços</h2>
            <div class="service-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="service-content">
                        <h3>Entrega Rápida</h3>
                        <p>Entregamos em até 24h na região metropolitana e 3-5 dias para outras localidades.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="service-content">
                        <h3>Pagamento Seguro</h3>
                        <p>Seus dados protegidos com criptografia avançada e certificado SSL.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="service-content">
                        <h3>Troca Fácil</h3>
                        <p>Troque seu produto em até 7 dias sem complicação e sem burocracia.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="service-content">
                        <h3>Atendimento</h3>
                        <p>Especialistas prontos para tirar suas dúvidas sobre produtos e cuidados.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <h2>Fique por dentro das novidades</h2>
            <p>Cadastre-se e receba ofertas exclusivas e descontos especiais</p>
            <form class="newsletter-form" method="POST">
                <input type="email" name="newsletter_email" placeholder="Seu melhor e-mail" required>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h3>PetShop Online</h3>
                    <p>A melhor loja online para o seu animal de estimação. Qualidade, preço baixo e entrega rápida.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Institucional</h3>
                    <ul>
                        <li><a href="#">Sobre Nós</a></li>
                        <li><a href="#">Nossas Lojas</a></li>
                        <li><a href="#">Trabalhe Conosco</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Atendimento</h3>
                    <ul>
                        <li><a href="#">Central de Ajuda</a></li>
                        <li><a href="#">Meus Pedidos</a></li>
                        <li><a href="#">Troca e Devolução</a></li>
                        <li><a href="#">Formas de Pagamento</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contato</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> Rua dos Animais, 123</li>
                        <li><i class="fas fa-phone"></i> (11) 9999-9999</li>
                        <li><i class="fas fa-envelope"></i> contato@petshop.com</li>
                        <li><i class="fas fa-clock"></i> Seg à Sex: 8h às 18h</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> PetShop Online - Todos os direitos reservados</p>
            </div>
        </div>
    </footer>

    <script>
        // Funcionalidades básicas do e-commerce
        document.addEventListener('DOMContentLoaded', function() {
            // Adicionar ao carrinho com AJAX
            const addToCartForms = document.querySelectorAll('form');
            
            addToCartForms.forEach(form => {
                if (form.querySelector('input[name="product_id"]')) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(this);
                        
                        fetch('', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            // Recarregar a página para atualizar o contador
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Erro de conexão.', 'error');
                        });
                    });
                }
            });
            
            // Mostrar notificação
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `notification notification-${type}`;
                notification.textContent = message;
                
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 15px 20px;
                    border-radius: 5px;
                    color: white;
                    z-index: 10000;
                    transition: all 0.3s ease;
                    background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 3000);
            }
            
            // Validação de formulários
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
    </script>
</body>
</html>
<?php
// views/home-cliente/index.php
// Carrega produtos do banco agrupados por categoria


require_once __DIR__ . '/../../config/Conexao.php';


// Inicializa sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Gera ID de cliente se não existir
if (!isset($_SESSION['cliente_id'])) {
    $_SESSION['cliente_id'] = uniqid('cliente_');
}

// Define BASE_URL para links públicos
$BASE_URL = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'])), '/');

// Conecta ao banco e busca produtos agrupados por categoria
$con = Conexao::conectar();
$produtosPorCategoria = [];

try {
    // Busca todas as categorias
    $sqlCategorias = "SELECT DISTINCT categoria FROM produto WHERE categoria IS NOT NULL AND categoria != '' ORDER BY categoria";
    $stmtCat = $con->prepare($sqlCategorias);
    $stmtCat->execute();
    $categorias = $stmtCat->fetchAll(PDO::FETCH_COLUMN);

    // Para cada categoria, busca seus produtos
    foreach ($categorias as $cat) {
        $sql = "SELECT * FROM produto WHERE categoria = :categoria ORDER BY nome";
        $stmt = $con->prepare($sql);
        $stmt->execute([':categoria' => $cat]);
        $produtosPorCategoria[$cat] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    error_log('Erro ao buscar produtos: ' . $e->getMessage());
    $produtosPorCategoria = [];
}

// Busca produtos por termo de pesquisa (se enviado)
$termo_busca = $_GET['busca'] ?? '';
$em_busca = false;
if (!empty($termo_busca)) {
    $em_busca = true;
    $resultados_busca = [];
    try {
        $sql = "SELECT * FROM produto 
                WHERE nome LIKE :termo OR descricao LIKE :termo 
                ORDER BY categoria, nome";
        $stmt = $con->prepare($sql);
        $termo = '%' . $termo_busca . '%';
        $stmt->execute([':termo' => $termo]);
        $resultados_busca = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Agrupa resultados de busca por categoria
        $produtosPorCategoria = [];
        foreach ($resultados_busca as $prod) {
            $cat = $prod['categoria'] ?? 'Sem categoria';
            if (!isset($produtosPorCategoria[$cat])) {
                $produtosPorCategoria[$cat] = [];
            }
            $produtosPorCategoria[$cat][] = $prod;
        }
    } catch (Exception $e) {
        error_log('Erro ao buscar: ' . $e->getMessage());
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Catálogo — Império Animal</title>
<link rel="stylesheet" href="<?php echo $BASE_URL; ?>/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $BASE_URL; ?>/css/style.css">
<link rel="stylesheet" href="<?php echo $BASE_URL; ?>/css/all.min.css">
<style>
  :root {
    --primary: #d96a87;
    --bg: #f0f4f7;
    --card: #ffffff;
    --border: #eee;
    --radius: 16px;
  }
  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; width: 100%; overflow-x: hidden; }
  body { font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, Arial; background: var(--bg); color: #222; }
  
  .nav {
    width: 100%;
    padding: 18px 24px;
    display: flex;
    gap: 20px;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(180deg, #0d0d0d, rgba(0,0,0,0.65));
    position: sticky;
    top: 0;
    z-index: 40;
    border-bottom: 1px solid rgba(0,0,0,0.04);
  }
  .nav-logo { flex: 0 0 auto; }
  .nav-logo img { height: 42px; }
  .search-wrap { flex: 1; display: flex; justify-content: center; }
  .search {
    width: 70%;
    min-width: 260px;
    max-width: 720px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--card);
    padding: 10px 14px;
    border-radius: 30px;
    box-shadow: 0 6px 18px rgba(16,24,40,0.06);
    border: 1px solid rgba(16,24,40,0.04);
  }
  .search input { flex: 1; border: none; outline: none; background: transparent; font-size: 14px; }
  .search .icon { cursor: pointer; font-size: 18px; }
  .nav-icons { display: flex; gap: 12px; }
  .btn-icon {
    background: rgba(255,255,255,0.1);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.2);
    padding: 10px 16px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
  }
  .btn-icon:hover { background: rgba(255,255,255,0.2); }
  
  .container { max-width: 1200px; margin: 36px auto; padding: 0 24px; }
  
  .categoria-section {
    margin-bottom: 48px;
  }
  .categoria-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--border);
    text-transform: capitalize;
  }
  
  .grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
    gap: 20px; 
    margin-bottom: 20px;
  }
  
  .card {
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.3s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
  }
  .card:hover { 
    box-shadow: 0 8px 24px rgba(16,24,40,0.12); 
    transform: translateY(-4px); 
  }
  .card-img { 
    width: 100%; 
    height: 200px; 
    background: #f7f7f7; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    overflow: hidden; 
  }
  .card-img img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
  }
  .card-body { 
    padding: 16px; 
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }
  .card-title { 
    font-weight: 700; 
    color: var(--primary); 
    margin-bottom: 6px; 
    font-size: 16px; 
  }
  .card-desc { 
    color: #6b4750; 
    font-size: 13px; 
    margin-bottom: 12px; 
    line-height: 1.4; 
    flex-grow: 1;
  }
  .card-price { 
    font-weight: 900; 
    font-size: 18px; 
    color: var(--primary); 
    margin-bottom: 12px; 
  }
  .card-btn {
    width: 100%;
    padding: 12px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: auto;
  }
  .card-btn:hover { 
    opacity: 0.9; 
    transform: scale(1.02);
  }
  
  .empty { 
    text-align: center; 
    color: #6b4750; 
    padding: 40px; 
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
  }
  
  .search-result-title {
    font-size: 24px;
    font-weight: 700;
    color: #222;
    margin-bottom: 24px;
  }
  
  @media (max-width: 768px) {
    .grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
    .nav { flex-direction: column; gap: 12px; }
    .search-wrap { width: 100%; }
    .search { width: 100%; }
    .categoria-title { font-size: 22px; }
  }
</style>
</head>
<body>

<header class="nav">
  <div class="nav-logo">
    <img src="<?php echo $BASE_URL; ?>/img/logo.png" alt="Logo Império Animal">
  </div>

  <div class="search-wrap">
    <form class="search" method="get" style="display: flex; gap: 10px;">
      <input type="text" name="busca" placeholder="Pesquisar ração, brinquedo, petisco..." value="<?php echo htmlspecialchars($termo_busca); ?>">
      <button type="submit" style="background: none; border: none; cursor: pointer; color: #333; padding: 0;">🔎</button>
    </form>
  </div>

  <div class="nav-icons">
    <button class="btn-icon">👤 Login</button>
    <button class="btn-icon">🛒 Carrinho</button>
  </div>
</header>

<main class="container">
  <?php if ($em_busca): ?>
    <div class="search-result-title">
      Resultados para: "<strong><?php echo htmlspecialchars($termo_busca); ?></strong>"
    </div>
  <?php else: ?>
    <h1>Catálogo de Produtos</h1>
  <?php endif; ?>

  <!-- Exibe produtos agrupados por categoria -->
  <?php if (empty($produtosPorCategoria)): ?>
    <div class="empty">
      <p>Nenhum produto encontrado.</p>
      <?php if ($em_busca): ?>
        <p><a href="<?php echo $BASE_URL; ?>/index.php">Voltar ao catálogo completo</a></p>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <?php foreach ($produtosPorCategoria as $categoria => $produtos): ?>
      <section class="categoria-section">
        <h2 class="categoria-title"><?php echo htmlspecialchars($categoria); ?></h2>
        
        <div class="grid">
        <?php foreach ($produtos as $p): 
            $id = $p['id_produto'] ?? $p['id'] ?? 0;
            $nome = $p['nome'] ?? 'Produto';
            $descricao = $p['descricao'] ?? '';
            $preco = isset($p['preco']) ? (float)$p['preco'] : 0.0;
            $imagem = $p['imagem'] ?? '';
        ?>
          <div class="card">
            <div class="card-img">
              <img src="<?php echo $imagem ? htmlspecialchars($imagem) : 'https://via.placeholder.com/200x200?text=' . urlencode($nome); ?>" alt="<?php echo htmlspecialchars($nome); ?>">
            </div>
            <div class="card-body">
              <div class="card-title"><?php echo htmlspecialchars($nome); ?></div>
              <div class="card-desc"><?php echo htmlspecialchars(substr($descricao, 0, 80)); ?></div>
              <div class="card-price">R$ <?php echo number_format($preco, 2, ',', '.'); ?></div>
              <form method="post" action="<?php echo $BASE_URL; ?>/carrinho.php?action=adicionar" style="display: none;" id="form-<?php echo $id; ?>">
                <input type="hidden" name="id_produto" value="<?php echo $id; ?>">
                <input type="hidden" name="quantidade" value="1">
              </form>
              <button class="card-btn" onclick="document.getElementById('form-<?php echo $id; ?>').submit(); return false;">
                🛒 Adicionar ao Carrinho
              </button>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  <?php endif; ?>
</main>

<script src="<?php echo $BASE_URL; ?>/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo $BASE_URL; ?>/js/bootstrap.bundle.min.js"></script>

</body>
</html>
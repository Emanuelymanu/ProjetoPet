<?php
// Pedido view — arquivo completo corrigido para evitar erro de sintaxe
// Define BASE_URL dinâmico e garante variáveis esperadas pelo Controller

// Calcula BASE_URL relativo à pasta public (ajuste se necessário)
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$BASE_URL = rtrim($scriptDir, '/');

// Variáveis que o controller deve injetar
if (!isset($carrinho_itens) || !is_array($carrinho_itens)) {
    $carrinho_itens = [];
}
if (!isset($total_carrinho)) {
    $total_carrinho = 0;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Meu Carrinho — Império Animal</title>
<link rel="stylesheet" href="<?php echo $BASE_URL; ?>/css/style.css">
<style>
:root{ --bg:#f0f4f7; --card:#ffffff; --primary:#d96a87; --muted:#333; --border:#eee; --radius:16px; }
*{ box-sizing:border-box }
html, body{ margin:0; padding:0; width:100%; overflow-x:hidden; }
body{ font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, Arial; background:var(--bg); color:#222; }
.nav{ width:100%; padding:18px 24px; display:flex; gap:20px; align-items:center; justify-content:space-between; background:linear-gradient(180deg, #0d0d0d, rgba(0,0,0,0.65)); position:sticky; top:0; z-index:40; border-bottom: 1px solid rgba(0,0,0,0.04); }
.search-wrap{ flex:1; display:flex; justify-content:center; }
.search{ width:70%; min-width:260px; max-width:720px; display:flex; align-items:center; gap:10px; background:var(--card); padding:10px 14px; border-radius:30px; box-shadow:0 6px 18px rgba(16,24,40,0.06); border:1px solid rgba(16,24,40,0.04); }
.cart-items{ display:flex; flex-direction:column; gap:12px; margin-top:8px; }
.cart-item{ display:flex; gap:12px; align-items:center; padding:8px; border-radius:10px; background:#fbfbfb; }
.cart-item img{ width:56px; height:56px; border-radius:8px; object-fit:cover; }
.cart-footer{ display:flex; justify-content:space-between; align-items:center; margin-top:12px; gap:12px; }
.btn-primary{ background:var(--primary); color:#fff; padding:10px 14px; border-radius:10px; border:0; cursor:pointer; font-weight:700; }
.container{ max-width:1200px; margin:36px auto; padding:0 24px; display:flex; gap:28px; }
.left{flex:1;}
.right{ width:360px; }
.cart-card{ background:var(--card); border-radius:var(--radius); padding:22px; border:1px solid var(--border); }
.cart-header{ display:grid; grid-template-columns:1fr 140px 120px; gap:12px; padding:6px 6px 20px; border-bottom:1px solid var(--border); align-items:center; }
.thumb{ width:72px; height:72px; border-radius:8px; background:#f7f7f7; flex:0 0 72px; display:flex; align-items:center; justify-content:center; border:1px solid var(--border); }
.item-info{flex:1;}
.item-title{ font-weight:600; color:#3d2a30; margin-bottom:6px; }
.item-meta{ color:#6b4750; font-size:13px; }
.qty{ display:flex; align-items:center; gap:10px; justify-content:center; }
.qty a{ width:36px; height:36px; border-radius:18px; border:1px solid var(--border); background:#fff; font-weight:700; cursor:pointer; display:grid; place-items:center; color: inherit; text-decoration: none; }
.qty input{ width:56px; height:36px; border-radius:8px; border:1px solid var(--border); text-align:center; }
.remove{ color:#6b4750; font-weight:700; cursor:pointer; }
.summary{ background:var(--card); border-radius:var(--radius); padding:22px; border:1px solid var(--border); position:sticky; top:36px; }
.btn-checkout{ display:block; width: 100%; margin-top:18px; padding:18px; border-radius:40px; background:linear-gradient(90deg,var(--primary),var(--primary)); color:#fff; border:none; font-weight:900; letter-spacing:1px; cursor:pointer; }
@media (max-width:980px){ .container{ flex-direction:column; padding:0 18px; } .right{ width:100%; } }
</style>
</head>
<body>

<header class="nav" role="navigation" aria-label="Navegação principal">
  <div class="nav-logo">
    <img src="<?php echo $BASE_URL; ?>/img/logo.png" alt="Logo Império Animal" style="height:42px;">
  </div>

  <div class="search-wrap" aria-hidden="false">
    <div class="search" role="search" aria-label="Pesquisar produtos">
      <input id="searchInput" type="search" placeholder="Pesquisar ração, brinquedo, petisco..." aria-label="Pesquisar"/>
      <div class="icon" title="Pesquisar">🔎</div>
    </div>
  </div>

  <div class="nav-icons" aria-hidden="false">
    <button id="btnLogin" class="btn-icon" aria-expanded="false" aria-controls="loginPanel">👤 <span style="font-weight:600">Login</span></button>
    <button id="btnCart" class="btn-icon" aria-expanded="false" aria-controls="cartPanel">🛒 <span style="font-weight:600">Carrinho</span></button>
  </div>
</header>

<main class="container">
  <div class="left">
    <h1>Meu Carrinho</h1>

    <div class="cart-card">
      <div class="cart-header">
        <strong>LISTA DE PRODUTOS</strong>
        <strong style="text-align:center">QUANTIDADE</strong>
        <strong style="text-align:center">TOTAL</strong>
      </div>

      <div style="padding:12px">
<?php if (empty($carrinho_itens)): ?>
        <p style="text-align: center; color: #5b3b43; padding: 30px;">
            Seu carrinho está vazio.
        </p>
<?php else:
        foreach ($carrinho_itens as $item):
            $id_produto = isset($item['produto_id']) ? $item['produto_id'] : (isset($item['produtoId']) ? $item['produtoId'] : 0);
            $nome = $item['nome'] ?? 'Produto';
            $preco = isset($item['preco']) ? (float)$item['preco'] : 0.0;
            $qtd = isset($item['quantidade']) ? (int)$item['quantidade'] : 1;
            $imagem = $item['imagem'] ?? '';
            $total_item = $preco * $qtd;
?>
          <div class="cart-item">
            <div class="thumb">
              <img src="<?php echo $imagem ? htmlspecialchars($imagem) : 'https://via.placeholder.com/150x150?text=Produto'; ?>" alt="<?php echo htmlspecialchars($nome); ?>" style="width:72px;height:72px;object-fit:cover;border-radius:8px;">
            </div>

            <div class="item-info">
              <div class="item-title"><?php echo htmlspecialchars($nome); ?></div>
              <div class="item-meta">R$ <?php echo number_format($preco, 2, ',', '.'); ?> por unidade</div>
            </div>

            <div style="display:flex;flex-direction:column;align-items:center;gap:8px">
              <div class="qty">
                <a href="<?php echo $BASE_URL; ?>/carrinho.php?action=adicionar&id=<?php echo $id_produto; ?>&quantidade=-1">-</a>
                <input type="number" value="<?php echo $qtd; ?>" min="1" readonly>
                <a href="<?php echo $BASE_URL; ?>/carrinho.php?action=adicionar&id=<?php echo $id_produto; ?>&quantidade=1">+</a>
              </div>
              <a class="remove" href="<?php echo $BASE_URL; ?>/carrinho.php?action=remover&id=<?php echo $id_produto; ?>">
                  Remover
              </a>
            </div>

            <div style="width:120px;text-align:center;font-weight:700">
              <span>R$ <?php echo number_format($total_item, 2, ',', '.'); ?></span>
            </div>
          </div>
<?php
        endforeach;
      endif;
?>
      </div>
    </div>
  </div>

  <aside class="right">
    <div class="summary">
      <h3>Resumo da Compra</h3>

      <div style="display:flex;justify-content:space-between;margin-top:12px;">
        <span>Total</span>
        <span>R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?></span>
      </div>

      <div style="display:flex;justify-content:space-between;margin-top:8px;">
        <span>Frete</span><span id="valorFrete">—</span>
      </div>

      <div style="display:flex;justify-content:space-between;margin-top:12px;font-weight:700;">
        <span>Subtotal</span>
        <span id="subtotal">R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?></span>
      </div>

      <form method="post" action="<?php echo $BASE_URL; ?>/pedido.php?action=finalizar" style="margin-top:16px;">
        <button type="submit" class="btn-checkout">FINALIZAR PEDIDO</button>
      </form>
    </div>
  </aside>
</main>

</body>
</html>
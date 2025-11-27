<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Meu Carrinho — imperio animal</title>
<header class="nav" role="navigation" aria-label="Navegação principal">



<div class="nav-logo">
  <img src="img/logo.png" alt="Logo Imperio Animal">
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



<div class="overlay" id="overlayRoot" aria-hidden="true">

  <section id="loginPanel" class="panel" role="dialog" aria-modal="true" aria-labelledby="loginTitle" style="left:50%;">
    <button class="close-x" data-close="loginPanel" title="Fechar">✕</button>
    <h3 id="loginTitle">Entrar / Perfil</h3>

    <div class="login-area">
      <div class="avatar-preview" id="avatarPreview" title="Foto do usuário">
       
        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4s-4 1.79-4 4 1.79 4 4 4z" stroke="#cfcfcf" stroke-width="1.2"/>
          <path d="M4 20c0-4 4-6 8-6s8 2 8 6" stroke="#cfcfcf" stroke-width="1.2"/>
        </svg>
      </div>

   
      <label style="display:flex;gap:8px;align-items:center;width:100%;justify-content:center;">
        <input id="fileInput" type="file" accept="image/*" style="display:none">
        <button class="btn-primary" id="btnUpload">Enviar Foto</button>
      </label>

      <input class="input" id="nomeInput" placeholder="Seu nome" />
      <input class="input" placeholder="E-mail" type="email" />
      <div style="width:100%;display:flex;gap:8px;">
        <button class="btn-primary" style="flex:1">Entrar</button>
        <button class="btn-primary" style="flex:1;background:#eee;color:var(--primary)">Cadastrar</button>
      </div>
    </div>
  </section>







 
  <aside id="cartPanel" class="panel" role="region" aria-labelledby="cartTitle" style="left:50%; top:55%;">
    <button class="close-x" data-close="cartPanel" title="Fechar">✕</button>
    <h3 id="cartTitle">Carrinho</h3>

    <div class="cart-items" id="cartItems">
    
      <div class="cart-item">
        <img src="https://via.placeholder.com/80x80?text=Pet" alt="Produto 1" />
        <div class="meta">
          <div class="title">Ração Premium</div>
          <div style="font-size:13px;color:#666">1 unidade</div>
        </div>
        <div class="price">R$ 49,90</div>
      </div>

      <div class="cart-item">
        <img src="https://via.placeholder.com/80x80?text=Snack" alt="Produto 2" />
        <div class="meta">
          <div class="title">Petisco</div>
          <div style="font-size:13px;color:#666">2 unidades</div>
        </div>
        <div class="price">R$ 25,00</div>
      </div>
    </div>


    <div class="cart-footer">
      <div style="font-weight:700;color:var(--primary)">Subtotal: R$ 74,90</div>
      <a href="pedido.php" class="btn-primary">Finalizar</a>

    </div>
  </aside>
</div>

<script>
  
  const btnLogin = document.getElementById('btnLogin');
  const btnCart  = document.getElementById('btnCart');
  const loginPanel = document.getElementById('loginPanel');
  const cartPanel = document.getElementById('cartPanel');
  const overlay = document.getElementById('overlayRoot');


  function togglePanel(panel, open){
    if(open){
      panel.classList.add('show');
      overlay.style.pointerEvents = 'auto';
      overlay.setAttribute('aria-hidden','false');
    } else {
      panel.classList.remove('show');
      
      setTimeout(() => {
        if(!loginPanel.classList.contains('show') && !cartPanel.classList.contains('show')){
          overlay.style.pointerEvents = 'none';
          overlay.setAttribute('aria-hidden','true');
        }
      }, 420);
    }
  }

  btnLogin.addEventListener('click', ()=> {
    const aberto = loginPanel.classList.contains('show');
    togglePanel(loginPanel, !aberto);
  
    if(!aberto) togglePanel(cartPanel, false);
  });

  btnCart.addEventListener('click', ()=> {
    const aberto = cartPanel.classList.contains('show');
    togglePanel(cartPanel, !aberto);
    if(!aberto) togglePanel(loginPanel, false);
  });

  
  document.querySelectorAll('[data-close]').forEach(btn=>{
    btn.addEventListener('click', (e)=>{
      const id = btn.getAttribute('data-close');
      document.getElementById(id).classList.remove('show');
      setTimeout(()=> {
        if(!loginPanel.classList.contains('show') && !cartPanel.classList.contains('show')){
          overlay.style.pointerEvents = 'none'; overlay.setAttribute('aria-hidden','true');
        }
      }, 420);
    });
  });

  overlay.addEventListener('click', (e)=>{
  
    if(e.target === overlay){
      loginPanel.classList.remove('show');
      cartPanel.classList.remove('show');
      overlay.style.pointerEvents='none';
      overlay.setAttribute('aria-hidden','true');
    }
  });

  const fileInput = document.getElementById('fileInput');
  const btnUpload = document.getElementById('btnUpload');
  const avatarPreview = document.getElementById('avatarPreview');

  btnUpload.addEventListener('click', ()=> fileInput.click());
  fileInput.addEventListener('change', (e)=>{
    const file = e.target.files[0];
    if(!file) return;
    const url = URL.createObjectURL(file);

    avatarPreview.innerHTML = '';
    const img = document.createElement('img');
    img.src = url;
    img.alt = 'Avatar do usuário';
    avatarPreview.appendChild(img);
  });


  document.addEventListener('keydown', (e)=>{
    if(e.key === 'Escape'){
      loginPanel.classList.remove('show');
      cartPanel.classList.remove('show');
      overlay.style.pointerEvents='none';
      overlay.setAttribute('aria-hidden','true');
    }
  });


  overlay.style.pointerEvents = 'none';
</script>
<style>
:root{
  --bg: #ffffff;         
  --primary: #d96a87;    
  --accent: #4c8bff;    
  --card: #ffffff;       
  --glass: rgba(255, 255, 255, 0.06);
}

*{ box-sizing:border-box }

html, body{
  margin:0;
  padding:0;
  width:100%;
  overflow-x:hidden;     
}

body{
  font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, Arial;
  background:var(--bg);
  color:#222;
  -webkit-font-smoothing:antialiased;
}



.nav{
  width:100%;
  padding:18px 24px;
  display:flex;
  gap:20px;
  align-items:center;
  justify-content:space-between;
  background:linear-gradient(180deg, #0d0d0d, rgba(0,0,0,0.65));
  backdrop-filter: blur(6px);
  position:sticky;
  top:0;
  z-index:40;
  border-bottom: 1px solid rgba(0,0,0,0.04);
}

.nav-left{
  display:flex;
  gap:18px;
  align-items:center;
  flex:1;
}

.search-wrap{
  flex:1;
  display:flex;
  justify-content:center;
}

.search{
  width:70%;
  min-width:260px;
  max-width:720px;
  display:flex;
  align-items:center;
  gap:10px;
  background:var(--card);
  padding:10px 14px;
  border-radius:30px;
  box-shadow:0 6px 18px rgba(16,24,40,0.06);
  border:1px solid rgba(16,24,40,0.04);
}

.search input{
  border:0;
  outline:0;
  font-size:16px;
  flex:1;
  background:transparent;
}

.search .icon{
  width:36px;height:36px;border-radius:50%;display:grid;place-items:center;
  font-size:18px;color:var(--primary);
}

.nav-icons{
  display:flex;
  gap:12px;
  align-items:center;
  margin-left:8px;
}

.btn-icon{
  background:transparent;
  border:0;
  outline:0;
  padding:10px;
  display:flex;
  gap:8px;
  align-items:center;
  cursor:pointer;
  border-radius:8px;
  font-weight:600;
  color:var(--primary);
}

.btn-icon:hover{
  background: rgba(91,35,48,0.04);
}

.nav-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100px;       
  padding: 10px 40px;   
}

.nav-logo img {
  height: 100%;
  object-fit: contain;
}
.nav-logo img {
  border-radius: 25px;
}



.overlay{
  position:fixed;
  inset:0;
  pointer-events:none;
  z-index:50;
}

.panel{
  position:fixed;
  top:50%;
  left:50%;
  transform: translate(-50%, -50%) translateX(-120%);
  min-width:320px;
  max-width:420px;
  width:clamp(300px, 40vw, 420px);
  background:var(--card);
  border-radius:14px;
  box-shadow:0 18px 40px rgba(16,24,40,0.18);
  padding:18px;
  transition: transform 420ms cubic-bezier(.2,.9,.2,1), opacity 220ms;
  opacity:0;
  pointer-events:auto;
}

.panel.show{
  transform: translate(-50%, -50%) translateX(0);
  opacity:1;
}

.panel h3{
  margin:0 0 12px 0;
  color:var(--primary);
  font-size:20px;
  text-align:center;
}

.close-x{
  position:absolute; right:10px; top:8px;
  cursor:pointer; color:rgba(0,0,0,0.5);
  font-size:18px; padding:8px;
  border-radius:8px;
}

.close-x:hover{
  background: rgba(0,0,0,0.03);
}

.cart-items{ display:flex; flex-direction:column; gap:12px; margin-top:8px; }
.cart-item{ display:flex; gap:12px; align-items:center; padding:8px; border-radius:10px; background:#fbfbfb; }
.cart-item img{ width:56px; height:56px; border-radius:8px; object-fit:cover; }
.cart-item .meta{ flex:1; }
.cart-item .meta .title{ font-weight:700; color:var(--primary); }
.cart-item .meta .price{ font-weight:700; color:var(--primary); }

.cart-footer{
  display:flex; justify-content:space-between;
  align-items:center; margin-top:12px; gap:12px;
}

.btn-primary{
  background:var(--primary); color:#fff;
  padding:10px 14px; border-radius:10px;
  border:0; cursor:pointer; font-weight:700;
}


.login-area{
  display:flex; gap:12px; flex-direction:column; align-items:center;
}

.avatar-preview{
  width:96px; height:96px; border-radius:50%;
  background:linear-gradient(180deg,#fff,#f0f0f0);
  display:grid; place-items:center;
  border:2px dashed rgba(91,35,48,0.08);
  overflow:hidden;
}

.avatar-preview img{
  width:100%; height:100%;
  object-fit:cover; display:block;
}

.input{
  width:100%; padding:10px 12px;
  border-radius:10px;
  border:1px solid rgba(16,24,40,0.06);
  background:#fff;
}

.wrap{
  max-width:1200px;
  margin:28px auto;
  padding:0 20px;
}

header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
header h1{margin:0;font-size:1.6rem}
header p{margin:0;color:#6b7280}
</style>
<style>
  :root{
    --bg:#f0f4f7;
    --card:#ffffff;
    --accent:#333;
    --accent-dark:#333;
    --muted:#333;
    --border:#333;
    --radius:16px;
    --maxw:1100px;
  }

  *{box-sizing:border-box;margin:0;padding:0}

  body{
    margin:0;
    font-family:Inter,Segoe UI,Arial,sans-serif;
    background:var(--bg);
    color:#2b1b22;
  }


  header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:28px 32px;
    background:#fff;
    border-bottom:1px solid var(--border);
  }

  .logo{
    display:flex;
    align-items:center;
    gap:16px;
  }


  .logo img{
    height:80px;
    border-radius: 20px;
  }

  .secure{
    color:var(--muted);
    font-weight:600;
  }


  .container{
    max-width:1200px;
    margin:36px auto;
    padding:0 24px;
    display:flex;
    gap:28px;
  }

  
  .left{flex:1;}

  h1{
    font-size:20px;
    margin-bottom:18px;
    color:#3a2a31;
  }

  .cart-card{
    background:var(--card);
    border-radius:var(--radius);
    padding:22px;
    border:1px solid var(--border);
  }

  .cart-header{
    display:grid;
    grid-template-columns:1fr 140px 120px;
    gap:12px;
    padding:6px 6px 20px;
    border-bottom:1px solid var(--border);
    align-items:center;
  }

  .cart-header strong{
    color:#5b3b43;
    letter-spacing:0.6px;
  }

  .cart-item{
    display:flex;
    gap:18px;
    align-items:center;
    padding:18px 6px;
  }

  .thumb{
    width:72px;
    height:72px;
    border-radius:8px;
    background:#f7f7f7;
    flex:0 0 72px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid var(--border);
  }

  .thumb img{
    max-width:100%;
    max-height:100%;
  }

  .item-info{flex:1;}

  .item-title{
    font-weight:600;
    color:#3d2a30;
    margin-bottom:6px;
  }

  .item-meta{
    color:#6b4750;
    font-size:13px;
  }

  .subscription{
    display:inline-block;
    margin-top:8px;
    color:var(--accent-dark);
    font-weight:600;
    text-decoration:none;
  }

  .warning{
    margin-top:12px;
    color:#b35400;
    font-weight:700;
    display:flex;
    align-items:center;
    gap:8px;
  }

  .qty{
    display:flex;
    align-items:center;
    gap:10px;
    justify-content:center;
  }

  .qty button{
    width:36px;
    height:36px;
    border-radius:18px;
    border:1px solid var(--border);
    background:#fff;
    font-weight:700;
    cursor:pointer;
  }

  .qty input{
    width:56px;
    height:36px;
    border-radius:8px;
    border:1px solid var(--border);
    text-align:center;
  }

  .remove{
    color:#6b4750;
    font-weight:700;
    cursor:pointer;
  }

  .right{
    width:360px;
  }

  .summary{
    background:var(--card);
    border-radius:var(--radius);
    padding:22px;
    border:1px solid var(--border);
    position:sticky;
    top:36px;
  }

  .summary h3{
    margin-bottom:18px;
    color:#3a2a31;
  }

  .row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px 0;
    border-bottom:1px solid var(--border);
  }

  .total{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 0;
    font-weight:800;
  }

  .btn-checkout{
    display:block;
    margin-top:18px;
    padding:18px;
    border-radius:40px;
    background:linear-gradient(90deg,var(--accent),var(--accent-dark));
    color:#fff;
    border:none;
    font-weight:900;
    letter-spacing:1px;
    cursor:pointer;
  }


  @media (max-width:980px){
    .container{
      flex-direction:column;
      padding:0 18px;
    }
    .right{
      width:100%;
    }
  }

</style>
</head>
<body>


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
        <div class="cart-item">

          <div class="thumb">
            <img src="" alt="">
          </div>

          <div class="item-info">
            <div class="item-title"></div>
            <div class="item-meta"></div>
            <a class="subscription" href="#"></a>
            <div class="warning"></div>
          </div>

          <div style="display:flex;flex-direction:column;align-items:center;gap:8px">
            <div class="qty">
              <button>-</button>
              <input type="number" value="" min="1">
              <button>+</button>
            </div>
            <div class="remove"></div>
          </div>

          <div style="width:120px;text-align:center;font-weight:700">
            <span id="totalItem"></span>
          </div>

        </div>
      </div>


    </div>
  </div>


  <aside class="right">
    <div class="summary">
      <h3>Resumo da Compra</h3>

      <div class="row"><span>Total</span><span></span></div>
      <div class="row"><span>Frete</span><span id="valorFrete">—</span></div>

      <div class="total">
        <span>Subtotal</span>
        <span id="subtotal"></span>
      </div>

      <button class="btn-checkout">FINALIZAR PEDIDO</button>
    </div>
  </aside>
</main>

</body>
</html>

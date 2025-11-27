<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link rel="stylesheet" href="index.css">
<title>Catálogo - Pet Shop</title>

  


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


<div class="banner">
  <img src="img/banner.jpg" alt="Banner">
</div>



<div class="wrap">

<header>
  <div>
    <h1>Catálogo - Pet Shop</h1>
    <p>Produtos organizados por espécie .</p>
  </div>
</header>

<main>

<section class="species" id="cachorro">
  <h2>
    <span class="spec-title">🐶 Cachorro</span>
    <span class="arrows">
      <button class="arrow-btn left" data-target="cachorro">←</button>
      <button class="arrow-btn right" data-target="cachorro">→</button>
    </span>
  </h2>

  <p class="spec-desc">Produtos essenciais para cães: alimentação, higiene, conforto e diversão.</p>

  <div class="carousel" id="carousel-cachorro">
  
    <div class="card"><div class="thumb">Imagem Ração 10kg</div><div class="card-row"><div class="title">Ração Premium Adulto – 10kg</div><div class="price">R$129,90</div></div><div class="meta">Alta digestibilidade · Enriquecida</div></div>

    <div class="card"><div class="thumb">Imagem Shampoo</div><div class="card-row"><div class="title">Shampoo Hipoalergênico</div><div class="price">R$39,90</div></div><div class="meta">pH balanceado</div></div>

    <div class="card"><div class="thumb">Imagem Cama</div><div class="card-row"><div class="title">Cama Acolchoada M</div><div class="price">R$159,90</div></div><div class="meta">Antialergênica</div></div>

    <div class="card"><div class="thumb">Imagem Coleira</div><div class="card-row"><div class="title">Coleira Reforçada</div><div class="price">R$69,90</div></div><div class="meta">Várias cores</div></div>

    <div class="card"><div class="thumb">Imagem Brinquedo</div><div class="card-row"><div class="title">Mordedor Borracha</div><div class="price">R$24,90</div></div><div class="meta">Alta durabilidade</div></div>

    <div class="card"><div class="thumb">Imagem Petisco</div><div class="card-row"><div class="title">Petisco de Frango 300g</div><div class="price">R$19,90</div></div><div class="meta">Sem corantes</div></div>
  </div>
</section>
<section class="species" id="gato">
  <h2>
    <span class="spec-title">🐱 Gato</span>
    <span class="arrows">
      <button class="arrow-btn left" data-target="gato">←</button>
      <button class="arrow-btn right" data-target="gato">→</button>
    </span>
  </h2>

  <p class="spec-desc">Produtos essenciais para gatos: alimentação, higiene e entretenimento.</p>

  <div class="carousel" id="carousel-gato">

    <div class="card"><div class="thumb">Imagem Ração</div><div class="card-row"><div class="title">Ração Super Premium – 5kg</div><div class="price">R$98,90</div></div><div class="meta">Redução de bolas de pelo</div></div>

    <div class="card"><div class="thumb">Imagem Areia</div><div class="card-row"><div class="title">Areia Sanitária Perfumada – 4kg</div><div class="price">R$22,90</div></div><div class="meta">Controle de odores</div></div>

    <div class="card"><div class="thumb">Imagem Arranhador</div><div class="card-row"><div class="title">Arranhador Compacto</div><div class="price">R$69,90</div></div><div class="meta">Poste resistente</div></div>

    <div class="card"><div class="thumb">Imagem Fonte</div><div class="card-row"><div class="title">Fonte de Água para Gatos</div><div class="price">R$79,90</div></div><div class="meta">Recirculação e filtragem</div></div>

    <div class="card"><div class="thumb">Imagem Varinha</div><div class="card-row"><div class="title">Brinquedo Varinha com Pena</div><div class="price">R$14,90</div></div><div class="meta">Interativo</div></div>

    <div class="card"><div class="thumb">Imagem Cama</div><div class="card-row"><div class="title">Cama Redonda Antiestresse</div><div class="price">R$59,90</div></div><div class="meta">Tecido macio</div></div>

  </div>
</section>
<section class="species" id="peixe">
  <h2>
    <span class="spec-title">🐠 Peixes</span>
    <span class="arrows">
      <button class="arrow-btn left" data-target="peixe">←</button>
      <button class="arrow-btn right" data-target="peixe">→</button>
    </span>
  </h2>

  <p class="spec-desc">Produtos para aquarismo: ração, decoração e equipamentos.</p>

  <div class="carousel" id="carousel-peixe">

    <div class="card"><div class="thumb">Imagem Ração</div><div class="card-row"><div class="title">Ração Flocada Tropical – 50g</div><div class="price">R$9,90</div></div><div class="meta">Nutrição equilibrada</div></div>

    <div class="card"><div class="thumb">Imagem Filtro</div><div class="card-row"><div class="title">Filtro para Aquário 20–40L</div><div class="price">R$59,90</div></div><div class="meta">Baixo consumo</div></div>

    <div class="card"><div class="thumb">Imagem Aquecedor</div><div class="card-row"><div class="title">Aquecedor 50W para Aquário</div><div class="price">R$49,90</div></div><div class="meta">Temperatura estável</div></div>

    <div class="card"><div class="thumb">Imagem Pedras</div><div class="card-row"><div class="title">Pedras Decorativas Naturais</div><div class="price">R$14,90</div></div><div class="meta">Não altera pH</div></div>

    <div class="card"><div class="thumb">Imagem Castelo</div><div class="card-row"><div class="title">Enfeite Castelo Submerso</div><div class="price">R$24,90</div></div><div class="meta">Seguro para peixes</div></div>

    <div class="card"><div class="thumb">Imagem Teste</div><div class="card-row"><div class="title">Kit de Teste de pH</div><div class="price">R$19,90</div></div><div class="meta">Medição precisa</div></div>

  </div>
</section>
<section class="species" id="passaro">
  <h2>
    <span class="spec-title">🐦 Pássaros</span>
    <span class="arrows">
      <button class="arrow-btn left" data-target="passaro">←</button>
      <button class="arrow-btn right" data-target="passaro">→</button>
    </span>
  </h2>

  <p class="spec-desc">Alimentos, acessórios e cuidados para aves domésticas.</p>

  <div class="carousel" id="carousel-passaro">

    <div class="card"><div class="thumb">Imagem Sementes</div><div class="card-row"><div class="title">Mistura de Sementes – 500g</div><div class="price">R$12,90</div></div><div class="meta">Rica em nutrientes</div></div>

    <div class="card"><div class="thumb">Imagem Bebedouro</div><div class="card-row"><div class="title">Bebedouro Automático Cristal</div><div class="price">R$8,90</div></div><div class="meta">Água sempre limpa</div></div>

    <div class="card"><div class="thumb">Imagem Comedouro</div><div class="card-row"><div class="title">Comedouro Suspenso</div><div class="price">R$9,90</div></div><div class="meta">Fácil instalação</div></div>

    <div class="card"><div class="thumb">Imagem Vitamina</div><div class="card-row"><div class="title">Vitamina Líquida para Plumagem</div><div class="price">R$21,90</div></div><div class="meta">Brilho das penas</div></div>

    <div class="card"><div class="thumb">Imagem Gaiola</div><div class="card-row"><div class="title">Gaiola Média com Bandeja</div><div class="price">R$179,90</div></div><div class="meta">Incluso poleiros</div></div>

    <div class="card"><div class="thumb">Imagem Poleiro</div><div class="card-row"><div class="title">Poleiro Natural de Madeira</div><div class="price">R$17,90</div></div><div class="meta">Seguro e confortável</div></div>

  </div>
</section>
<section class="species" id="hamster">
  <h2>
    <span class="spec-title">🐹 Hamster</span>
    <span class="arrows">
      <button class="arrow-btn left" data-target="hamster">←</button>
      <button class="arrow-btn right" data-target="hamster">→</button>
    </span>
  </h2>

  <p class="spec-desc">Produtos essenciais para hamsters: conforto, brincadeira e bem-estar.</p>

  <div class="carousel" id="carousel-hamster">

    <div class="card"><div class="thumb">Imagem Ração</div><div class="card-row"><div class="title">Ração Completa – 300g</div><div class="price">R$15,90</div></div><div class="meta">Balanceada para todas as fases</div></div>

    <div class="card"><div class="thumb">Imagem Rodinha</div><div class="card-row"><div class="title">Rodinha Silenciosa</div><div class="price">R$34,90</div></div><div class="meta">Funcionamento anti-ruído</div></div>

    <div class="card"><div class="thumb">Imagem Casinha</div><div class="card-row"><div class="title">Casinha Colorida de Plástico</div><div class="price">R$19,90</div></div><div class="meta">Fácil de limpar</div></div>

    <div class="card"><div class="thumb">Imagem Túnel</div><div class="card-row"><div class="title">Túnel Flexível</div><div class="price">R$24,90</div></div><div class="meta">Estimula atividade física</div></div>

    <div class="card"><div class="thumb">Imagem Banheiro</div><div class="card-row"><div class="title">Banheiro com Areia Especial</div><div class="price">R$12,90</div></div><div class="meta">Ajuda na higiene</div></div>

    <div class="card"><div class="thumb">Imagem Garrafinha</div><div class="card-row"><div class="title">Garrafinha Antivazamento</div><div class="price">R$16,90</div></div><div class="meta">Sistema de rosca seguro</div></div>

  </div>
</section>
<section class="species" id="coelho">
  <h2>
    <span class="spec-title">🐰 Coelho</span>
    <span class="arrows">
      <button class="arrow-btn left" data-target="coelho">←</button>
      <button class="arrow-btn right" data-target="coelho">→</button>
    </span>
  </h2>

  <p class="spec-desc">Itens essenciais para coelhos: alimentação, abrigo e cuidados.</p>

  <div class="carousel" id="carousel-coelho">

    <div class="card"><div class="thumb">Imagem Feno</div><div class="card-row"><div class="title">Feno de Alfafa – 1kg</div><div class="price">R$34,90</div></div><div class="meta">Rico em fibras</div></div>

    <div class="card"><div class="thumb">Imagem Ração</div><div class="card-row"><div class="title">Ração Nutritiva – 500g</div><div class="price">R$24,90</div></div><div class="meta">Fortalece dentes e pelos</div></div>

    <div class="card"><div class="thumb">Imagem Comedouro</div><div class="card-row"><div class="title">Comedouro Pesado Antivirada</div><div class="price">R$29,90</div></div><div class="meta">Material cerâmico</div></div>

    <div class="card"><div class="thumb">Imagem Casinha</div><div class="card-row"><div class="title">Casinha de Madeira Grande</div><div class="price">R$129,90</div></div><div class="meta">Ambiente seguro e confortável</div></div>

    <div class="card"><div class="thumb">Imagem Mordedor</div><div class="card-row"><div class="title">Brinquedo Mordedor de Madeira</div><div class="price">R$14,90</div></div><div class="meta">Desgaste dental saudável</div></div>

    <div class="card"><div class="thumb">Imagem Areia</div><div class="card-row"><div class="title">Areia Higiênica Vegetal – 2kg</div><div class="price">R$29,90</div></div><div class="meta">Controle de odores</div></div>

  </div>
</section>
<section class="species" id="tartaruga">
  <h2>
    <span class="spec-title">🐢 Tartaruga</span>
    <span class="arrows">
      <button class="arrow-btn left" data-target="tartaruga">←</button>
      <button class="arrow-btn right" data-target="tartaruga">→</button>
    </span>
  </h2>

  <p class="spec-desc">Produtos para tartarugas: ração, iluminação e habitat.</p>

  <div class="carousel" id="carousel-tartaruga">

    <div class="card"><div class="thumb">Imagem Ração</div><div class="card-row"><div class="title">Ração Flutuante – 250g</div><div class="price">R$39,90</div></div><div class="meta">Crescimento saudável</div></div>

    <div class="card"><div class="thumb">Imagem Luz UVB</div><div class="card-row"><div class="title">Iluminação UVB</div><div class="price">R$89,90</div></div><div class="meta">Vitamina D essencial</div></div>

    <div class="card"><div class="thumb">Imagem Filtro</div><div class="card-row"><div class="title">Filtro Interno</div><div class="price">R$64,90</div></div><div class="meta">Mantém a água limpa</div></div>

    <div class="card"><div class="thumb">Imagem Plataforma</div><div class="card-row"><div class="title">Plataforma Flutuante</div><div class="price">R$29,90</div></div><div class="meta">Área de descanso</div></div>

    <div class="card"><div class="thumb">Imagem Termômetro</div><div class="card-row"><div class="title">Termômetro e Higrômetro</div><div class="price">R$39,90</div></div><div class="meta">Monitoramento preciso</div></div>

    <div class="card"><div class="thumb">Imagem Cascalho</div><div class="card-row"><div class="title">Cascalho Natural</div><div class="price">R$19,90</div></div><div class="meta">Seguro e estético</div></div>

  </div>
</section>
<section class="species" id="furao">
  <h2>
    <span class="spec-title">🦦 Furão</span>
    <span class="arrows">
      <button class="arrow-btn left" data-target="furao">←</button>
      <button class="arrow-btn right" data-target="furao">→</button>
    </span>
  </h2>

  <p class="spec-desc">Acessórios e cuidados especiais para furões.</p>

  <div class="carousel" id="carousel-furao">

    <div class="card"><div class="thumb">Imagem Ração</div><div class="card-row"><div class="title">Ração Especializada – 1kg</div><div class="price">R$74,90</div></div><div class="meta">Alta proteína</div></div>

    <div class="card"><div class="thumb">Imagem Rede</div><div class="card-row"><div class="title">Hamacão de Descanso</div><div class="price">R$39,90</div></div><div class="meta">Confortável e resistente</div></div>

    <div class="card"><div class="thumb">Imagem Túneis</div><div class="card-row"><div class="title">Túneis Interligados</div><div class="price">R$29,90</div></div><div class="meta">Estimula exploração</div></div>

    <div class="card"><div class="thumb">Imagem Areia</div><div class="card-row"><div class="title">Areia de Banho Especial</div><div class="price">R$24,90</div></div><div class="meta">Cuida da pelagem</div></div>

    <div class="card"><div class="thumb">Imagem Coleira</div><div class="card-row"><div class="title">Coleira Ajustável</div><div class="price">R$49,90</div></div><div class="meta">Leve e segura</div></div>

    <div class="card"><div class="thumb">Imagem Spray</div><div class="card-row"><div class="title">Spray Higienizador</div><div class="price">R$29,90</div></div><div class="meta">Desodorizante suave</div></div>

  </div>

</div>
</section>

</main>





<script>
  
  document.querySelectorAll(".arrow-btn").forEach(btn=>{
    btn.addEventListener("click",()=>{
      const id = btn.dataset.target;
      const carousel = document.querySelector("#carousel-"+id);

      const scrollAmount = 220; 

      if(btn.classList.contains("left")){
        carousel.scrollLeft -= scrollAmount;
      } else {
        carousel.scrollLeft += scrollAmount;
      }
    });
  });
</script>


<footer class="footer">
  

 

 <footer class="footer">
  <div class="footer-container">


    <div class="footer-left">
      <h2 class="footer-logo">imperio animal</h2>

      <p class="social-text">Venha ver nossa página nas redes sociais</p>

      <div class="social-icons">
        <a href="#">📸</a>
        <a href="#">📘</a>
        <a href="#">🐦</a>
        <a href="#">📞</a>
      </div>
    </div>

    
    <div class="footer-columns-dupla">

      <div class="footer-col">
        <h3>A empresa</h3>
        <a href="#">imperio animal</a>
        <a href="#">Suporte ao Cliente</a>
        <a href="#">Blog TdB</a>
        <a href="#">Glossário de Nomes Pets</a>
      </div>

      <div class="footer-col">
        <h3>Políticas</h3>
        <a href="#">Termos e Condições</a>
        <a href="#">Frete Grátis</a>
        <a href="#">Trocas e Devoluções</a>
        <a href="#">Assinatura</a>
        <a href="#">Privacidade</a>
        <a href="#">Cookies</a>
        <a href="#">FAQ lojas físicas</a>
      </div>

    </div>

    
    <div class="footer-right">
      <h3>Formas de Pagamento</h3>

      <div class="payments">
        <span>💳 No débito</span>
        <span>💳 Em até 12x no crédito</span>
        <span>⚡ PIX</span>
      </div>
    </div>

  </div>
</footer>



</body>
</html>

<style>:root{
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

.species{
  background:linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.12));
  border-radius:12px;
  padding:18px;
  box-shadow:0 6px 18px rgba(0,0,0,0.2);
  margin-bottom:30px;
}

.species h2{
  margin:0 0 6px 0;
  display:flex;
  align-items:center;
  justify-content:space-between;
}

.spec-title{
  display:flex;
  align-items:center;
  gap:8px;
  font-size:1.2rem;
}

.arrows{
  display:flex;
  gap:10px;
}

.arrow-btn{
  width:34px;height:34px;border-radius:50%;
  border:none;background:#e8f1ff;
  display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;cursor:pointer;transition:.2s;
}

.arrow-btn:hover{ background:#d9e8ff }

.spec-desc{
  margin:4px 0 14px 0;
  color:#6b7280;font-size:0.95rem;
}

.carousel{
  display:flex; gap:12px;
  overflow-x:auto; scroll-behavior:smooth;
  padding-bottom:4px;
}

.card{
  background:var(--card);
  border-radius:10px;
  padding:10px;
  display:flex;
  flex-direction:column;
  gap:8px;
  min-width:180px;
  max-width:180px;
  transition:.12s;
  flex:0 0 auto;
}

.card:hover{
  transform:translateY(-6px);
  box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

.thumb{
  background:linear-gradient(135deg,#262626,#1a1a1a);
  border-radius:8px;
  height:88px;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#aaa;
}

.title{ font-weight:600; font-size:0.95rem; color:#eee; }
.meta{ color:#aaa; font-size:0.86rem; }
.price{ margin-left:auto; font-weight:700; color:var(--accent); }


.banner{
  width:100%; display:flex;
  justify-content:center;
  margin:30px 0;
}
.banner img{
  width:100%; max-width:1200px;
  border-radius:12px;
  display:block;
}

.footer{
  background:#faf7fb;
  padding:40px 0;
  border-top:4px solid #f0d1e8;

}

.footer-container{
  max-width:1300px;
  margin:auto;
  display:flex;
  gap:40px;
  padding:0 20px;
  justify-content: space-between; 
  text-align: left;
}

.footer-left,
.footer-center,
.footer-right{
  flex:1;
  display:flex;
  flex-direction:column;

  align-items: flex-start;
  text-align: left;
}


.social-icons{
  display:flex; gap:12px;

  justify-content: flex-start;
}

.social-icons a{
  font-size:22px;
  text-decoration:none;
  color:#58223c;
  background:#fff;
  padding:8px;
  border-radius:50%;
  width:45px;height:45px;
  display:flex;align-items:center;justify-content:center;
}


.footer-columns-dupla{
  display:flex;
  flex-direction:column;
  gap:10px;

  align-items: flex-start;
}

.footer-columns-dupla a{
  color:#555;
  text-decoration:none;
}


.payments{
  display:flex;
  flex-direction:column;

  align-items: flex-start;
}

.payments span{
  background:#fff;
  padding:8px 12px;
  border-radius:10px;
}

footer, .footer{
  margin:0 !important;
}
</style>
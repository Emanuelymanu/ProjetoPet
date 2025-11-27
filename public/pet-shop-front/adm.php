<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Dashboard — Império Animal</title>
<style>
  :root{
    --bg: #0f1724;
    --panel: #0b1220;
    --muted: #94a3b8;
    --text: #e6eef8;
    --accent: #7c3aed;
    --accent-2: #06b6d4;
    --success: #10b981;
    --danger: #ef4444;
    --glass: rgba(255,255,255,0.03);
    --radius: 12px;
    --gap: 18px;
    --maxw: 1200px;
  }

  /* Light theme (applies when body has class .light) */
  body.light{
    --bg:#f6f8fb;
    --panel:#ffffff;
    --muted:#6b7280;
    --text:#0f1724;
    --glass: rgba(0,0,0,0.03);
  }

  *{box-sizing:border-box}
  html,body{height:100%}
  body{
    margin:0;
    font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;
    background:linear-gradient(180deg,var(--bg), #081021);
    color:var(--text);
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    line-height:1.35;
  }

  /* Layout */
  .app{
    display:flex;
    min-height:100vh;
    gap:var(--gap);
  }

  /* SIDEBAR */
  .sidebar{
    width:260px;
    background:linear-gradient(180deg,var(--panel), rgba(255,255,255,0.02));
    padding:20px;
    border-radius:0 20px 20px 0;
    box-shadow: 0 8px 30px rgba(2,6,23,0.6);
    flex-shrink:0;
    display:flex;
    flex-direction:column;
    gap:18px;
  }
  .brand{display:flex;gap:12px;align-items:center}
  .brand img{width:44px;height:44px;border-radius:10px;object-fit:cover;box-shadow:0 6px 18px rgba(0,0,0,0.4)}
  .brand h1{font-size:1rem;margin:0;font-weight:700}
  .nav{
    display:flex;flex-direction:column;gap:6px;margin-top:8px;
  }
  .nav a{
    display:flex;align-items:center;gap:12px;padding:10px;border-radius:10px;color:var(--muted);text-decoration:none;font-weight:600;
  }
  .nav a:hover, .nav a.active{
    background:var(--glass); color:var(--text);
  }
  .sidebar .meta{font-size:12px;color:var(--muted)}

  /* MAIN */
  .main{
    flex:1;
    padding:28px;
    max-width:calc(100% - 260px);
    min-width:0;
  }

  /* Topbar */
  .topbar{
    display:flex;
    gap:12px;
    align-items:center;
    justify-content:space-between;
    margin-bottom:22px;
  }
  .search{
    display:flex;gap:8px;align-items:center;
    background:var(--panel);padding:8px;border-radius:12px;box-shadow:inset 0 1px 0 rgba(255,255,255,0.02)
  }
  .search input{
    background:transparent;border:0;outline:0;color:var(--text);min-width:220px;
  }
  .top-actions{display:flex;gap:8px;align-items:center}
  .icon-btn{
    background:var(--panel);border:0;padding:8px;border-radius:10px;color:var(--muted);cursor:pointer;
    display:inline-flex;align-items:center;justify-content:center;gap:8px;font-weight:700;
  }
  .icon-btn:hover{color:var(--text);transform:translateY(-2px)}

  /* Cards */
  .grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
    margin-bottom:20px;
  }
  .card{
    background:linear-gradient(180deg, rgba(255,255,255,0.02), transparent);
    padding:16px;border-radius:12px;box-shadow:0 6px 18px rgba(2,6,23,0.5);
    min-width:0;
  }
  .card .k{font-size:12px;color:var(--muted);margin-bottom:6px}
  .card .v{font-size:1.4rem;font-weight:800;color:var(--text)}

  /* Chart area */
  .panel{
    background:linear-gradient(180deg, rgba(255,255,255,0.02), transparent);
    padding:16px;border-radius:12px;box-shadow:0 6px 18px rgba(2,6,23,0.5);
  }
  .chart-row{display:flex;gap:16px;align-items:flex-end}
  .chart-legend{display:flex;gap:10px;align-items:center;font-size:13px;color:var(--muted)}

  /* Table */
  table{width:100%;border-collapse:collapse;font-size:14px}
  thead th{ text-align:left;padding:12px;color:var(--muted);font-weight:700;border-bottom:1px solid rgba(255,255,255,0.03)}
  tbody td{padding:12px 12px;border-bottom:1px dashed rgba(255,255,255,0.02)}
  .badge{padding:6px 10px;border-radius:999px;font-weight:700;font-size:13px}
  .badge.green{background:rgba(16,185,129,0.14);color:var(--success)}
  .badge.orange{background:rgba(245,158,11,0.12);color:#f59e0b}
  .small{font-size:12px;color:var(--muted)}

  /* Responsive */
  @media (max-width:1000px){
    .grid{grid-template-columns:repeat(2,1fr)}
    .sidebar{width:72px;padding:12px;border-radius:0 12px 12px 0}
    .brand h1{display:none}
    .nav a span.label{display:none}
    .main{padding:18px}
  }
  @media (max-width:640px){
    .grid{grid-template-columns:1fr}
    .topbar{flex-direction:column;align-items:stretch;gap:12px}
  }

  /* tiny helpers */
  .muted{color:var(--muted)}
  .flex{display:flex;gap:12px;align-items:center}
  .right{text-align:right}
  .btn{background:var(--accent);color:#fff;border:0;padding:8px 12px;border-radius:10px;cursor:pointer;font-weight:700}
</style>
</head>
<body>

<div class="app" id="app">

  <!-- SIDEBAR -->
  <aside class="sidebar" role="navigation" aria-label="Menu principal">
    <div class="brand">
      <img src="img/logo.png" alt="logo">
      <div>
        <h1>Império Animal</h1>
        <div class="meta small">Admin Dashboard</div>
      </div>
    </div>

    <nav class="nav" aria-label="Seções">
      <a href="#" class="active" data-section="overview">🏠 <span class="label">Visão Geral</span></a>
      <a href="#" data-section="produtos">📦 <span class="label">Produtos</span></a>
      <a href="#" data-section="pedidos">🧾 <span class="label">Pedidos</span></a>
      <a href="#" data-section="clientes">👥 <span class="label">Clientes</span></a>
      <a href="#" data-section="relatorios">📊 <span class="label">Relatórios</span></a>
      <a href="#" data-section="config">⚙️ <span class="label">Configurações</span></a>
    </nav>

    <div style="margin-top:auto">
      <div class="small muted">Versão 1.0 • Novembro 2025</div>
    </div>
  </aside>

  <main class="main">

    <div class="topbar">
      <div style="display:flex;gap:12px;align-items:center">
        <button class="icon-btn" id="toggleTheme" title="Alternar tema">🌓</button>
        <div class="search" role="search" aria-label="Pesquisar">
          <input id="search" placeholder="Pesquisar produtos, pedidos..." />
          <button class="icon-btn" id="btnSearch">🔎</button>
        </div>
      </div>

      <div class="top-actions">
        <button class="icon-btn" id="btnNotify" title="Notificações">🔔 <span class="small muted" id="notifCount">0</span></button>
        <div style="display:flex;gap:12px;align-items:center">
          <div class="small muted right">Olá, Admin</div>
          <img src="" alt="avatar" id="avatarMini" style="width:38px;height:38px;border-radius:8px;background:linear-gradient(90deg,var(--accent),var(--accent-2))">
        </div>
      </div>
    </div>

    <section class="grid" aria-label="Métricas">
      <div class="card">
        <div class="k">Vendas (hoje)</div>
        <div class="v" id="kSales">0</div>
        <div class="small muted">Comparado com ontem: <strong id="kSalesDelta">0%</strong></div>
      </div>

      <div class="card">
        <div class="k">Usuários</div>
        <div class="v" id="kUsers">0</div>
        <div class="small muted">Ativos nos últimos 7 dias</div>
      </div>

      <div class="card">
        <div class="k">Pedidos</div>
        <div class="v" id="kOrders">0</div>
        <div class="small muted">Pedidos pendentes: <strong id="pendingOrders">0</strong></div>
      </div>

      <div class="card">
        <div class="k">Receita</div>
        <div class="v" id="kRevenue">R$0,00</div>
        <div class="small muted">Média por pedido: <strong id="avgOrder">R$0,00</strong></div>
      </div>
    </section>

    <section style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:18px">
      <div class="panel">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
          <div><strong>Vendas nos últimos 30 dias</strong><div class="small muted">Tendência</div></div>
          <div class="chart-legend">
            <span style="display:inline-flex;align-items:center;gap:8px"><span style="width:10px;height:10px;background:linear-gradient(90deg,var(--accent),var(--accent-2));border-radius:3px;display:inline-block"></span>Receita</span>
          </div>
        </div>

        <canvas id="lineChart" width="800" height="260" style="max-width:100%"></canvas>
      </div>

      <div class="panel">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
          <div><strong>Atividades recentes</strong><div class="small muted">Últimas ações</div></div>
          <button class="btn" id="btnRefresh">Atualizar</button>
        </div>

        <ul id="activityList" style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px">
     
        </ul>
      </div>
    </section>

   
    <section class="panel" aria-label="Últimos pedidos">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
        <div><strong>Últimos pedidos</strong><div class="small muted">Pedidos recentes</div></div>
        <div style="display:flex;gap:8px">
          <select id="filterStatus" class="small">
            <option value="">Todos</option>
            <option value="paid">Pago</option>
            <option value="pending">Pendente</option>
            <option value="canceled">Cancelado</option>
          </select>
          <button class="btn" id="exportCsv">Exportar</button>
        </div>
      </div>

      <div style="overflow:auto">
        <table id="ordersTable" aria-describedby="Últimos pedidos">
          <thead>
            <tr>
              <th>Id</th>
              <th>Cliente</th>
              <th>Items</th>
              <th>Total</th>
              <th>Data</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
        </table>
      </div>
    </section>

  </main>
</div>

<script>

const demo = {
  salesToday: 124,
  users: 1024,
  orders: 36,
  revenue: 9450.50,
  avgOrder: 262.51,
  pending: 4,
  notif: 3,
  activities: [
    {text: 'Pedido #1023 marcado como pago', time:'2m'},
    {text: 'Produto "Ração Premium" adicionado', time:'20m'},
    {text: 'Novo usuário registrado: larissa', time:'1h'},
    {text: 'Estoque baixo: Coleira Reforçada', time:'3h'}
  ],
  orders: [
    {id:1026, customer:'Marcos A.', items:3, total:129.90, date:'2025-11-25', status:'paid'},
    {id:1025, customer:'Lúcia M.', items:1, total:59.90, date:'2025-11-25', status:'pending'},
    {id:1024, customer:'João P.', items:2, total:199.80, date:'2025-11-24', status:'paid'},
    {id:1023, customer:'Ana S.', items:4, total:320.00, date:'2025-11-23', status:'canceled'}
  ],
  revenueSeries: (function(){
    // gera 30 pontos fictícios
    const arr=[];
    let v=650;
    for(let i=0;i<30;i++){
      v += (Math.random()-0.4)*120;
      arr.push(Math.max(80, Math.round(v)));
    }
    return arr;
  })()
}


document.addEventListener('DOMContentLoaded',()=>{
  // preencher métricas
  document.getElementById('kSales').textContent = demo.salesToday;
  document.getElementById('kUsers').textContent = demo.users.toLocaleString();
  document.getElementById('kOrders').textContent = demo.orders;
  document.getElementById('kRevenue').textContent = formatBRL(demo.revenue);
  document.getElementById('avgOrder').textContent = formatBRL(demo.avgOrder);
  document.getElementById('pendingOrders').textContent = demo.pending;
  document.getElementById('notifCount').textContent = demo.notif;

 
  const act = document.getElementById('activityList');
  act.innerHTML = demo.activities.map(a=>`<li style="display:flex;justify-content:space-between;align-items:center;padding:8px 6px;border-radius:8px;background:rgba(255,255,255,0.01)"><div>${a.text}<div class="small muted">${a.time}</div></div></li>`).join('');

  renderOrders(demo.orders);


  drawLineChart('lineChart', demo.revenueSeries);


  document.getElementById('btnRefresh').addEventListener('click', refreshDemo);
  document.getElementById('filterStatus').addEventListener('change', (e)=>renderOrders(filterOrders(e.target.value)));
  document.getElementById('exportCsv').addEventListener('click', ()=>exportCsv(demo.orders));
  document.getElementById('toggleTheme').addEventListener('click', toggleTheme);
  document.getElementById('btnSearch').addEventListener('click', ()=>{ alert('Pesquisar: ' + document.getElementById('search').value) });
});

function formatBRL(v){ return 'R$ ' + Number(v).toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits:2}) }

function renderOrders(list){
  const tbody = document.querySelector('#ordersTable tbody');
  tbody.innerHTML = '';
  list.forEach(o=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>#${o.id}</td>
      <td>${escapeHtml(o.customer)}</td>
      <td>${o.items}</td>
      <td>${formatBRL(o.total)}</td>
      <td class="small muted">${o.date}</td>
      <td>${statusBadge(o.status)}</td>
    `;
    tbody.appendChild(tr);
  });
}

function statusBadge(s){
  if(s==='paid') return `<span class="badge green">Pago</span>`;
  if(s==='pending') return `<span class="badge orange">Pendente</span>`;
  return `<span class="badge" style="background:rgba(239,68,68,0.12);color:${getComputedStyle(document.documentElement).getPropertyValue('--danger')||'#ef4444'}">Cancelado</span>`;
}

function filterOrders(status){
  if(!status) return demo.orders;
  return demo.orders.filter(o=>o.status===status);
}

function escapeHtml(text){ return String(text).replace(/[&<>"']/g, m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }


function refreshDemo(){
  
  demo.salesToday += Math.floor(Math.random()*5);
  demo.revenueSeries.push(Math.round(demo.revenueSeries[demo.revenueSeries.length-1] + (Math.random()-0.4)*200));
  if(demo.revenueSeries.length>30) demo.revenueSeries.shift();
  demo.revenue = demo.revenue + Math.round(Math.random()*200);
  document.getElementById('kSales').textContent = demo.salesToday;
  document.ge
}




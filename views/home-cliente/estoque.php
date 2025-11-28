<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque - Pet Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .search-box {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .search-box input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #ffb74d;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .status {
            font-weight: bold;
            padding: 6px 10px;
            border-radius: 6px;
            color: #fff;
        }

        .ok {
            background: #4CAF50;
        }

        .low {
            background: #e53935;
        }

        .categoria {
            font-weight: bold;
            font-size: 16px;
            padding: 10px;
            background: #ffe0b2;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>📦 Estoque</h1>

    <div class="search-box">
        <input type="text" id="search" placeholder="Buscar produto...">
    </div>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Quantidade</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody id="tabelaEstoque"></tbody>
    </table>
</div>

<script>
 
    const produtos = [
        { categoria: "Cachorro", nome: "Ração Premium Adulto – 10kg", qtd: 50 },
        { categoria: "Cachorro", nome: "Shampoo Hipoalergênico para Cães", qtd: 50 },
        { categoria: "Cachorro", nome: "Cama Acolchoada Tamanho M", qtd: 50 },
        { categoria: "Cachorro", nome: "Coleira e Guia Reforçada", qtd: 50 },
        { categoria: "Cachorro", nome: "Brinquedo Mordedor de Borracha", qtd: 50 },
        { categoria: "Cachorro", nome: "Petisco Natural de Frango – 300g", qtd: 50 },

        { categoria: "Gato", nome: "Ração Super Premium – 5kg", qtd: 50 },
        { categoria: "Gato", nome: "Areia Sanitária Perfumada – 4kg", qtd: 50 },
        { categoria: "Gato", nome: "Arranhador Compacto", qtd: 50 },
        { categoria: "Gato", nome: "Fonte de Água para Gatos", qtd: 50 },
        { categoria: "Gato", nome: "Brinquedo Varinha com Pena", qtd: 50 },
        { categoria: "Gato", nome: "Cama Redonda Antiestresse", qtd: 50 },

        { categoria: "Peixe", nome: "Ração Flocada Tropical – 50g", qtd: 50 },
        { categoria: "Peixe", nome: "Filtro para Aquário 20–40L", qtd: 50 },
        { categoria: "Peixe", nome: "Aquecedor 50W para Aquário", qtd: 50 },
        { categoria: "Peixe", nome: "Pedras Decorativas Naturais", qtd: 50 },
        { categoria: "Peixe", nome: "Enfeite de Castelo Submerso", qtd: 50 },
        { categoria: "Peixe", nome: "Kit de Teste de pH", qtd: 50 },

        { categoria: "Pássaros", nome: "Mistura de Sementes – 500g", qtd: 50 },
        { categoria: "Pássaros", nome: "Bebedouro Automático Cristal", qtd: 50 },
        { categoria: "Pássaros", nome: "Comedouro Suspenso", qtd: 50 },
        { categoria: "Pássaros", nome: "Vitamina Líquida para Plumagem", qtd: 50 },
        { categoria: "Pássaros", nome: "Gaiola Média com Bandeja Plástica", qtd: 50 },
        { categoria: "Pássaros", nome: "Poleiro Natural de Madeira", qtd: 50 },

        { categoria: "Hamster", nome: "Ração Completa – 300g", qtd: 50 },
        { categoria: "Hamster", nome: "Rodinha Silenciosa", qtd: 50 },
        { categoria: "Hamster", nome: "Casinha Colorida de Plástico", qtd: 50 },
        { categoria: "Hamster", nome: "Túnel Flexível", qtd: 50 },
        { categoria: "Hamster", nome: "Banheiro com Areia Especial", qtd: 50 },
        { categoria: "Hamster", nome: "Garrafinha Antivazamento", qtd: 50 },

        { categoria: "Coelho", nome: "Feno de Alfafa – 1kg", qtd: 50 },
        { categoria: "Coelho", nome: "Ração Nutritiva – 500g", qtd: 50 },
        { categoria: "Coelho", nome: "Comedouro Pesado Antivirada", qtd: 50 },
        { categoria: "Coelho", nome: "Casinha de Madeira Grande", qtd: 50 },
        { categoria: "Coelho", nome: "Brinquedo Mordedor de Madeira", qtd: 50 },
        { categoria: "Coelho", nome: "Areia Higiênica Vegetal – 2kg", qtd: 50 },

        { categoria: "Tartaruga", nome: "Ração Flutuante – 250g", qtd: 50 },
        { categoria: "Tartaruga", nome: "Iluminação UVB", qtd: 50 },
        { categoria: "Tartaruga", nome: "Filtro Interno", qtd: 50 },
        { categoria: "Tartaruga", nome: "Plataforma Flutuante", qtd: 50 },
        { categoria: "Tartaruga", nome: "Termômetro e Higrômetro", qtd: 50 },
        { categoria: "Tartaruga", nome: "Cascalho Natural", qtd: 50 },

        { categoria: "Furão", nome: "Ração Especializada – 1kg", qtd: 50 },
        { categoria: "Furão", nome: "Hamacão de Descanso", qtd: 50 },
        { categoria: "Furão", nome: "Túneis Interligados", qtd: 50 },
        { categoria: "Furão", nome: "Areia de Banho Especial", qtd: 50 },
        { categoria: "Furão", nome: "Coleira Ajustável", qtd: 50 },
        { categoria: "Furão", nome: "Spray Higienizador", qtd: 50 }
    ];

    const tabela = document.getElementById("tabelaEstoque");

    function carregarTabela() {
        tabela.innerHTML = "";

        produtos.forEach(prod => {
            let status = prod.qtd <= 5 ? "low" : "ok";
            let textoStatus = prod.qtd <= 5 ? "Baixo" : "Estável";

            tabela.innerHTML += `
                <tr>
                    <td>${prod.nome}</td>
                    <td>${prod.categoria}</td>
                    <td>${prod.qtd}</td>
                    <td><span class="status ${status}">${textoStatus}</span></td>
                </tr>
            `;
        });
    }

    carregarTabela();

 
    const search = document.getElementById("search");

    search.addEventListener("keyup", function() {
        let texto = search.value.toLowerCase();
        let linhas = tabela.getElementsByTagName("tr");

        for (let i = 0; i < linhas.length; i++) {
            let col = linhas[i].getElementsByTagName("td")[0];
            if (col) {
                let nome = col.textContent.toLowerCase();
                linhas[i].style.display = nome.indexOf(texto) > -1 ? "" : "none";
            }
        }
    });
</script>

</body>
</html>





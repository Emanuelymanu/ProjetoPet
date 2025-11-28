<?php
// routes/carrinhoRoutes.php
// Dispatcher simples para o carrinho — pode ser incluído em public/api.php ou chamado diretamente.

require_once __DIR__ . '/../controllers/CarrinhoController.php';

$carrinhoController = new CarrinhoController();

// Aceita ?action=adicionar / remover / exibir / limpar (GET ou POST)
$action = $_REQUEST['action'] ?? $_REQUEST['acao'] ?? '';

switch (strtolower($action)) {
    case 'adicionar':
    case 'add':
        $carrinhoController->adicionar();
        break;

    case 'remover':
    case 'remove':
        $carrinhoController->remover();
        break;

    case 'esvaziar':
    case 'limpar':
        $carrinhoController->limpar();
        break;

    case 'exibir':
    case 'index':
    case '':
        $carrinhoController->exibirCarrinho();
        break;

    default:
        // ação inválida — retorna 400 para AJAX ou redireciona para carrinho
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json; charset=utf-8', true, 400);
            echo json_encode(['sucesso' => false, 'erro' => 'Ação inválida']);
            exit;
        } else {
            header('Location: /ProjetoPet-main/public/carrinho.php?action=exibir');
            exit;
        }
}
?>
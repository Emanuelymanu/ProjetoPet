<?php
// controllers/CarrinhoController.php

require_once __DIR__ . '/../models/CarrinhoModel.php';
require_once __DIR__ . '/../models/ProdutosModel.php';

class CarrinhoController {
    private $carrinhoModel;
    private $produtosModel;
    // Ajuste se seu projeto estiver em outra pasta no servidor
    private $BASE_URL = '/ProjetoPet-main/public';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->carrinhoModel = new CarrinhoModel();
        $this->produtosModel = new ProdutosModel();
    }

    /**
     * Adiciona ou atualiza quantidade de um produto no carrinho.
     * Aceita POST (preferível) ou GET (links).
     * Retorna JSON em AJAX, caso contrário redireciona para página anterior ou carrinho.
     */
    public function adicionar() {
        $id = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
        if (!$id) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        }
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
        if ($quantidade === null || $quantidade === false) {
            $quantidade = filter_input(INPUT_GET, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
        }
        $quantidade = $quantidade === null ? 1 : (int)$quantidade;
        $id = (int)$id;
        $quantidade = (int)$quantidade;

        if ($id <= 0) {
            return $this->respondError('ID de produto inválido');
        }

        // tenta buscar produto com nomes de método compatíveis
        $produto = null;
        if (method_exists($this->produtosModel, 'getById')) {
            $produto = $this->produtosModel->getById($id);
        } elseif (method_exists($this->produtosModel, 'getProdutoById')) {
            $produto = $this->produtosModel->getProdutoById($id);
        } elseif (method_exists($this->produtosModel, 'find')) {
            $produto = $this->produtosModel->find($id);
        }

        if (!$produto) {
            return $this->respondError('Produto não encontrado');
        }

        // Normaliza quantidade: se for <0, decrementa; se for 0, remove
        if ($quantidade === 0) {
            $this->carrinhoModel->removerItem($id);
        } else {
            // Se quantidade negativa, tenta decrementar em vez de remover tudo
            if ($quantidade < 0) {
                // pega quantidade atual
                $conteudo = $this->carrinhoModel->getConteudo();
                $atual = isset($conteudo[$id]) ? (int)$conteudo[$id]['quantidade'] : 0;
                $nova = $atual + $quantidade; // quantidade é negativa
                if ($nova > 0) {
                    // substituir comportamento do adicionarItem: atualizar diretamente
                    $this->carrinhoModel->adicionarItem($id, $quantidade, $produto['preco'], $produto['nome']);
                } else {
                    $this->carrinhoModel->removerItem($id);
                }
            } else {
                // quantidade positiva: adiciona/incrementa
                $this->carrinhoModel->adicionarItem($id, $quantidade, $produto['preco'], $produto['nome']);
            }
        }

        if ($this->isAjax()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['sucesso' => true, 'mensagem' => 'Carrinho atualizado']);
            return;
        }

        // volta para referer se existir, senão para a página do carrinho
        $back = $_SERVER['HTTP_REFERER'] ?? $this->BASE_URL . '/carrinho.php?action=exibir';
        header('Location: ' . $back);
        exit;
    }

    /**
     * Remove um produto do carrinho (pelo id do produto).
     */
    public function remover() {
        $id = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
        if (!$id) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        }
        $id = (int)$id;
        if ($id <= 0) {
            return $this->respondError('ID inválido');
        }

        $ok = $this->carrinhoModel->removerItem($id);

        if ($this->isAjax()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['sucesso' => $ok]);
            return;
        }

        $back = $_SERVER['HTTP_REFERER'] ?? $this->BASE_URL . '/carrinho.php?action=exibir';
        header('Location: ' . $back);
        exit;
    }

    /**
     * Exibe o carrinho (renderiza a view pedido.php) ou retorna JSON com itens/total.
     */
    public function exibirCarrinho() {
        $conteudo = $this->carrinhoModel->getConteudo(); // array associativo por product id
        $total = $this->carrinhoModel->calcularTotal();

        if ($this->isAjax()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['itens' => $conteudo, 'total' => $total]);
            return;
        }

        // prepara variáveis esperadas pela view
        $carrinho_itens = $conteudo;
        $total_carrinho = $total;

        // caminho da view (ajuste se necessário)
        require_once __DIR__ . '/../views/home-cliente/pedido.php';
    }

    /**
     * Esvazia o carrinho.
     */
    public function limpar() {
        $this->carrinhoModel->limparCarrinho();

        if ($this->isAjax()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['sucesso' => true]);
            return;
        }

        $back = $_SERVER['HTTP_REFERER'] ?? $this->BASE_URL . '/index.php';
        header('Location: ' . $back);
        exit;
    }

    private function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function respondError($msg) {
        if ($this->isAjax()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['sucesso' => false, 'erro' => $msg]);
            return;
        }
        $back = $_SERVER['HTTP_REFERER'] ?? $this->BASE_URL . '/index.php';
        header('Location: ' . $back);
        exit;
    }
}
?>
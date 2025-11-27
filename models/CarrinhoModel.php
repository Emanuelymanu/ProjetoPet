<?php
// models/CarrinhoModel.php

class CarrinhoModel {

    public function __construct() {
        // Garante que a sessão está ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Inicializa o carrinho se ele não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
    }

    /**
     * Adiciona um item ao carrinho ou atualiza a quantidade.
     * @param int $id_produto ID do produto.
     * @param int $quantidade Quantidade a ser adicionada/ajustada.
     * @param float $preco Preço unitário do produto (obtido do ProdutosModel).
     * @param string $nome Nome do produto (para exibição na View).
     */
    public function adicionarItem($id_produto, $quantidade, $preco, $nome) {
        $id_produto = (int)$id_produto;
        $quantidade = (int)$quantidade;

        if ($quantidade <= 0) {
            return $this->removerItem($id_produto);
        }

        if (isset($_SESSION['carrinho'][$id_produto])) {
            // Item já existe, apenas atualiza a quantidade
            $_SESSION['carrinho'][$id_produto]['quantidade'] += $quantidade;
        } else {
            // Novo item no carrinho
            $_SESSION['carrinho'][$id_produto] = [
                'id_produto' => $id_produto,
                'nome' => $nome,
                'preco' => (float)$preco,
                'quantidade' => $quantidade,
            ];
        }
        return true;
    }
    
    /**
     * Remove um item do carrinho.
     * @param int $id_produto ID do produto a ser removido.
     */
    public function removerItem($id_produto) {
        unset($_SESSION['carrinho'][$id_produto]);
        return true;
    }

    /**
     * Retorna o conteúdo completo do carrinho.
     * @return array
     */
    public function getConteudo() {
        return $_SESSION['carrinho'];
    }

    /**
     * Calcula o total do carrinho.
     * @return float
     */
    public function calcularTotal() {
        $total = 0.0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
        return $total;
    }

    /**
     * Limpa o carrinho após a finalização da compra.
     */
    public function limparCarrinho() {
        $_SESSION['carrinho'] = [];
    }
}
?>
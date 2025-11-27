<?php
<?php
// controllers/PedidoController.php

require_once __DIR__ . '/../models/PedidoModel.php';
require_once __DIR__ . '/../models/CarrinhoModel.php';

class PedidoController {
    private $model;
    private $carrinho;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new PedidoModel();
        $this->carrinho = new CarrinhoModel();
    }

    /**
     * Finaliza pedido a partir do carrinho em sessão.
     * Aceita POST/AJAX. Retorna JSON em AJAX ou redireciona.
     */
    public function finalizar() {
        $cliente_id = $_SESSION['cliente_id'] ?? null;
        if (!$cliente_id) {
            $cliente_id = $_SESSION['cliente_id'] = uniqid('cliente_');
        }

        // campos opcionais vindos do formulário
        $dados_pedido = [];
        if (!empty($_POST['endereco'])) $dados_pedido['endereco'] = $_POST['endereco'];
        if (!empty($_POST['metodo_pagamento'])) $dados_pedido['metodo_pagamento'] = $_POST['metodo_pagamento'];

        // obter itens do carrinho (modelo atual usa sessão)
        $itensSessao = $this->carrinho->getConteudo();
        if (empty($itensSessao)) {
            return $this->responderErro('Carrinho vazio');
        }

        // normalizar itens para criarPedido
        $itensParaSalvar = [];
        foreach ($itensSessao as $it) {
            $itensParaSalvar[] = [
                'produto_id' => isset($it['produto_id']) ? $it['produto_id'] : (isset($it['produtoId']) ? $it['produtoId'] : 0),
                'quantidade' => isset($it['quantidade']) ? $it['quantidade'] : 1,
                'preco' => isset($it['preco']) ? $it['preco'] : 0.0
            ];
        }

        $frete = floatval($_POST['frete'] ?? 0.0);

        $pedido_id = $this->model->criarPedido($cliente_id, $itensParaSalvar, $frete, $dados_pedido);
        if (!$pedido_id) {
            return $this->responderErro('Falha ao criar pedido');
        }

        // esvazia carrinho de sessão
        $this->carrinho->limparCarrinho();

        if ($this->ehAjax()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['sucesso' => true, 'pedido_id' => $pedido_id]);
            return;
        }

        $base = '/ProjetoPet-main/public';
        header('Location: ' . $base . '/pedido.php?action=detalhes&id=' . $pedido_id);
        exit;
    }

    /**
     * Exibe detalhes de um pedido
     */
    public function detalhes($id = null) {
        $id = $id ?? ($_GET['id'] ?? null);
        $id = (int)$id;
        if ($id <= 0) {
            return $this->responderErro('ID de pedido inválido');
        }

        $pedido = $this->model->getPedidoPorId($id);
        if (!$pedido) {
            return $this->responderErro('Pedido não encontrado');
        }

        if ($this->ehAjax()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['sucesso' => true, 'pedido' => $pedido]);
            return;
        }

        // Carrega view de detalhes (crie views/home-cliente/pedido_detalhe.php se necessário)
        $pedidoDetalhe = $pedido;
        require_once __DIR__ . '/../views/home-cliente/pedido_detalhe.php';
    }

    private function ehAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function responderErro($msg) {
        if ($this->ehAjax()) {
            header('Content-Type: application/json; charset=utf-8', true, 400);
            echo json_encode(['sucesso' => false, 'erro' => $msg]);
            return;
        }
        $base = '/ProjetoPet-main/public';
        header('Location: ' . $base . '/pedido.php?erro=' . urlencode($msg));
        exit;
    }
}
?>
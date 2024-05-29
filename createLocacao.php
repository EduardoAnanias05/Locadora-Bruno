<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';

// Verifica se os dados POST não estão vazios
if (!empty($_POST)) {
    // Se os dados POST não estiverem vazios, insere um novo registro
    // Configura as variáveis que serão inseridas. Devemos verificar se as variáveis POST existem e, se não existirem, podemos atribuir um valor padrão a elas.
    $id_locacao = isset($_POST['id_locacao']) && !empty($_POST['id_locacao']) && $_POST['id_locacao'] != 'auto' ? $_POST['id_locacao'] : NULL;
    $id_carro = isset($_POST['id_carro']) ? $_POST['id_carro'] : '';
    $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
    $data_locacao = isset($_POST['data_locacao']) ? $_POST['data_locacao'] : date('Y-m-d');
    $data_devolucao = isset($_POST['data_devolucao']) ? $_POST['data_devolucao'] : '';
    $valor_total = isset($_POST['valor_total']) ? $_POST['valor_total'] : '';

    // Insere um novo registro na tabela contatos
    $stmt = $pdo->prepare('INSERT INTO locacao (id_locacao, id_carro, id_cliente, data_locacao, data_devolucao, valor_total) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id_locacao, $id_carro, $id_cliente, $data_locacao, $data_devolucao, $valor_total]);

     // Mensagem de saída
     $msg = 'Locação registrada com sucesso!';
    }
    ?>

<?=template_header('Registro de Locação')?>

<div>
    <h1>Locadora de Carros</h1>
    <a href="index.php"><i class="fas fa-home"></i>Inicio</a>
    <a href="readCarros.php"><i class="fas fa-car"></i>Locações</a>
    <a href="carros.php"><i class="fas fa-car"></i>Carros</a>
    
</div>

<div class="content update">
    <h2>Registrar Locação</h2>
    <form action="create.php" method="post">
        <label for="id_locacao">ID Locação</label>
        <label for="id_carro">ID Carro</label>
        <input type="text" name="id_locacao" placeholder="" value="" id="id_locacao">
        <input type="text" name="id_carro" placeholder="ID do Carro" id="id_carro">
        <label for="id_cliente">ID Cliente</label>
        <label for="data_locacao">Data de Locação</label>
        <input type="text" name="id_cliente" placeholder="ID do Cliente" id="id_cliente">
        <input type="date" name="data_locacao" value="<?=date('Y-m-d')?>" id="data_locacao">
        <label for="data_devolucao">Data de Devolução</label>
        <label for="valor_total">Valor Total</label>
        <input type="date" name="data_devolucao" placeholder="Data de Devolução" id="data_devolucao">
        <input type="text" name="valor_total" placeholder="Valor Total" id="valor_total">
        <input type="submit" value="Registrar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';

// Verifica se os dados POST não estão vazios
if (!empty($_POST)) {
    // Obtém os dados do formulário
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : '';
    $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
    $celular = isset($_POST['celular']) ? $_POST['celular'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $id_pagamento = isset($_POST['id_pagamento']) ? $_POST['id_pagamento'] : '';

    // Insere um novo registro na tabela Cliente
    $stmt = $pdo->prepare('INSERT INTO Cliente (Estado, Sobrenome, Cidade, Nome, Endereco, Celular, Email, Id_Pagamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$estado, $sobrenome, $cidade, $nome, $endereco, $celular, $email, $id_pagamento]);

    // Mensagem de saída
    $msg = 'Cliente registrado com sucesso!';
}
?>

<?= template_header('Registro de Cliente') ?>

<div>
    <h1>Locadora de Carros</h1>
    <a href="index.php"><i class="fas fa-home"></i>Inicio</a>
    <a href="read.php"><i class="fas fa-car"></i>Locações</a>
    <a href="carros.php"><i class="fas fa-car"></i>Carros</a>
</div>

<div class="content update">
    <h2>Registrar Cliente</h2>
    <form action="cliente.php" method="post">-
        <label for="estado">Estado</label>
        <label for="sobrenome">Sobrenome</label>
        <input type="text" name="estado" placeholder="Estado" id="estado">
        <input type="text" name="sobrenome" placeholder="Sobrenome" id="sobrenome">
        <label for="cidade">Cidade</label>
        <label for="nome">Nome</label>
        <input type="text" name="cidade" placeholder="Cidade" id="cidade">
        <input type="text" name="nome" placeholder="Nome" id="nome">
        <label for="endereco">Endereço</label>
        <label for="celular">Celular</label>
        <input type="text" name="endereco" placeholder="Endereço" id="endereco">
        <input type="text" name="celular" placeholder="Celular" id="celular">
        <label for="email">Email</label>
        <label for="id_pagamento">ID Pagamento</label>
        <input type="email" name="email" placeholder="Email" id="email">
        <input type="text" name="id_pagamento" placeholder="ID Pagamento" id="id_pagamento">
        <input type="submit" value="Registrar">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>
<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';

// Verifica se o ID do contato existe
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Obtém os dados do formulário
        $id_contato = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $cel = isset($_POST['cel']) ? $_POST['cel'] : '';
        $pizza = isset($_POST['pizza']) ? $_POST['pizza'] : '';
        $cadastro = isset($_POST['cadastro']) ? $_POST['cadastro'] : date('Y-m-d H:i:s');
        
        // Atualiza o registro
        $stmt = $pdo->prepare('UPDATE contatos SET id_contato = ?, nome = ?, email = ?, cel = ?, pizza = ?, cadastro = ? WHERE id_contato = ?');
        $stmt->execute([$id_contato, $nome, $email, $cel, $pizza, $cadastro, $_GET['id']]);
        $msg = 'Atualização Realizada com Sucesso!';
    }
    // Obtém o contato da tabela contatos
    $stmt = $pdo->prepare('SELECT * FROM contatos WHERE id_contato = ?');
    $stmt->execute([$_GET['id']]);
    $contato = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contato) {
        exit('Contato Não Localizado!');
    }
} else {
    exit('Nenhum ID Especificado!');
}
?>

<?=template_header('Atualizar Contato')?>

<div class="content update">
	<h2>Atualizar Contato - ID: <?=$contato['id_contato']?></h2>
    <form action="update.php?id=<?=$contato['id_contato']?>" method="post">
        <label for="id">ID</label>
        <label for="nome">Nome</label>
        <input type="text" name="id" placeholder="ID" value="<?=$contato['id_contato']?>" id="id" readonly>
        <input type="text" name="nome" placeholder="Nome" value="<?=$contato['nome']?>" id="nome">
        <label for="email">Email</label>
        <label for="cel">Celular</label>
        <input type="text" name="email" placeholder="Email" value="<?=$contato['email']?>" id="email">
        <input type="text" name="cel" placeholder="Celular" value="<?=$contato['cel']?>" id="cel">
        <label for="pizza">Pizza</label>
        <label for="cadastro">Cadastro</label>
        <input type="text" name="pizza" placeholder="Pizza" value="<?=$contato['pizza']?>" id="pizza">
        <input type="text" name="cadastro" placeholder="Cadastro" value="<?=$contato['cadastro']?>" id="cadastro" readonly>
        <input type="submit" value="Atualizar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

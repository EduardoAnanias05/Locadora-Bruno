<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';

// Verifica se os dados POST não estão vazios
if (!empty($_POST)) {
    // Configura as variáveis que serão inseridas
    $id_carro = isset($_POST['id_carro']) ? $_POST['id_carro'] : '';
    $ano = isset($_POST['ano']) ? $_POST['ano'] : '';
    $placa = isset($_POST['placa']) ? $_POST['placa'] : '';
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
    $disponibilidade = isset($_POST['disponibilidade']) ? $_POST['disponibilidade'] : '';

    // Insere um novo registro na tabela Carro
    $stmt = $pdo->prepare('INSERT INTO carro (Id_Carro, Ano, Placa, Modelo, Tipo, Disponibilidade) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id_carro, $ano, $placa, $modelo, $tipo, $disponibilidade]);

    // Mensagem de saída
    $msg = 'Carro registrado com sucesso!';
}
?>

<?=template_header('Registro de Carro')?>

<div class="content update">
    <h2>Registrar Carro</h2>
    <form action="createCarro.php" method="post">
        <label for="id_carro">ID Carro</label>
        <input type="text" name="id_carro" placeholder="CARXXX" id="id_carro">
        
        <label for="ano">Ano</label>
        <input type="text" name="ano" placeholder="Ano" id="ano">

        <label for="placa">Placa</label>
        <input type="text" name="placa" placeholder="Placa" id="placa">

        <label for="modelo">Modelo</label> 
        <input type="text" name="modelo" placeholder="Modelo" id="modelo">


        <label for="tipo">tipo</label>
        <select name="tipo" id="tipo">
            <option value="Sedan">Sedan</option>
            <option value="Hatchback">Hatchback</option>
        </select>


        <label for="disponibilidade">Disponibilidade</label>
        <select name="disponibilidade" id="disponibilidade">
            <option value="Alugado">Alugado</option>
            <option value="Disponivel">Disponivel</option>
        </select>

        <input type="submit" value="Registrar">

      
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

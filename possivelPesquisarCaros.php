<?php
include 'functions.php';
// Conectar ao banco de dados PostgreSQL
$pdo = pdo_connect_pgsql();
// Obter a página via solicitação GET (parâmetro URL: page), se não existir, defina a página como 1 por padrão
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Número de registros para mostrar em cada página
$records_per_page = 5;

// Preparar a instrução SQL e obter registros da tabela carros, LIMIT irá determinar a página
$stmt = $pdo->prepare('SELECT * FROM carro ORDER BY Id_Carro OFFSET :offset LIMIT :limit');
$stmt->bindValue(':offset', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Buscar os registros para exibi-los em nosso modelo.
$carros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obter o número total de carro, isso é para determinar se deve haver um botão de próxima e anterior
$num_carros = $pdo->query('SELECT COUNT(*) FROM carro')->fetchColumn();
?>


<?=template_header('Pesquisar carro')?>

<div class="content read">
    <h2>Pesquisar carro</h2>

    <!-- Formulário de pesquisa -->
    <form action="" method="get">
        <label for="search">Pesquisar por Modelo:</label>
        <input type="text" id="search" name="search" placeholder="Digite o modelo do carro">
        <input type="submit" value="Pesquisar">
    </form>

    <?php
    // Verificar se houve uma pesquisa
    if(isset($_GET['search']) && !empty($_GET['search'])) {
        // Limpar a entrada para evitar injeção de SQL
        $search = htmlspecialchars($_GET['search']);
        // Preparar a instrução SQL para buscar o carro com o modelo pesquisado
        $stmt = $pdo->prepare('SELECT * FROM carro WHERE Modelo LIKE ?');
        // Executar a consulta com o modelo do carro pesquisado
        $stmt->execute(["%$search%"]);
        // Buscar os resultados da consulta
        $carros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar se foi encontrado um carro com o modelo pesquisado
        if(count($carros) > 0) {
            // Exibir a tabela de carros somente se um carro foi encontrado
    ?>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>Modelo</td>
                <td>Marca</td>
                <td>Ano</td>
                <td>Cor</td>
                <td>Placa</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carros as $carro): ?>
            <tr>
                <td><?=$carro['Id_Carro']?></td>
                <td><?=$carro['Modelo']?></td>
                <td><?=$carro['Marca']?></td>
                <td><?=$carro['Ano']?></td>
                <td><?=$carro['Cor']?></td>
                <td><?=$carro['Placa']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$carro['Id_Carro']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$carro['Id_Carro']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
        } else {
            // Se nenhum carro for encontrado com o modelo pesquisado, exibir uma mensagem
            echo "<p>Nenhum carro encontrado com o modelo '$search'.</p>";
        }
    }
    ?>
</div>

<?php
// Função para exibir a tabela de carro
function display_carros_table($carros) {
    echo <<<EOT
<div class="content read">
    <h2>Pesquisar carro</h2>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>Modelo</td>
                <td>Marca</td>
                <td>Ano</td>
                <td>Cor</td>
                <td>Placa</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
EOT;

    foreach ($carros as $carro) {
        echo "<tr>
                <td>{$carro['Id_Carro']}</td>
                <td>{$carro['Modelo']}</td>
                <td>{$carro['Marca']}</td>
                <td>{$carro['Ano']}</td>
                <td>{$carro['Cor']}</td>
                <td>{$carro['Placa']}</td>
                <td class='actions'>
                    <a href='update.php?id={$carro['Id_Carro']}' class='edit'><i class='fas fa-pen fa-xs'></i></a>
                    <a href='delete.php?id={$carro['Id_Carro']}' class='trash'><i class='fas fa-trash fa-xs'></i></a>
                </td>
            </tr>";
    }

    echo <<<EOT
        </tbody>
    </table>
</div>
EOT;
}
?>
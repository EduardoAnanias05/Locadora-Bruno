<?php
include 'functions.php';
// Conectar ao banco de dados PostgreSQL
$pdo = pdo_connect_pgsql();
// Obter a página via solicitação GET (parâmetro URL: page), se não existir, defina a página como 1 por padrão
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Número de registros para mostrar em cada página
$records_per_page = 5;

// Preparar a instrução SQL e obter registros da tabela carros, LIMIT irá determinar a página
$stmt = $pdo->prepare('SELECT * FROM carro ORDER BY id_carro OFFSET :offset LIMIT :limit');
$stmt->bindValue(':offset', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Buscar os registros para exibi-los em nosso modelo.
$carros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obter o número total de carros, isso é para determinar se deve haver um botão de próxima e anterior
$num_carros = $pdo->query('SELECT COUNT(*) FROM carro')->fetchColumn();
?>


<?=template_header('Visualizar Carros')?>

<div class="content read">
    <h2>Visualizar Carros</h2>
    <table>
        <thead>
            <tr>
                <td>Cód Carro</td>
                <td>Modelo</td>
                <td>Ano</td>
                <td>Tipo</td>
                <td>Placa</td>
                <td>Disponibilidade</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carros as $carro): ?>
            <tr>
                <td><?=$carro['id_carro']?></td>
                <td><?=$carro['modelo']?></td>
                <td><?=$carro['ano']?></td>
                <td><?=$carro['tipo']?></td>
                <td><?=$carro['placa']?></td>
                <td><?=$carro['disponibilidade']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$carro['id_carro']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$carro['id_carro']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
        <a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_carros): ?>
        <a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>

    <a href="index.php" class="btn btn-outline-danger">Voltar</a>

</div>

<?=template_footer()?>

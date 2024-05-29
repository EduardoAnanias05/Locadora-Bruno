<?php
include 'functions.php';

// Your PHP code here.

// Home Page template below.
?>


<?=template_header('LocEdu')?>
<div class="container">

<div class="content">
	<h2>Inicio</h2>
	<p>Seja Bem-Vindo!</p>
</div>


<div class="row">
  <div class="col-sm-6 mb-3 mb-sm-0">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Registre os Clientes</h5>
        <p class="card-text">Para Registrar os novos clientes aperte Aqui.</p>
        <a href="readClientes.php" class="btn btn-primary">LISTAR clientes</a>
        <a href="cliente.php" class="btn btn-primary">ADD clientes</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Gerencie os Automoveis</h5>
        <p class="card-text">Aqui Voce pode gerenciar os Veiculos.</p>
        <a href="createCarro.php" class="btn btn-primary">Registrar</a>
        <a href="readCarros.php" class="btn btn-primary">Listar</a>
      </div>
    </div>
  </div>
</div>

<?=template_footer()?>    
</div> 
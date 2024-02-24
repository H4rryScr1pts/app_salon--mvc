<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>
<?php include __DIR__ . "/../templates/barra.php";?>
<ul class="servicios">
  <?php foreach ($servicios as $servicio) { ?>
      <li>
        <p>Servicio: <span><?= $servicio->nombre ?></span></p>
        <p>Precio: <span>$ <?= $servicio->precio ?></span></p>
        <div class="acciones">
          <a href="/servicios/actualizar?id=<?= $servicio->id?>" class="boton">Actualizar</a>
          <button class="boton-eliminar" onclick="eliminarServicio(<?= $servicio->id?>)">Eliminar</button>
        </div>
      </li>
    <?php 
    }
  ?>
</ul>
<?php 
  $script = 
    "<script src='/build/js/buscador.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  ";
?>
<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">Llena el formulario para crear un nuevo servicio</p>
<?php include __DIR__ . "/../templates/barra.php"?>
<form action="/servicios/crear" method="post" class="formulario">
  <?php include_once __DIR__ . "/../templates/alertas.php";?>
  <?php include_once __DIR__ . "/formulario.php";?>
  <input type="submit" class="boton" value="Registrar Servicio">
</form>
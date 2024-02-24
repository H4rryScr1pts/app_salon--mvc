<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica las características de tus servicios</p>
<?php include __DIR__ . "/../templates/barra.php"?>
<form method="post" class="formulario">
  <?php include_once __DIR__ . "/../templates/alertas.php";?> 
  <?php include_once __DIR__ . "/formulario.php";?>
  <input type="submit" class="boton" value="Guardar Cambios">
</form>
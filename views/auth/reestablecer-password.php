<h1 class="nombre-pagina">Reestablecer Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>
<?php include_once __DIR__ . "/../templates/alertas.php";?>
<?php if($error) return;?>
<form method="post" class="formulario">
  <div class="campo">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="Tu nuevo passsword">
  </div>
  <input type="submit" class="boton" value="Guardar Nuevo Password">
</form>
<div class="acciones">
  <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
  <a href="/crear-cuenta">Aun no tienes cuenta? Obtener una</a>
</div>
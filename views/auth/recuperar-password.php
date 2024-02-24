<h1 class="nombre-pagina">Olvide mi Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu e-mail a continuación</p>
<?php include_once __DIR__ . "/../templates/alertas.php";?>
<form method="post" class="formulario">
  <div class="campo">
    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" placeholder="Tu e-mail">
  </div>
  <input type="submit" class="boton" value="Enviar Instrucciones">
</form>
<div class="acciones">
  <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
  <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea una</a> 
</div>

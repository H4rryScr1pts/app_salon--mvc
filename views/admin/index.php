<h1 class="nombre-pagina">Panel de Administración</h1>
<?php include_once __DIR__. "/../templates/barra.php"?>
<h2>Buscar Citas</h2>
<p class="descripcion-pagina">Busca las citas para cada día</p>
<div class="busqueda">
  <form class="formulario">
    <div class="campo">
      <label for="fecha">Fecha</label>
      <input type="date" id="fecha" name="fecha" value="<?= $fecha;?>">
    </div>
  </form>
</div>
<?php 
  if(count($citas) === 0) {
    echo "<h2>No hay citas para esta fecha</h2>";
  }
?>
<div id="citas-admin">
  <ul class="citas">
    <!-- Mostrar las citas -->
    <?php 
      $idCita = 0; // Id de la cita
      foreach($citas as $key => $cita) {  // Iterar las citas y el key de la iteracion 
        if($idCita !== $cita->id) {  // Mostrar la información sobre la cita una sola vez
          $total = 0; // Cantidad total a pagar
          ?>
          <li>
            <h2>Cita para Hoy</h2>
            <p>ID: <span><?= $cita->id ?></span></p>
            <p>Hora: <span><?= $cita->hora ?></span></p>
            <p>Cliente: <span><?= $cita->cliente ?></span></p>
            <p>Email: <span><?= $cita->email ?></span></p>
            <p>Telefono: <span><?= $cita->telefono ?></span></p>
            <h3>Servicios</h3>
          <?php 
          $idCita = $cita->id; // Asignar el id de la cita al contador de citas para evaluar el siguiente bucle
        }
      $total += $cita->precio; // Sumar el precio de cada servicio y agregarlo a la variable
    ?>
      <!-- Mostrar los servicios (Iteraciones) -->
      <p class="servicio">- <?= $cita->servicio?>: <span> $<?= $cita->precio ?></span></p>
      <?php 
      // Obtener la ultima posicion para colocar el total a pagar
      $actual = $cita->id; // Retorna el id actual dentro del registro
      $proximo = $citas[$key + 1]->id ?? 0; // Indice en el arreglo de la base de datos

      if(esUltimo($actual, $proximo)) { ?>
        <p class="total">Total: <span> $<?= $total ?></span></p>
        <div id="eliminar-cita">
          <button class="boton-eliminar" onclick="eliminarCita(<?= $cita->id?>)">Eliminar Cita</button>
        </div>
      <?php
      }
    }
    ?>
  </ul>
</div>
<?php 
  $script = 
    "<script src='/build/js/buscador.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  ";
?>
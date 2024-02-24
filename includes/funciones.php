<?php
// Funciones helper

/** Mostrar datos de manera más formateada
 * @param mixed $datos
 * @return  void 
 */
function debuguear($variable) {
  echo "<pre>";
  var_dump($variable);
  echo "</pre>";
  exit;
}

/** Sanitizar el HTML de la entrada de datos
 * @param mixed $html
 * @return string
 */
function s($html) : string {
  $s = htmlspecialchars($html);
  return $s;
}

/** Revisar si un usuario está autenticado
 * @return void
 */
function isAuth() : void {
  if(!isset($_SESSION["login"])) {
    header("Location: /");
  }
}

/** Función utilizada para comprobar si un elemento dentro de un arreglo es el ultimo dentro de un ciclo
 * @param string $actual
 * @param string $proximo
 * @return void 
 */
function esUltimo(string $actual, string $proximo) : bool {
  if($actual !== $proximo) {
    return true;
  }
  return false;
}

/** Comprobar si un administrador se cuenta autenticado a través de un campo dentro de la sesión
 * @return void 
 */
function isAdmin() : void {
  if(!isset($_SESSION["admin"])) {
    header("Location: /");
  }
}
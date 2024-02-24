<?php 
namespace Controller;
use Model\AdminCita;
use MVC\Router;
class AdminController {
  /** Controlador de la sección pricipal de administración
   * @return void
   */
  public static function index(Router $router) : void {
    isAdmin();

    $fecha = $_GET["fecha"] ?? date("Y-m-d");
    $fechas = explode("-", $fecha) ?? []; // Separar los elementos de la fecha
    
    if (!checkdate($fechas[1], $fechas[2], $fechas[0])) { // Comprobar los elementos de la fecha
      header("Location: /404");
    }

    // Consultar la base de datos
    $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
    $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
    $consulta .= " FROM citas  ";
    $consulta .= " LEFT OUTER JOIN usuarios ";
    $consulta .= " ON citas.id_usuario=usuarios.id  ";
    $consulta .= " LEFT OUTER JOIN citasServicios ";
    $consulta .= " ON citasServicios.citaId=citas.id ";
    $consulta .= " LEFT OUTER JOIN servicios ";
    $consulta .= " ON servicios.id=citasServicios.servicioId ";
    $consulta .= " WHERE fecha =  '$fecha' ";

    $citas = AdminCita::SQL($consulta); // Ejecutar la consulta

    $router->render("/admin/index", [ // Renderizar la vista 
      "nombre" => $_SESSION["nombre"],
      "citas" => $citas, 
      "fecha" => $fecha
    ]);
  }
}
?>
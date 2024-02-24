<?php 
namespace Controller;
use MVC\Router;

class CitaController {
  public static function index(Router $router) : void {
    isAuth();
    /** Controlador para la sección de citas para un usuario
     * @return void 
     */
    $router->render("cita/index", [
      "nombre" => $_SESSION["nombre"],
      "id" => $_SESSION["id"]
    ]);
  }
}
?>
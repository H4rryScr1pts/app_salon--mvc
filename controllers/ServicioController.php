<?php 
namespace Controller;
use Model\Servicio;
use MVC\Router;

class ServicioController {
  /** Sección de servicios en area de administración
   * @param Router $router
   * @return void
   */
  public static function index(Router $router) : void {
    isAdmin();
    $router->render("/servicios/index", [
      "nombre" => $_SESSION["nombre"],
      "servicios" => Servicio::all()
    ]);
  }

  /** Proceso de creación de un servicio nuevo
   * @param Router $router
   * @return void
   */
  public static function crear(Router $router) : void {
    isAdmin();
    $servicio = new Servicio();
    $alertas = [];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $servicio->sincronizar($_POST);
      $alertas = $servicio->validar();

      if(empty($alertas)) {
        $servicio->guardar();
        header("Location: /servicios");
      }
    }
    
    $router->render("/servicios/crear", [
      "nombre" => $_SESSION["nombre"],
      "servicio" => $servicio,
      "alertas" => $alertas
    ]);
  }

  /** Controlador para actualizar un servicio
   * @param Router $router
   * @return  void
   */
  public static function actualizar(Router $router) : void {
    isAdmin();
    if(!is_numeric($_GET["id"])) return;
    $servicio = Servicio::find(filter_var($_GET["id"], FILTER_VALIDATE_INT));
    $alertas = [];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $servicio->sincronizar($_POST);
      $alertas = $servicio->validar();
      if(empty($alertas)) {
        $servicio->guardar();
        header("Location: /servicios");
      }

    }

    $router->render("/servicios/actualizar", [
      "nombre" => $_SESSION["nombre"],
      "servicio" => $servicio,
      "alertas" => $alertas
    ]);
  }

  /** Proceso de eliminación de un servicio mediante una respuesta enviada por una api
   * @return void
   */
  public static function eliminar() : void {
    isAdmin();
    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
      if($id) {
        $servicio = Servicio::find($id);
        $resultado = $servicio->eliminar();
        if($resultado) {
          $respuesta = [
            "resultado" => true
          ];

          echo json_encode($respuesta); // Respuesta consumida por fetch
        }
      }
    }
  }
}
?>
<?php 
namespace Controller;

use Model\Cita;
use Model\CitasServicios;
use Model\Servicio;

/** Clase con los metodos relacionados con las apis */
class APIController {
  /** Obtener todos los servicios y mandarlos al cliente en formato JSON
   * @return void
   */
  public static function index() : void {
    // Obtener los servicios
    $servicios = Servicio::all();
    echo json_encode($servicios); // Imprimir los servicios en JSON
  }

  /** Guardar una cita utilizando un api con petición fetch. Devuelve una respuesta JSON 
   * @return void
  */
  public static function guardar() : void {
    // Almacena la cita y devuelve el id
    $cita = new Cita($_POST); // Datos obtenidos por medio de fetch (Form Data)
    $resultado = $cita->guardar();

    $id = $resultado["id"]; // Id de la cita (Obtenido de ActiveRecord)

    $idServicios = explode(",", $_POST["servicios"]); // Crear arreglo con elementos separados por (,)

    // Almacenar los servicios con el id de la cita
    foreach($idServicios as $idServicio) {
      $args = [ // Argumentos para el constructor
        "citaId" => $id,
        "servicioId" => $idServicio
      ];

      // Instancia nueva y almacenaje en la base de datos
      $citaServicio = new CitasServicios($args);
      $citaServicio->guardar();
    }

    // Retornar una respuesta
    $respuesta = [
      "resultado" => $resultado
    ];

    echo json_encode($respuesta); // Mostrar la respuesta en JSON
  }

  /** Eliminar una cita a travéz de una petición fetch
   * @return void 
   */
  public static function eliminar() : void {
    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
      if($id) {
        $cita = Cita::find($id);
        $cita->eliminar();
        $respuesta = [
          "respuesta" => true
        ];
        echo json_encode($respuesta);
      }
    }
  }
}
?>
<?php 
namespace Model;

class Servicio extends ActiveRecord {
  // Base de Datos
  public static $tabla = "servicios";
  public static $columnasDB = ["id", "nombre", "precio"];

  // Atributos
  public $id;
  public $nombre;
  public $precio;

  public function __construct($args = []) {
    $this->id = $args["id"] ?? null;
    $this->nombre = $args["nombre"] ?? "";
    $this->precio = $args["precio"] ?? "";
  }

  /** Validar campos al crear o actualizar un servicio
   * @return array 
   */
  public function validar() : array {
    if(!$this->nombre) {
      self::$alertas["error"][] = "El nombre del servicio es obligatorio";
    }
    if(!$this->precio) {
      self::$alertas["error"][] = "El precio del servicio es obligatorio";
      if(!is_numeric($this->precio)) {
        self::$alertas["error"][] = "El formato del precio no es valido";
      }
    }

    return self::$alertas;
  }
}
?>


<?php 
namespace Model;

/** Modelo para datos de una cita */
class Cita extends ActiveRecord {
  protected static $tabla = "citas";
  protected static $columnasDB = ["id", "fecha", "hora", "id_usuario"];
  public $id;  
  public $fecha;  
  public $hora;  
  public $id_usuario;  

  public function __construct($args = []) {
    $this->id = $args["id"] ?? null;
    $this->fecha = $args["fecha"] ?? null;
    $this->hora = $args["hora"] ?? null;
    $this->id_usuario = $args["id_usuario"] ?? null;
  }
}
?>
<?php 
namespace Model;

/** Modelos para las citas relacionadas a los servicios */
class CitasServicios extends ActiveRecord {
  protected static $tabla = "citasservicios";
  protected static $columnasDB = ["id", "citaId", "servicioId"];

  public $id;
  public $citaId;
  public $servicioId;

  public function __construct($args = []) {
    $this->id = $args["id"] ?? null;
    $this->citaId = $args["citaId"] ?? null;
    $this->servicioId = $args["servicioId"] ?? null;
  }
}
?>
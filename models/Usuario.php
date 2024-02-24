<?php 
namespace Model;

/** Modelo para la tabla de usuarios */
class Usuario extends ActiveRecord {
  protected static $tabla = "usuarios";
  protected static $columnasDB = ["id", "nombre", "apellido", "email", "password", "telefono", "admin", "confirmado", "token"];
  public $id;
  public $nombre;
  public $apellido;
  public $email;
  public $password;
  public $telefono;
  public $admin;
  public $confirmado;
  public $token;

  public function __construct( $args = []) {
    $this->id = $args["id"] ?? null;
    $this->nombre = $args["nombre"] ?? "";
    $this->apellido = $args["apellido"] ?? "";
    $this->email = $args["email"] ?? "";
    $this->password = $args["password"] ?? "";
    $this->telefono = $args["telefono"] ?? "";
    $this->admin = $args["admin"] ?? 0;
    $this->confirmado = $args["confirmado"] ?? 0;
    $this->token = $args["token"] ?? "";
  }

  /** Validación para una cuenta nueva
   * @return array
   */
  public function validarNuevaCuenta() : array {
    if(!$this->nombre) {
      self::$alertas["error"][] = "El nombre es obligatorio";
    }
    if(!$this->apellido) {
      self::$alertas["error"][] = "El apellido es obligatorio";
    }
    if(!$this->telefono) {
      self::$alertas["error"][] = "El telefono es obligatorio";
    }
    if(!$this->email) {
      self::$alertas["error"][] = "El e-mail es obligatorio";
    }
    if(!$this->password) {
      self::$alertas["error"][] = "El password es obligatorio";
    }
    if(strlen($this->password) < 8) {
      self::$alertas["error"][] = "El password debe contener al menos 8 caracteres";
    }
    return self::$alertas;
  }


  /** Validar si algun registro ya existe en la base de datos */
  public function validarExistencia() {
    $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

    $resultado = self::$db->query($query);

    if($resultado->num_rows) {
      self::$alertas["error"][] = "El e-mail que ingresó ya se encunetra en uso de otra cuenta";
    }

    return $resultado;
  }

  /** Validar los campos de la zona de login 
   * @return array
   */
  public function validarLogin() : array {
    if(!$this->email) {
      self::$alertas["error"][] = "El e-mail es obligatorio";
    }
    if(!$this->password) {
      self::$alertas["error"][] = "El password es obligatorio";
    }

    return self::$alertas;
  }

  /** Validar el email para reestablecer password
   * @return array
   */
  public function validarEmail() : array {
    if(!$this->email) {
      self::$alertas["error"][] = "Debes coloca tu e-mail para continuar";
    }
    return self::$alertas;
  }

  /** Validaciones para rrestablecer password
   * @return array 
   */
  public function validarPassword() : array {
    if(!$this->password) {
      self::$alertas["error"][] = "Debes coloca un password para continuar";
    }
    if(strlen($this->password) < 8) {
      self::$alertas["error"][] = "El password debe de contener al menos 8 caracteres";
    }
    return self::$alertas;
  }

  /** Hashear el password del usuario */
  public function hashPassword() {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  /** Crear un token para el usuario */  
  public function crearToken() {
    $this->token = uniqid();
  }

  /** Verificar el password del uuario
   * @param string $password
   */
  public function verificar(string $password) {
    $resultdo = password_verify($password, $this->password);
    if(!$resultdo || !$this->confirmado) {
      self::$alertas["error"][] = "Password incorrecto o Cuenta no confirmada";
    } else {
      return true;
    }
  }
}
?>
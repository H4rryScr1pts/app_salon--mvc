<?php 
namespace Controller;
use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginController {
  /** Controlador para la sección de inicio de sesión 
   * @param Router $router
   * @return  void
   */
  public static function login(Router $router) : void {
    $alertas = []; // Alertas que se muestran al usuario 

    if($_SERVER["REQUEST_METHOD"] === "POST") { // Procedimiento para datos enviados por $_POST[]
      $auth = new Usuario($_POST);  
      $alertas = $auth->validarLogin();

      if(empty($alertas)) {
        // Comprobar que exista el usuario
        $usuario = Usuario::where("email", $auth->email);

        if($usuario) {
          // Verificar el password y la confirmación de la cuenta
          if($usuario->verificar($auth->password)) {
            // Autenticar al Usuario
            session_start();

            // Llenar la sesión con los datos del cliente
            $_SESSION["id"] = $usuario->id;
            $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido;
            $_SESSION["email"] = $usuario->email;
            $_SESSION["login"] = true;

            // Redireccionamientos
            if($usuario->admin === "1") {
              $_SESSION["admin"] = $usuario->admin??null;
              header("Location: /admin");

            } else {
              header("Location: /cita");
            }
          }
        } else {
          Usuario::setAlerta("error", "Usuario no encontrado");
        }
      }
    }

    $alertas = Usuario::getAlertas(); // Obtener alertas para ser mistradas 

    $router->render("/auth/login", [ // Renderizar la vista
      "alertas" => $alertas
    ]);
  }

  /** Función para el cierre de sesión 
   * @return void
   */
  public static function logout() : void {
    session_start();
    $_SESSION = []; // Vaciar el arreglo de sesión 
    header("Location: /"); // Redireccionar al usuario
  } 

  /** Metodo para mostrar el proceso de reestablecimiento de password 
   * @param Router $router
   * @return void 
   */
  public static function olvide(Router $router) : void {
    $alertas = []; // Alertas para los usuarios 

    if($_SERVER["REQUEST_METHOD"] === "POST") { // Procedimientos con datos enviados por $_POST[]
      $auth = new Usuario($_POST);
      $alertas = $auth->validarEmail();

      if(empty($alertas)) {
        $usuario = Usuario::where("email", $auth->email);
        if($usuario && $usuario->confirmado === "1") {
          // Generar nuevo token
          $usuario->crearToken();
          $usuario->guardar();

          // TODO: Enviar email
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarInstrucciones();
          
          Usuario::setAlerta("exito", "Instrucciones enviadas a tu e-mail");

        } else {
          Usuario::setAlerta("error", "El e-mail no existe o no está confirmado");
        }
      }
    }

    $alertas = Usuario::getAlertas();

    $router->render("/auth/recuperar-password", [
      "alertas" => $alertas
    ]);
  }

  /** Controlador para el reestablecimiento de password
   * @param Router $router
   */
  public static function recuperar(Router $router) : void {
    $alertas = []; 
    $token = s($_GET["token"]);
    $error = false; 

    // Buscar el usuario a través de su token
    $usuario = Usuario::where("token", $token);

    if(empty($usuario)) {
      Usuario::setAlerta("error", "Token no valido");
      $error = true;
    } 

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      // Cambiar el password
      $password = new Usuario($_POST);
      $alertas = $password->validarPassword();

      if(empty($alertas)) {
        $usuario->password = null;

        $usuario->password = $password->password;
        $usuario->hashPassword();
        $usuario->token = null;

        $resultado = $usuario->guardar();
        if($resultado) {
          header("Location: /");
        }
      }
    }

    $alertas = Usuario::getAlertas();

    $router->render("/auth/reestablecer-password", [
      "alertas" => $alertas,
      "error" => $error
    ]);
  }

  /** Procedimento de creación de nuevas cuentas
   * @param Router $router
   */
  public static function crear(Router $router) : void {
    $usuario = new Usuario;
    $alertas = array();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      // Sincronizar al objeto con los datos recibidos de $_POST[]
      $usuario->sincronizar($_POST);

      $alertas = $usuario->validarNuevaCuenta();

      // Revisar que no halla alertas
      if(empty($alertas)) {
        $resultado = $usuario->validarExistencia();

        if($resultado->num_rows) {
          $alertas = Usuario::getAlertas();
        } else {
          // Hashear el password
          $usuario->hashPassword();

          // Crear token único para el usuario
          $usuario->crearToken();

          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarConfirmacion();

          // Crear el usuario
          $resultado = $usuario->guardar();

          if($resultado) {
            header("Location: /mensaje");
          }
          
        }
      }
  
    }
    $router->render("/auth/crear-cuenta", [
      "usuario" => $usuario,
      "alertas" => $alertas
    ]);
  }

  /** Mensaje de proceso
   * @param Router $router
   * @return void 
   */
  public static function mensaje(Router $router) : void {
    $router->render("/auth/mensaje", []);
  }

  /** Proceso de confirmación de cuenta a través de un token de uso único */
  public static function confirmar(Router $router) {
    $alertas = [];
    $token = s($_GET["token"]);
    $usuario = Usuario::where("token", $token);
    
    if(empty($usuario)) {
      Usuario::setAlerta("error", "Token no valido");
    } else {
      $usuario->confirmado = 1;
      $usuario->token = null;
      $usuario->guardar();
      $usuario::setAlerta("exito", "Cuenta comprobada correctamente");
    }

    // Obtener alertas
    $alertas = Usuario::getAlertas();

    // Importar la vista
    $router->render("/auth/confirmar", [
      "alertas" => $alertas
    ]);
  }
}
?>
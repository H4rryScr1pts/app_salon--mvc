<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
/**Clase para envio de e-mails */
class Email {
  public $email;
  public $nombre;
  public $token;
  /** Constructor de un nuevo email
   * @param string $email
   * @param string $nombre
   * @param mixed $token
  */
  public function __construct(string $email, string $nombre, string $token) {
    $this->email = $email;
    $this->nombre = $nombre;
    $this->token = $token;
  }

  /** Enviar un e-mail de confirmación de cuenta
   * @return void
   */
  public function enviarConfirmacion() : void {
    // Crear el objeto de email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $_ENV["EMAIL_HOST"];
    $mail->Port = $_ENV["EMAIL_PORT"];
    $mail->Username = $_ENV["EMAIL_USER"];
    $mail->Password = $_ENV["EMAIL_PASS"];
    $mail->SMTPAuth = true;

    $mail->setFrom('cuentas@appsalon.com');
    $mail->addAddress($this->email);
    $mail->Subject = "Confirma tu cuenta";


    $mail->isHTML(TRUE);
    $mail->CharSet = "UTF-8";


    $contenido = "<html>";
    $contenido .= "<p> <strong> Hola " . $this->nombre .  " </strong> Has creado tu cuenta en AppSalon, solo debes confirmarla precionando el siguiente enlace</p>";
    $contenido .= "<p> Preciona aqui: <a href='".$_ENV["APP_URL"]."/confirmar-cuenta?token=".$this->token."'>Confirmar Cuenta</a> </p>";
    $contenido .= "<p> Si tu no solicitaste este proceso, puedes ignorar el mensaje </p>";
    $contenido .= "</html>";

    $mail->Body = $contenido;

    // Enviar el email
    $mail->send();
  }

  /** Enviar intrucciones al usuario para crear un nuevo reestablecer su password
   * @return void
   */
  public function enviarInstrucciones() : void {  
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $_ENV["EMAIL_HOST"];
    $mail->Port = $_ENV["EMAIL_PORT"];
    $mail->Username = $_ENV["EMAIL_USER"];
    $mail->Password = $_ENV["EMAIL_PASS"];
    $mail->SMTPAuth = true;

    $mail->setFrom('cuentas@appsalon.com');
    $mail->addAddress($this->email);
    $mail->Subject = "Reestablece tu password";


    $mail->isHTML(TRUE);
    $mail->CharSet = "UTF-8";


    $contenido = "<html>"; // Contenido que se mostrará en el email
    $contenido .= "<p> <strong> Hola " . $this->nombre .  " </strong> Has solicitado reestablecer tu password, siguue el siguiente enlace para realizarlo </p>";
    $contenido .= "<p> Preciona aqui: <a href='".$_ENV["APP_URL"]."/recuperar?token=".$this->token."'>Reestablecer password</a> </p>";
    $contenido .= "<p> Si tu no solicitaste este cambio, puedes ignorar el mensaje </p>";
    $contenido .= "</html>";

    $mail->Body = $contenido;

    // Enviar el email
    $mail->send();
  }
}
?>
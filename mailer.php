<?php
    /**
     * PHPMailer multiple files upload and send
     */

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/PHPMailer.php';
    require './PHPMailer/SMTP.php';
    require './PHPMailer/Exception.php';

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    //Server settings
    //Mailjet User: correos@grupogeg.com
    //Mailjet Password: Rs0_-cusCLj5
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'noreply@feriacanadevi.mx';                     //SMTP username
    $mail->Password   = 'pY9pzBmTYZy.';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;
    // $mail->SMTPDebug = 1;

    if(isset($_POST['nombre'])) {
        $name = strip_tags(trim($_POST["nombre"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["correo"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["telefono"]);

        try {
            //Recipients
            $mail->setFrom('contacto@feriacanadevi.mx', 'Correo automatizado');
            $mail->addAddress('a.molina@mixen.agency');     //Add a recipient
            $mail->addAddress('luis.pando@mixen.agency');     //Add extra recipient
            $mail->addReplyTo($email, 'Hola Feria de Vivienda CANADEVI, necesito información.');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Nuevo registro de ' . $name;
            $mail->Body    = 'Nombre: ' . $name . '<br>Correo electrónico: ' . $email . '<br>Teléfono: ' . $phone . '<br><br>Este registro fue realizado desde el formulario en el sitio de Feria de Vivienda CANADEVI.';

            $mail->send();
            echo 'Gracias por tu registro. 😃';
        } catch (Exception $e) {
            echo 'Lo sentimos, algo salió mal. Por favor, inténtalo de nuevo. Mailer Error: ' . $mail->ErrorInfo;
        }
    }
?>
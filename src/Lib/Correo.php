<?php
    namespace Lib;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    class Correo{
        private PHPMailer $mail;
        public function __construct()
        {
            $this->mail=new PHPMailer();
        } 
        public function sendMail($email, $usuario) {
            $this->mail->isSMTP();
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->Port = 465;
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'respigares.spam@gmail.com';
            $this->mail->Password = 'gmwiqixepllkwunf';

            //Set who the message is to be sent from
            //Note that with gmail you can only use your account address (same as `Username`)
            //or predefined aliases that you have configured within your account.
            //Do not use user-submitted addresses in here
            $this->mail->setFrom('respigares.spam@gmail.com', 'ADMINISTRADOR');

            //Set an alternative reply-to address
            //This is a good place to put user-submitted addresses
            $this->mail->addReplyTo('respigares.spam@gmail.com', 'ADMINISTRADOR');

            //Set who the message is to be sent to
            $this->mail->addAddress("$email", "$usuario");
            $this->mail->isHTML(true);
            //Set the subject line
            $this->mail->Subject = 'PHPMailer GMail SMTP test';

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            // $this->mail->msgHTML(file_get_contents('contents.html'), __DIR__);

            //Replace the plain text body with one created manually
            $this->mail->Body = $this->crearHtml($usuario);

            //Attach an image file
            $this->mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$this->mail->send()) {
                echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }
        }
        public function crearHtml($user):string {
            $html="<!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Document</title>
            </head>
            <body>";
            $html.= "<h2>Hola $user</h2>";
            $html.= "<p> Su pedido ha sido tramitado y llegará en unos 4-6 días habiles.</p>";

            $html.="</body></html>";
            return $html;
        }
    }
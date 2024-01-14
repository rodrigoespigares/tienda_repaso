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

            //Set the subject line
            $this->mail->Subject = 'PHPMailer GMail SMTP test';

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            // $this->mail->msgHTML(file_get_contents('contents.html'), __DIR__);

            //Replace the plain text body with one created manually
            $this->mail->Body = 'Holiwi';

            //Attach an image file
            $this->mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$this->mail->send()) {
                echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            } else {
                echo 'Message sent!';
                //Section 2: IMAP
                //Uncomment these to save your message in the 'Sent Mail' folder.
                #if (save_mail($mail)) {
                #    echo "Message saved!";
                #}
            }

            //Section 2: IMAP
            //IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
            //Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
            //You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
            //be useful if you are trying to get this working on a non-Gmail IMAP server.
            function save_mail($mail)
            {
                //You can change 'Sent Mail' to any other folder or tag
                $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

                //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
                $imapStream = imap_open($path, $mail->Username, $mail->Password);

                $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                imap_close($imapStream);

                return $result;
            }
        }


    }
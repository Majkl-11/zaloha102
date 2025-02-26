<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

function odeslatRegistracniEmail(string $email, string $jmeno): bool
{
    $mail = new PHPMailer(true);
    $mail->setLanguage('cs', 'PHPMailer-master/language/');
    $mail->CharSet = 'UTF-8';

    try {
        // SMTP nastavení
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'vizitkycalek@gmail.com';
        $mail->Password = 'wxcaibrtiwoqtrcm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Odesílatel
        $mail->setFrom('vizitkycalek@gmail.com', 'Vizitky Čálek');
        $mail->addReplyTo('vizitkycalek@gmail.com', 'Podpora Vizitky Čálek');

        // Příjemce
        $mail->addAddress($email, $jmeno);

        // Nastavení emailu
        $mail->isHTML(true);
        $mail->Subject = 'Registrace úspěšná';
        $mail->Body = "<p>Dobrý den <strong>$jmeno</strong>,</p>
                       <p>Vaše registrace proběhla úspěšně. Nyní se můžete přihlásit do svého účtu.</p>
                       <p>S pozdravem,<br><strong>Vizitky Čálek</strong></p>";
        $mail->AltBody = "Dobrý den $jmeno, Vaše registrace proběhla úspěšně. Nyní se můžete přihlásit.";

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

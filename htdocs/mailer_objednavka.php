<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získání údajů z formuláře
    $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['zprava']); }

    // Ověření, zda je e-mail validní
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        die("Neplatná e-mailová adresa.");
    }

$mail = new PHPMailer(true);
$mail->setLanguage('cs', 'PHPMailer-master/language/');
$mail->CharSet = 'UTF-8';
try
{
    // Nastavení SMTP serveru
    $mail->SMTPDebug = SMTP::DEBUG_OFF;  
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'vizitkycalek@gmail.com'; // Jméno, které nám vygeneroval Mailtrap
    $mail->Password = 'wxcaibrtiwoqtrcm'; // Heslo, které nám vygeneroval Mailtrap
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; // Port generovaný SMTP serverem

        // Odesílatel
    $mail->setFrom('vizitkycalek@gmail.com', 'Vizitky Web');
    $mail->addReplyTo('vizitkycalek@gmail.com', 'Podpora');

 // Příjemce (e-mail z formuláře)
 $mail->addAddress($userEmail);

    // Přílohy
    // $mail->addAttachment('dokument.docx'); // Příloha 1
    // $mail->addAttachment('obrazek.jpg', 'muj_obrazek.jpg'); // Příloha 2

    // Kontent
    $mail->isHTML(true);
    $mail->Subject = 'Děkujeme za zprávu!';
    $mail->Body = "<p>Dobrý den,</p>
                    <p>děkujeme, že jste nás kontaktovali. Vaše zpráva:</p>
                    <p><em>$message</em></p>
                    <p>Ozveme se vám co nejdříve!</p>";
    $mail->AltBody = 'Toto se zobrazí, když příjemce nepodporuje HTML'; // Text v případě příjemce nepodporujícího HTML

// Odeslání e-mailu
$mail->send();
echo "E-mail byl odeslán na: " . htmlspecialchars($userEmail);
} catch (Exception $e) {
echo "Zpráva nebyla odeslána. Chyba: " . $mail->ErrorInfo;
}
?>

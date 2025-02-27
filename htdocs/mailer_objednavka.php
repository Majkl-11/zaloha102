<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

function sendOrderEmail($userEmail, $orderId, $quantity, $price, $companyName, $phoneNumber) {
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

        $mail->setFrom('vizitkycalek@gmail.com', 'Vizitky Čálek');
        $mail->addReplyTo('vizitkycalek@gmail.com', 'Vizitky Čálek');

        // Přidání příjemce
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            return false; // Neplatný e-mail, neodesílej
        }
        $mail->addAddress($userEmail);

        // Formátování ceny
        $formattedPrice = number_format($price, 2, ',', ' ');

        $mail->isHTML(true);
        $mail->Subject = "Potvrzení objednávky č. $orderId";
        $mail->Body = "<h3>Potvrzení objednávky</h3>
                       <p>Děkujeme za vaši objednávku.</p>
                       <p><strong>Číslo objednávky:</strong> $orderId</p>
                       <p><strong>Společnost:</strong> $companyName</p>
                       <p><strong>Telefon:</strong> $phoneNumber</p>
                       <p><strong>Počet kusů:</strong> $quantity</p>
                       <p><strong>Cena:</strong> $formattedPrice Kč</p>
                       <p>Ozveme se vám zda vaší objednávku vyhotovíme do 3 pracovních dnů</p>
                       <p>S návrhem vaší vizitky se vám ozveme do 7 pracovních dnů.</p>";

        $mail->AltBody = "Potvrzení objednávky\n\n
                          Číslo objednávky: $orderId\n
                          Společnost: $companyName\n
                          Telefon: $phoneNumber\n
                          Počet kusů: $quantity\n
                          Cena: $formattedPrice Kč";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Chyba při odesílání e-mailu: " . $mail->ErrorInfo;
    }
}

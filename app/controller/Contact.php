<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Contact extends Controller
{
    const EMAIL_NOREPLY = 'noreply@localhost';
    const EMAIL_TO = 'email';

    protected function MethodPost() : void
    {
        $p = $this->PreparePost(['name', 'email', 'message']);

        $utils = new Utils();
        $utils->EnableAlert_Direct($this);

        $valide = true;

        if(!$utils->NotBlank('name', $p->name)
        || !$utils->MinLength('name', $p->name, 3)
        || !$utils->MaxLength('name', $p->name, 70))
            $valide = false;

        if(!$utils->NotBlank('email', $p->email)
        || !$utils->ValidateEmail('email', $p->email))
            $valide = false;

        if(!$utils->NotBlank('message', $p->message)
        || !$utils->MinLength('message', $p->message, 3)
        || !$utils->MaxLength('message', $p->message, 1000))
            $valide = false;

        if($valide)
        {
            if($this->send($p->name,$p->email,$p->message)) {
                $session = new Session($this);
                $session->ClearAlert();
                $utils->EnableAlert_Redirect($session);
                $utils->AddValide('Votre message de contact a bien été envoyé !');
                $this->redirect('contact');
            }
            $utils->AddError('Problème d\'envoie du mail !');
        }

        $this->MethodGet();
    }

    public function MethodGet() : void
    {
        $session = new Session($this);
        $session->ShowAllAlertAndClear();
    }

    private function send(string $name, string $email, string $message) : bool
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'host smtp';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'identifiant';                     // SMTP username
            $mail->Password   = 'mot de passe';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->CharSet = 'UTF-8';
            
            //Recipients
            $mail->setFrom('adresse mail', 'NoReply');
            $mail->addAddress('email', 'prénom nom');     // Add a recipient
            $mail->addReplyTo($email, $name);
            // Content
            $mail->Subject = 'Contact de '.$name;
            $mail->Body = 'Formulaire de contact :'."\r\n".$message."\r\n\r\n".$email;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

?>
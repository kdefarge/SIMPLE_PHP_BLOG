<?php

namespace app\controller;

use app\model\Controller;
use app\model\Utils;
use app\model\Session;

class Contact extends Controller
{
    const EMAIL_NOREPLY = '';
    const EMAIL_TO = '';

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
            $headers = array(
                'From' => self::EMAIL_NOREPLY,
                'Reply-To' => $p->email,
                'X-Mailer' => 'PHP/' . phpversion()
            );
            $message = wordwrap($p->message, 70, "\r\n");
            $message = $p->name."\r\n".'Formulaire de contact :'."\r\n".$message."\r\n\r\n".$p->email;
            if(mail(self::EMAIL_TO, 'Contact de '.$p->name, $message, $headers))
            {
                $session =  new Session($this);
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
}

?>
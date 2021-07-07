<?php

namespace AppBundle\Service;


class EmailSender
{
  private $mailer;

  public function __construct(\Swift_Mailer $mailer, $mailerFromEmail,\Twig_Environment $twig)
  {
    $this->mailer = $mailer;
    $this->mailerFromEmail = $mailerFromEmail;
    $this->twig = $twig;
  }

  public function send($request)
  {
    $bodyContent = $this->twig->render('emails/contact.html.twig', compact('request'));

    $subject = 'Zgłoszenie zapytania o produkt z prośbą o kontakt';
    $message = (new \Swift_Message($subject))
      ->setFrom($this->mailerFromEmail)
      ->setTo($this->mailerFromEmail)
      ->setBody($bodyContent, 'text/html');

    return $this->mailer->send($message);
  }
}
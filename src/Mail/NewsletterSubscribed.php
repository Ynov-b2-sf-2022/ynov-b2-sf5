<?php

namespace App\Mail;

use App\Entity\Newsletter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NewsletterSubscribed
{
  private $mailer;
  private $adminEmail;

  public function __construct(MailerInterface $mailer, string $adminEmail)
  {
    $this->mailer = $mailer;
    $this->adminEmail = $adminEmail;
  }

  public function sendConfirmation(Newsletter $newsletter)
  {
    $email = (new Email())
      ->from($this->adminEmail)
      ->to($newsletter->getEmail())
      ->subject("Inscription à la newsletter")
      ->text("Votre email " . $newsletter->getEmail() . " a bien été enregistré, merci");

    $this->mailer->send($email);
  }
}

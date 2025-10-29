<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{

    public function __construct(
        private MailerInterface $mailer
    ) {}

    #region Registration Email - utilisé par RegistrationController
    public function sendRegistrationEmail($user, string $updatePasswordLink): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to(is_string($user) ? $user : $user->getEmail())
            ->subject('Bienvenue sur EasyPAE - Définissez votre mot de passe')
            ->htmlTemplate('emails/registration.html.twig')
            ->context([
                'subject' => 'Bienvenue sur EasyPAE - Définissez votre mot de passe',
                'userName' => is_string($user) ? 'Utilisateur' : $user->getFirstName() . ' ' . $user->getLastName(),
                'updatePasswordLink' => $updatePasswordLink,
            ]);

        $this->mailer->send($email);
    }
    #endregion
    
    #region Reset Password Email - utilisé par SecurityController
    public function sendResetPasswordEmail($user, string $resetPasswordLink): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to(is_string($user) ? $user : $user->getEmail())
            ->subject('Réinitialisation de votre mot de passe EasyPAE')
            ->htmlTemplate('emails/reset_password.html.twig')
            ->context([
                'subject' => 'Réinitialisation de votre mot de passe EasyPAE',
                'userName' => is_string($user) ? 'Utilisateur' : $user->getFirstName() . ' ' . $user->getLastName(),
                'resetPasswordLink' => $resetPasswordLink,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Welcome Email
    public function sendWelcomeEmail(string $to, string $subject, string $name): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject($subject)
            ->htmlTemplate('emails/welcome.html.twig')
            ->context([
                'subject' => $subject,
                'userName' => $name,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Notification Email
    public function sendNotificationEmail(string $to, string $subject, string $name, string $message): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject($subject)
            ->htmlTemplate('emails/notification.html.twig')
            ->context([
                'subject' => $subject,
                'userName' => $name,
                'message' => $message,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Form Submitted Email
    public function sendFormSubmittedEmail(string $to, string $subject, string $name, array $formData): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject($subject)
            ->htmlTemplate('emails/form_submitted.html.twig')
            ->context([
                'subject' => $subject,
                'userName' => $name,
                'formData' => $formData,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Generic Email
    public function sendEmail(string $to, string $subject, string $template, array $context = []): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        $this->mailer->send($email);
    }
    #endregion
}

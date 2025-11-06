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

    #region Intern Account Activation Email
    public function sendInternAccountActivationEmail(string $to, string $firstName, string $lastName, string $activationLink, string $trainingSessionName): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('Bienvenue sur EasyPAE - Activez votre compte')
            ->htmlTemplate('emails/registration.html.twig')
            ->context([
                'subject' => 'Bienvenue sur EasyPAE - Activez votre compte',
                'userName' => $firstName . ' ' . $lastName,
                'updatePasswordLink' => $activationLink,
                'trainingSession' => $trainingSessionName,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Organization - Intern Created PAE
    public function sendOrganizationInternCreatedPAEEmail(string $to, string $internFirstName, string $internLastName, \DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('Nouvelle demande de PAE initiée')
            ->htmlTemplate('emails/organization_intern_created_pae.html.twig')
            ->context([
                'subject' => 'Nouvelle demande de PAE initiée',
                'internFirstName' => $internFirstName,
                'internLastName' => $internLastName,
                'dateStart' => $dateStart->format('d/m/Y'),
                'dateEnd' => $dateEnd->format('d/m/Y'),
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Organization - Intern Validated Volet
    public function sendOrganizationInternValidatedEmail(string $to, string $internFirstName, string $internLastName, string $companyName): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('Demande de PAE validée par le stagiaire')
            ->htmlTemplate('emails/organization_intern_validated.html.twig')
            ->context([
                'subject' => 'Demande de PAE validée par le stagiaire',
                'internFirstName' => $internFirstName,
                'internLastName' => $internLastName,
                'companyName' => $companyName,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Company - Activation Email (Existing Company)
    public function sendCompanyActivationExistingCompanyEmail(string $to, string $firstName, string $lastName, string $companyName, string $internFirstName, string $internLastName, string $activationLink): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('Un stagiaire souhaite effectuer son stage dans votre entreprise')
            ->htmlTemplate('emails/company_activation_existing_company.html.twig')
            ->context([
                'subject' => 'Un stagiaire souhaite effectuer son stage dans votre entreprise',
                'firstName' => $firstName,
                'lastName' => $lastName,
                'companyName' => $companyName,
                'internFirstName' => $internFirstName,
                'internLastName' => $internLastName,
                'activationLink' => $activationLink,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Company - Activation Email (New Company)
    public function sendCompanyActivationNewCompanyEmail(
        string $to,
        int $infoFormId,
        string $firstName,
        string $lastName,
        string $tutorEmail,
        string $companyName,
        string $companyAddress,
        string $internFirstName,
        string $internLastName,
        string $activationLink
    ): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('Bienvenue sur EasyPAE - Un stagiaire souhaite vous rejoindre')
            ->htmlTemplate('emails/company_activation_new_company.html.twig')
            ->context([
                'subject' => 'Bienvenue sur EasyPAE - Un stagiaire souhaite vous rejoindre',
                'infoFormId' => $infoFormId,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'tutorEmail' => $tutorEmail,
                'companyName' => $companyName,
                'companyAddress' => $companyAddress,
                'activationLink' => $activationLink,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Company - Notification Email (Existing User)
    public function sendCompanyNotificationExistingUserEmail(string $to, string $firstName, string $lastName, string $companyName, string $internFirstName, string $internLastName, string $loginUrl): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('Un nouveau stagiaire souhaite effectuer son stage chez vous')
            ->htmlTemplate('emails/company_notification_existing_user.html.twig')
            ->context([
                'subject' => 'Un nouveau stagiaire souhaite effectuer son stage chez vous',
                'firstName' => $firstName,
                'lastName' => $lastName,
                'companyName' => $companyName,
                'internFirstName' => $internFirstName,
                'internLastName' => $internLastName,
                'loginUrl' => $loginUrl,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Intern - Company Validated
    public function sendInternCompanyValidatedEmail(string $to, string $internFirstName, string $internLastName, string $companyName, \DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('Bonne nouvelle ! Votre entreprise d\'accueil a validé')
            ->htmlTemplate('emails/intern_company_validated.html.twig')
            ->context([
                'subject' => 'Bonne nouvelle ! Votre entreprise d\'accueil a validé',
                'internFirstName' => $internFirstName,
                'internLastName' => $internLastName,
                'companyName' => $companyName,
                'dateStart' => $dateStart->format('d/m/Y'),
                'dateEnd' => $dateEnd->format('d/m/Y'),
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Organization - Company Validated
    public function sendOrganizationCompanyValidatedEmail(string $to, string $internFirstName, string $internLastName, string $companyName): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('PAE prêt à signer')
            ->htmlTemplate('emails/organization_company_validated.html.twig')
            ->context([
                'subject' => 'PAE prêt à signer',
                'internFirstName' => $internFirstName,
                'internLastName' => $internLastName,
                'companyName' => $companyName,
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Intern - PAE Completed
    public function sendInternPAECompletedEmail(string $to, string $internFirstName, string $internLastName, \DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('🎉 Votre PAE est validé')
            ->htmlTemplate('emails/intern_pae_completed.html.twig')
            ->context([
                'subject' => '🎉 Votre PAE est validé',
                'internFirstName' => $internFirstName,
                'internLastName' => $internLastName,
                'dateStart' => $dateStart->format('d/m/Y'),
                'dateEnd' => $dateEnd->format('d/m/Y'),
            ]);

        $this->mailer->send($email);
    }
    #endregion

    #region Company - PAE Completed
    public function sendCompanyPAECompletedEmail(string $to, string $firstName, string $lastName, string $internFirstName, string $internLastName, \DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@easypae.com')
            ->to($to)
            ->subject('PAE officiellement validé')
            ->htmlTemplate('emails/company_pae_completed.html.twig')
            ->context([
                'subject' => 'PAE officiellement validé',
                'firstName' => $firstName,
                'lastName' => $lastName,
                'internFirstName' => $internFirstName,
                'internLastName' => $internLastName,
                'dateStart' => $dateStart->format('d/m/Y'),
                'dateEnd' => $dateEnd->format('d/m/Y'),
            ]);

        $this->mailer->send($email);
    }
    #endregion
}

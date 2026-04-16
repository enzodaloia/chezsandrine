<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('index/contact.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/send-message', name: 'app_send_message', methods: ['POST'])]
    public function send(Request $request): Response
    {
        $fullname = $request->request->get('fullname');
        $telephone = $request->request->get('telephone');
        $emailUser = $request->request->get('email');
        $messageUser = $request->request->get('message');

        // Construction du texte du mail
        $texteMail = "Vous avez reçu un nouveau message via le formulaire de contact du restaurant :\n\n";

        if (!empty($fullname)) {
            $texteMail .= "Nom et prénom : $fullname\n";
        }

        $texteMail .= "Téléphone : $telephone\n";
        $texteMail .= "Email : $emailUser\n\n";
        $texteMail .= "Message :\n$messageUser";

        $email = (new Email())
            ->from('contact@restaurant-chez-sandrine.fr')
            ->replyTo($emailUser)
            // ->to('campingchalaronne@orange.fr')
            ->to('enzo73.daloia@gmail.com')
            ->subject('Nouveau message du site du camping')
            ->text($texteMail);

        // Utilisation directe du transport OVH pour être sûr que ça marche
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailerDirect = new \Symfony\Component\Mailer\Mailer($transport);
        $mailerDirect->send($email);

        $this->addFlash('success', 'Votre message a bien été envoyé.');
        return $this->redirectToRoute('app_contact');
    }

    #[Route('/test-ovh-mail', name: 'app_test_ovh_mail')]
    public function testOvhMail(): Response
    {
        // Crée le mail de test
        $email = (new Email())
            ->from('contact@restaurant-chez-sandrine.fr')
            ->to('enzo73.daloia@gmail.com')
            ->subject('Test OVH SMTP')
            ->text("Ceci est un test d'envoi direct via SMTP OVH.");

        try {
            // Crée un transport OVH TLS port 587
            $transport = Transport::fromDsn('smtp://contact@restaurant-chez-sandrine.fr:Sandrinepanchaud2026%21@smtp.mail.ovh.net:587?encryption=tls&auth_mode=login');
            $debugMailer = new \Symfony\Component\Mailer\Mailer($transport);

            $debugMailer->send($email);

            $this->addFlash('success', 'Test SMTP OVH réussi ! Mail envoyé.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors du test SMTP OVH : ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_contact');
    }
}

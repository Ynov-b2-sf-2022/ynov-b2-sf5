<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Mail\NewsletterSubscribed;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter/register", name="newsletter_register")
     */
    public function register(
        Request $request,
        EntityManagerInterface $em,
        NewsletterSubscribed $notificationService
    ): Response {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newsletter->setCreated(new DateTime());
            $em->persist($newsletter);
            $em->flush();
            $this->addFlash('success', 'Votre email a été enregistré, merci');
            $notificationService->sendConfirmation($newsletter);
            return $this->redirectToRoute('app_index');
        }

        return $this->renderForm('newsletter/register.html.twig', [
            'form' => $form
        ]);
    }
}

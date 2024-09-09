<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Project;
use App\Form\ContactType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function input(Contact $contact): void
    {
        // Mettez à jour les informations supplémentaires ici
        $contact->setCreatedAt(new DateTimeImmutable());
        $contact->setReadOrNot('0');

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        // Ajoutez un message flash
        $this->addFlash('notice', "Merci de m'avoir contacté. Je vous répondrai dans les plus brefs délais.");
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);

        $contactForm->handleRequest($request);

        $formSubmitted = false;

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // Passez l'objet Contact directement à la méthode input
            $this->input($contact);

            // Indiquer que le formulaire a été soumis avec succès
            $formSubmitted = true;

            // Rediriger pour éviter le rechargement du formulaire
            return $this->redirectToRoute('app_home');
        }

        $this->addFlash('notice', "Merci de m'avoir contacté. Je vous répondrai dans les plus brefs délais.");

        $projects = $this->entityManager->getRepository(Project::class)->findByVisible('visible');

        return $this->render('home/index.html.twig', [
            'contactForm' => $contactForm->createView(),
            'projects' => $projects,
            'formSubmitted' => $formSubmitted
        ]);
    }
}

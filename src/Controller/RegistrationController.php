<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        //vérification si le formulaire est bien rempli et soumis
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // dd($user);
            $search_username = $this->entityManager->getRepository(User::class)->findOneByUsername($user->getUsername());

            //vérification si l'email n'est pas connu de la bdd
            if (!$search_username) {
                $password = $encoder->hashPassword($user, $user->getPassword());
                $user->setPassword($password);

                //préparation des données pour l'envoi
                $this->entityManager->persist($user);

                //envoi dans la bdd
                $this->entityManager->flush();
            }

        } else {

            $notification = 'Votre adresse mail est déjà connu, vous ne pouvez pas recréer un compte.';
            
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification

        ]);
    }
}

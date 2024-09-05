<?php

namespace App\Controller;

use App\Entity\ImgProject;
use App\Entity\Project;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/project/{slug}', name: 'app_project')]
    public function index($slug): Response
    {
        $project = $this->entityManager->getRepository(Project::class)->findOneBySlug($slug);
        $imgProject = $this->entityManager->getRepository(ImgProject::class)->findByProject($project);

        if (!$project) {
            return $this->redirectToRoute('/');
        }

        return $this->render('project/index.html.twig', [
            'project' => $project,
            'imgProject' => $imgProject,
        ]);
    }
}

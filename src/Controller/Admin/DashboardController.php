<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\ImgProject;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProjectCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mon portfolio');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Messagerie');
        yield MenuItem::linkToCrud('Messages', 'fa fa-message', Contact::class);

        yield MenuItem::section('Création de projet');
        yield MenuItem::linkToCrud('Mes projets', 'fas fa-list', Project::class);
        yield MenuItem::linkToCrud('Galerie par projet', 'fa-regular fa-images', ImgProject::class);
        
        yield MenuItem::section('');
        yield MenuItem::linkToUrl('Revenir au portfolio', 'fa fa-arrow-left', '/');
    }
}

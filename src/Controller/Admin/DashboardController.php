<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        // Vérifie si l'utilisateur a au moins un rôle requis pour accéder à l'administration
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_EDITOR') && !$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException('Accès non autorisé.');
        }

        // Génère une URL en fonction du rôle de l'utilisateur
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($adminUrlGenerator->setController(UsersCrudController::class)->generateUrl());
        }

        if ($this->isGranted('ROLE_EDITOR')) {
            // Redirection pour les éditeurs (exemple)
            //return $this->redirect($adminUrlGenerator->setController(SomeEditorCrudController::class)->generateUrl());
        }

        if ($this->isGranted('ROLE_USER')) {
            // Redirection pour les utilisateurs simples (exemple)
            return $this->render('admin/dashboard_user.html.twig');
        }

        // Si aucun rôle spécifique, affiche une vue par défaut
        return $this->render('admin/dashboard.html.twig');        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Walanda Admin')
            ->setFaviconPath('favicon.ico')
            ->renderContentMaximized();

        //return Dashboard::new()
        //    ->setTitle('Walanda 0 0 1');
    }

    public function configureMenuItems(): iterable
    {
        // Menu commun à tous les utilisateurs ayant accès à l'administration
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        // Menu spécifique aux administrateurs
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Gestion');
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', Users::class);
            yield MenuItem::section('Paramètres');
            yield MenuItem::linkToRoute('Configuration', 'fas fa-cogs', 'app_config');
    
        }

        // Menu spécifique aux rédacteurs
        if ($this->isGranted('ROLE_EDITOR')) {
            yield MenuItem::section('Rédaction');
            //yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Article::class); // Exemple
        }

        // Menu spécifique aux utilisateurs simples
        if ($this->isGranted('ROLE_USER')) {
            yield MenuItem::section('Espace Utilisateur');
            yield MenuItem::linkToRoute('Mes informations', 'fas fa-user', 'app_user_profile');
        }

        // Menu commun à tous les utilisateurs connectés
        yield MenuItem::linkToLogout('Déconnexion', 'fas fa-sign-out-alt');
    }
}

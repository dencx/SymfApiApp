<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Offer;
use App\Entity\Product;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Best offers for products');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Offer', 'fa fa-list', Offer::class);
        yield MenuItem::linkToCrud('Products list', 'fa fa-list', Product::class);
        yield MenuItem::linkToRoute('Logout', 'fa fa-sign-out', 'logout');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

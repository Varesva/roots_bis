<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
        // page d'accueil du Dashboard Admin 
    /**
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin_dashboard/base.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
}

<?php

namespace App\Controller\User\Dashboard;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class DashboardController
 * @package App\Controller\User\Dashboard
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard.view")
     */
    public function dashboardAction()
    {
        return $this->render('user/dashboard/view.html.twig');
    }
}

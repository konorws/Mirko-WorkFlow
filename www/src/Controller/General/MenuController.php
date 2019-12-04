<?php

namespace App\Controller\General;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * For render menu block
 *
 * Class MenuController
 * @package App\Controller\General
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class MenuController extends AbstractController
{

    public function displayAction()
    {
        return $this->render("general/menu/view.html.twig");
    }
}

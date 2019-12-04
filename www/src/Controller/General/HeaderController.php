<?php

namespace App\Controller\General;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * For render header block
 *
 * Class HeaderController
 * @package App\Controller\General
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class HeaderController extends AbstractController
{

    /**
     * Render header top block
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayAction()
    {
        return $this->render("general/header/view.html.twig");
    }
}

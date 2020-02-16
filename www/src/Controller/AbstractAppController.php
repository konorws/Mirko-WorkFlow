<?php

namespace App\Controller;

use App\Entity\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AbstractAppController
 *
 * @package App\Controller
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019-2020 <https://mirko.in.ua>
 */
abstract class AbstractAppController extends AbstractController
{
    /**
     * @return User
     */
    public function getUser()
    {
        return parent::getUser();
    }
}
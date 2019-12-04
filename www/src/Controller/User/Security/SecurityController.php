<?php

namespace App\Controller\User\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class SecurityController
 * @package App\Controller\User\Security
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/user/login", name="user.security.login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/user/auth", name="user.security.auth", methods={"POST"})
     */
    public function checkLoginAction()
    {
    }

    /**
     * @Route("/user/logout", name="user.security.logout")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction(Request $request)
    {
        $this->get('security.token_storage')->setToken(NULL);
        $request->getSession()->invalidate();

        return $this->redirect($this->generateUrl('user.security.login'));
    }
}

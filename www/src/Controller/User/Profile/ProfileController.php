<?php

namespace App\Controller\User\Profile;

use App\Entity\User\User;
use App\Form\Type\User\ProfileType;
use App\Exception\NotFoundException;
use App\Repository\User\UserRepository;
use App\Exception\PermissionDeniedException;
use App\Form\Type\Attachment\AttachmentType;
use App\Service\Attachment\AttachmentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ProfileController
 * @package App\Controller\User\Profile
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class ProfileController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var AttachmentService
     */
    private $attachmentService;

    /**
     * ProfileController constructor.
     * @param ContainerInterface $container
     * @param AttachmentService $attachmentService
     */
    public function __construct(ContainerInterface $container, AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
        $this->userRepository = $container->get("doctrine")->getRepository(User::class);
    }

    /**
     * @Route("user/profile/{user_id}", name="user.profile.view")
     *
     * @param int $user_id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws NotFoundException
     */
    public function viewAction(int $user_id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($user_id);
        if ($user === null) {
            throw new NotFoundException("User by id <{$user_id}> not found");
        }

        return $this->render("@App/user/profile/view.html.twig", [
            'user' => $user,
            'myProfile' => $this->getUser()->getId() === $user->getId(),
        ]);
    }

    /**
     * @Route("user/profile/{user_id}/edit", name="user.profile.edit")
     *
     * @param int $user_id
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws NotFoundException
     * @throws PermissionDeniedException
     * @throws \App\Exception\UndefinedErrorException
     */
    public function editAction(int $user_id, Request $request)
    {
        /** @var User $user */
        $user = $this->userRepository->find($user_id);
        if ($user === null) {
            throw new NotFoundException("User by id <{$user_id}> not found");
        }

        if ($user->getId() !== $this->getUser()->getId()) {
            throw new PermissionDeniedException();
        }

        // Form user profile
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Success update");
        }

        // Image update
        $imageForm = $this->createForm(AttachmentType::class);
        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $file = $imageForm['file']->getData();

            if (!$this->attachmentService->validateFile($file, AttachmentService::TYPE_IMAGE)) {
                $this->addFlash("error", "Invalid image file");
                return $this->redirect($this->generateUrl("user.profile.edit", [
                    'user_id' => $this->getUser()->getId()
                ]));
            }

            $attachment = $this->attachmentService->saveUploaded($file, "user.avatars");

            if($user->getImage() !== NULL) {
                $oldAttachment = $user->getImage();
                $user->setImage(NULL);
                $this->attachmentService->removeAttachment($oldAttachment);
            }

            $user->setImage($attachment);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Success image update");
        }

        return $this->render("@App/user/profile/edit.html.twig", [
            'user' => $user,
            'form' => $form->createView(),
            'imageForm' => $imageForm->createView()
        ]);
    }
}

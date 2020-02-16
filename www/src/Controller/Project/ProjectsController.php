<?php

namespace App\Controller\Project;

use App\Controller\AbstractAppController;
use App\Entity\Project\Project;
use App\Exception\NotFoundException;
use App\Form\Type\Project\CreateFormType;
use App\Guard\Project\ProjectGuard;
use App\ObjectValue\Project\ProjectRole;
use App\Repository\Project\ProjectRepository;
use App\Service\Project\SaveService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectsController
 * @package App\Controller\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class ProjectsController extends AbstractAppController
{
    /**
     * @var ProjectRepository
     */
    protected $projectRepository;
    /**
     * @var SaveService
     */
    private $saveService;

    /**
     * ProjectsController constructor.
     * @param ProjectRepository $projectRepository
     * @param SaveService $saveService
     */
    public function __construct(
        ProjectRepository $projectRepository,
        SaveService $saveService
    ) {
        $this->saveService = $saveService;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("project/list", name="project.list")
     */
    public function listAction()
    {
        $projects = $this->projectRepository->getProjectByUser($this->getUser());

        return $this->render('@App/user/project/list/view.html.twig', [
            'projects' => $projects
        ]);
    }

    /**
     * @Route("project/create", name="project.create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exception\NotFoundException
     */
    public function createAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(CreateFormType::class)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $project = $this->saveService->editProject($project, $form->getData());

            $this->saveService->addMember($project, $this->getUser(), ProjectRole::ROLE_OWNER);

            $objectManager = $this->container->get("doctrine")->getManager();

            $objectManager->persist($project);
            $objectManager->flush();

            $this->addFlash("success", "Project success create");
            return $this->redirect($this->generateUrl("project.list"));
        }

        return $this->render("@App/user/project/form/create.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("project/{id}/edit", name="project.edit")
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws NotFoundException
     * @throws \App\Exception\PermissionDeniedException
     */
    public function editAction(int $id, Request $request)
    {
        /** @var Project $project */
        $project = $this->projectRepository->find($id);
        if($project === NULL) {
            throw new NotFoundException("Project not found");
        }

        ProjectGuard::edit($project, $this->getUser());

        $form = $this->createForm(CreateFormType::class, $project)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $project = $this->saveService->editProject($project, $form->getData());
            $objectManager = $this->container->get("doctrine")->getManager();

            $objectManager->persist($project);
            $objectManager->flush();

            $this->addFlash("success", "Project success update");
            return $this->redirect($this->generateUrl("project.list"));
        }

        return $this->render("@App/user/project/form/edit.html.twig", [
            'form' => $form->createView()
        ]);

    }
}

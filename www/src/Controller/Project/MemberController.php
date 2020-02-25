<?php

namespace App\Controller\Project;

use App\Controller\AbstractAppController;
use App\Entity\Project\ProjectMember;
use App\Entity\User\User;
use App\Exception\NotFoundException;
use App\Guard\Project\ProjectGuard;
use App\ObjectValue\Project\ProjectRole;
use App\ObjectValue\User\RoleObjectValue;
use App\Repository\Project\ProjectRepository;
use App\Service\Project\SaveService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MemberController
 * @package App\Controller\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019-2020 <https://mirko.in.ua>
 */
class MemberController extends AbstractAppController
{

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * ProjectsController constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(
        ProjectRepository $projectRepository
    ) {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("project/{project}/member", name="project.member.list")
     * @param int $project
     * @return Response
     *
     * @throws NotFoundException
     */
    public function listAction(int $project)
    {
        $project = $this->projectRepository->find($project);
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $usersInProject = [];
        foreach ($project->getMembers()->getValues() as $member) {
            $usersInProject[] = $member->getId();
        }

        /** @var User[] $users */
        $users = $userRepository->findAll();
        // Exclude member
        foreach ($users as $key => $user) {
            if(in_array($user->getId(), $usersInProject)) {
                unset($users[$key]);
                continue;
            }
        }

        return $this->render("@App/user/project/list/member.html.twig", [
            "members" => $project->getMembers(),
            "project" => $project,
            "addMember" => [
                "users" => $users,
                "roles" => ProjectRole::getAllValues()
            ]
        ]);
    }

    /**
     * @Route("project/{project}/member/add", name="project.member.add", methods={"POST"})
     *
     * @param int $project
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws NotFoundException
     * @throws \App\Exception\PermissionDeniedException
     */
    public function addAction(int $project, Request $request)
    {
        $project = $this->projectRepository->find($project);
        ProjectGuard::edit($project, $this->getUser());

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $userId = $request->get("user");
        $user = $userRepository->find($userId);

        $role = $request->get("role");
        if(!ProjectRole::hasExist($role)) {
            throw new NotFoundException("Project role is not valid");
        }

        $projectMember = ProjectMember::create($project, $user, $role);
        $this->getDoctrine()->getManager()->persist($projectMember);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash("success", "User success added to project");
        return $this->redirect($this->generateUrl("project.member.list", ["project" => $project->getId()]));
    }
}
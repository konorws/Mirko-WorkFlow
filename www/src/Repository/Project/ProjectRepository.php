<?php

namespace App\Repository\Project;

use App\Entity\Project\Project;
use App\Entity\Project\ProjectMember;
use App\Entity\User\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ProjectRepository
 * @package App\Repository\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class ProjectRepository extends ServiceEntityRepository
{

    /**
     * ProjectRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @param User $user
     * @param array $filters
     *
     * @return Project[]
     */
    public function getProjectByUser(User $user, array $filters = [
        'closed' => false
    ])
    {
        $query = $this->createQueryBuilder('p');
        $query->select('p');
        $query->leftJoin(ProjectMember::class, 'pm', Join::WITH,
            $query->expr()->eq("pm.project", 'p.id')
        )->where($query->expr()->eq("pm.user", ":user"))
        ->setParameter("user", $user);

        $this->buildFilter($query, $filters);

        return $query->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @param array $filters
     */
    protected function buildFilter(QueryBuilder $queryBuilder, array $filters)
    {
        // Status
        if($filters['closed'] !== "*") {
            $queryBuilder->andWhere($queryBuilder->expr()->eq("p.closed", ':closed'))
                ->setParameter('closed', $filters['closed']);
        }
    }
}

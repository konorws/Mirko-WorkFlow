<?php

namespace App\Service\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;

/**
 * Class
 * @package App\Service\User
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 1019-2020 <https://mirko.in.ua>
 */
class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $username
     * @return bool
     */
    public function isUniqUsername(string $username): bool
    {
        $user = $this->userRepository->findOneBy(['username' => $username]);

        return $user === NULL;
    }

    /**
     * @param User $user
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveNewUser(User $user)
    {
        $this->userRepository->persist($user);
    }
}
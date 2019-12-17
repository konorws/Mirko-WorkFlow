<?php

namespace App\Entity\User;

use App\Entity\Attachment\Attachment;
use App\Service\KeyGeneratorService;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package App\Entity\User
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 *
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 */
class User implements UserInterface
{
    CONST DEFAULT_IMAGE = 'assets/images/no_avatar.png';

    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $salt;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    protected $roles;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $company;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $companyPosition;

    /**
     * @var Attachment
     * @ORM\OneToOne(targetEntity="App\Entity\Attachment\Attachment")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    protected $image;

    /**
     * @param string $username
     * @param string $email
     * @param array $roles
     * @param string $firstName
     * @param string $lastName
     *
     * @return User
     */
    public static function create(
        string $username,
        string $email,
        array $roles,
        string $firstName = 'FirstName',
        string $lastName = 'LastName'
    ) {
        $user = new self();
        $user->setUsername($username)
            ->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setRoles($roles)
            ->setImage(NULL)
            ->setCompany("not set")
            ->setCompanyPosition("not set");

        return $user;
    }

    public function eraseCredentials(){}

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return User
     */
    public function setCompany(string $company): User
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        if(empty($this->salt)) {
            $salt = KeyGeneratorService::generateKey(16);
            $this->salt = $salt;
        }

        return $this->salt;
    }

    /**
     * @param string $salt
     * @return User
     */
    public function setSalt(string $salt): User
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . " ". $this->getLastName();
    }

    /**
     * @return string
     */
    public function getCompanyPosition(): string
    {
        return $this->companyPosition;
    }

    /**
     * @param string $companyPosition
     *
     * @return User
     */
    public function setCompanyPosition(string $companyPosition): User
    {
        $this->companyPosition = $companyPosition;

        return $this;
    }

    /**
     * @return Attachment|Null
     */
    public function getImage(): ?Attachment
    {
        return $this->image;
    }

    /**
     * @param Attachment $image
     * @return User
     */
    public function setImage(?Attachment $image): User
    {
        $this->image = $image;

        return $this;
    }

}

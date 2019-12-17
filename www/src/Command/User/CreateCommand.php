<?php

namespace App\Command\User;

use App\Entity\User\User;
use Doctrine\ORM\ORMException;
use App\Service\User\UserService;
use App\ObjectValue\User\RoleObjectValue;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateCommand
 * @package App\Command\User
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 1019-2020 <https://mirko.in.ua>
 */
class CreateCommand extends Command
{
    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * CreateCommand constructor.
     * @param UserService $userService
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(
        UserService $userService,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->userService = $userService;
        $this->passwordEncoder = $encoder;
        $this->validator = Validation::createValidator();

        parent::__construct();
    }

    /**
     * Configuration command
     */
    protected function configure()
    {
        $this
            ->setName("app:user:create")
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = $io = new SymfonyStyle($input, $output);

        $io->title("Create new User");

        $role = $io->choice(
            "Select Role User",
            RoleObjectValue::getAllValues()
        );

        $username = $this->askWithValidation(
            "Enter username",
            "",
            function (string $value) {
                $this->validateInput([
                    new NotBlank(),
                    new Length(['min' => 3, 'max' => 25])
                ], $value);

                $uniq = $this->userService->isUniqUsername($value);
                if(!$uniq) {
                    throw new \Exception("Username is exist <$value>");
                }

                return $value;
            });

        $firstName = $this->askWithValidation(
            "Enter FirstName", "",
            function (string $value) {
                return $this->validateInput([
                   new NotBlank()
                ], $value);
            });

        $lastName = $this->askWithValidation(
            "Enter LastName", "",
            function (string $value) {
                return $this->validateInput([
                    new NotBlank()
                ], $value);
            });

        $email = $this->askWithValidation(
            "Enter Email", "",
            function (string $value) {
                return $this->validateInput([
                    new NotBlank(),
                    new Email()
                ], $value);
            });

        $password = $this->askWithValidation(
            "Enter Password", "",
            function (string $value) {
                return $this->validateInput([
                    new NotBlank(),
                    new Length(["min" => 6, "max" => 25])
                ], $value);
            });

        $user = User::create(
            $username,
            $email,
            [RoleObjectValue::get($role)],
            $firstName,
            $lastName
        );

        $encodePassword = $this->passwordEncoder->encodePassword($user, $password);
        $user->setPassword($encodePassword);

        try {
            $this->userService->saveNewUser($user);
        } catch (OptimisticLockException | ORMException $e) {
            $io->error("Error save user. ".$e->getMessage());
        }

        $io->success([
            'Success user create',
            "id: {$user->getId()}",
            "Username: {$username}",
            "Password: {$password}",
        ]);
    }

    /**
     * Prompt the user for input.
     *
     * @param  string $question
     * @param  string $default
     * @param  callable|null $validator
     * @return string
     */
    public function askWithValidation($question, $default = null, $validator = null)
    {
        return $this->io->ask($question, $default, $validator);
    }

    /**
     * @param array $validation
     * @param $value
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function validateInput(array $validation, $value)
    {
        $validationResults = $this->validator->validate($value, $validation);

        if(0 !== $validationResults->count()) {
            foreach ($validationResults as $validationResult) {
                throw new \Exception($validationResult->getMessage());
            }
        }

        return $value;
    }
}
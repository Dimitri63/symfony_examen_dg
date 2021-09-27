<?php

namespace App\TwigExtension;

use App\Controller\ModeratorController;
use App\Repository\UserRepository;
use JetBrains\PhpStorm\NoReturn;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('moderatorExist', [$this, 'moderatorExist']),
            new TwigFunction('adminExist', [$this, 'adminExist'])
        ];
    }

    public function moderatorExist():bool
    {
        $users = $this->userRepository->findAll();
        $count = 0;
        foreach ($users as $user) {
            if (in_array( 'ROLE_MODERATOR',$user->getRoles())){
                $count++;
            }
        }
        if ($count>0) {
            return true;
        }
        return false;
    }

    public function adminExist():bool
    {
        $users = $this->userRepository->findAll();
        $count = 0;
        foreach ($users as $user) {
            if (in_array( 'ROLE_ADMIN',$user->getRoles())){
                $count++;
            }
        }
        if ($count>0) {
            return true;
        }
        return false;
    }
}
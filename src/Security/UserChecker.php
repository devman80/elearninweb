<?php

namespace App\Security;

use App\Entity\User as User;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if ($user->isDeleted()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException('Compte fermé, veuillez contacter  l\'Administrateur.');
        }
        
         if ($user->isExpired()) {
            throw new CustomUserMessageAccountStatusException('Compte innactif, veuillez effectuer le depôt de dosseir afin de vous connecter ');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

//        // Message d'erreur si compte non actif
//        if ($user->isExpired()) {
//            throw new CustomUserMessageAccountStatusException('Compte invalide, veuillez effectuer le depôt de dosseir afin de vous connecter ');
//        }
    }
}
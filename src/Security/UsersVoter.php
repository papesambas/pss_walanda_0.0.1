<?php

namespace App\Security;

use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UsersVoter extends Voter
{
    // Les actions que ce voter peut gérer
    public const VIEW = 'VIEW_USERS';
    public const EDIT = 'EDIT_USERS';

    protected function supports(string $attribute, $subject): bool
    {
        // Ce voter s'applique uniquement aux actions définies et à l'entité Users
        return in_array($attribute, [self::VIEW, self::EDIT]) && $subject instanceof Users;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Si l'utilisateur n'est pas connecté ou ne correspond pas à un UserInterface, accès refusé
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Exemple de logique pour chaque permission
        switch ($attribute) {
            case self::VIEW:
                // Autorise si l'utilisateur connecté a le rôle ROLE_ADMIN
                return in_array('ROLE_ADMIN', $user->getRoles(), true);

            case self::EDIT:
                // Par exemple, autorise l'édition uniquement si l'utilisateur est administrateur
                return in_array('ROLE_ADMIN', $user->getRoles(), true);

            default:
                return false;
        }
    }
}

<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Noms;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class nomsEntityListener
{
    private $security;
    private $slugger;
    private $tokenStorage;

    public function __construct(Security $security, SluggerInterface $slugger, TokenStorageInterface $tokenStorage)
    {
        $this->security = $security;
        $this->slugger = $slugger;
        $this->tokenStorage = $tokenStorage;
    }

    public function prePersist(Noms $nom, LifecycleEventArgs $arg): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        $nom->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($nom));

        if ($user) {
            $nom->setCreatedBy($user);
        }
    }

    public function preUpdate(Noms $nom, LifecycleEventArgs $arg): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        $nom->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($nom));

        if ($user) {
            $nom->setUpdatedBy($user);
        }
    }

    private function getClassesSlug(Noms $nom): string
    {
        $slug = mb_strtolower($nom->getDesignation() . '' . $nom->getId() , 'UTF-8');
        return $this->slugger->slug($slug)->toString();
    }
}

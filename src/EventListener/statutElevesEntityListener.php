<?php

namespace App\EventListener;

use LogicException;
use App\Entity\StatutEleves;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class statutElevesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(StatutEleves $statut, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $statut
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($statut));
        }else{
            $statut
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($statut));
        }
    }

    public function preUpdate(StatutEleves $statut, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $statut
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($statut));
        }else{
            $statut
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($statut));
        }
    }


    private function getClassesSlug(StatutEleves $statut): string
    {
        $slug = mb_strtolower($statut->getDesignation() . '-' . $statut->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}

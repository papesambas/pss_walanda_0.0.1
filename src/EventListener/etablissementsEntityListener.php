<?php

namespace App\EventListener;

use App\Entity\Etablissements;
use LogicException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class etablissementsEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Etablissements $etablissements, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $etablissements
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($etablissements));
        }else{
            $etablissements
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($etablissements));
        }
    }

    public function preUpdate(Etablissements $etablissements, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $etablissements
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($etablissements));
        }else{
            $etablissements
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($etablissements));
        }
    }


    private function getClassesSlug(Etablissements $etablissements): string
    {
        $slug = mb_strtolower($etablissements->getDesignation() . '-' . $etablissements->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}

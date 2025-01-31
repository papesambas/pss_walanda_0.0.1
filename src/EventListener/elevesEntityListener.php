<?php

namespace App\EventListener;

use App\Entity\Eleves;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class elevesEntityListener
{
    private $security;
    private $slugger;

    public function __construct(Security $security, SluggerInterface $slugger)
    {
        $this->security = $security;
        $this->slugger = $slugger;
    }

    public function prePersist(Eleves $eleves, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        $currentTime = new \DateTimeImmutable('now');
        
        // Ajout de la date de création et du slug
        $eleves->setCreatedAt($currentTime)
            ->setSlug($this->getClassesSlug($eleves));

        if ($user) {
            $eleves->setCreatedBy($user);
        }

        // Vérifier si le matricule est vide, sinon générer
        if (null === $eleves->getMatricule()) {
            $eleves->setMatricule($this->generateMatricule($eleves));
        }
    }

    public function preUpdate(Eleves $eleves, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        $currentTime = new \DateTimeImmutable('now');
        
        // Mise à jour de la date et du slug
        $eleves->setUpdatedAt($currentTime)
            ->setSlug($this->getClassesSlug($eleves));

        if ($user) {
            $eleves->setUpdatedBy($user);
        }

        // Vérifier si le matricule est vide, sinon générer
        if (null === $eleves->getMatricule()) {
            $eleves->setMatricule($this->generateMatricule($eleves));
        }
    }

    private function getClassesSlug(Eleves $eleves): string
    {
        $slug = mb_strtolower($eleves->getNom() . '-' . $eleves->getPrenom() . '-' . time(), 'UTF-8');
        return $this->slugger->slug($slug);
    }

    private function generateMatricule(Eleves $eleve): string
    {
        // Récupérer l'année actuelle
        $currentYear = (new \DateTimeImmutable())->format('Y');

        // Récupérer les initiales (nom et prénom)
        $initials = strtoupper(substr($eleve->getPrenom(), 0, 1) . substr($eleve->getNom(), 0, 1));

        // Ajouter l'identifiant pour l'unicité (en utilisant l'ID de l'entité ou un identifiant unique)
        $id = $eleve->getId() ?? uniqid();

        // Calculer la longueur de la chaîne aléatoire nécessaire pour atteindre 20 caractères
        $remainingLength = 23 - strlen($currentYear) - strlen($initials) - strlen($id);

        // Générer une chaîne aléatoire pour compléter à 20 caractères
        $randomString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, max(0, $remainingLength));

        // Combiner les parties pour former le matricule
        $matricule = $currentYear .'-'. $initials . $id.'-'. $randomString;

        // S'assurer que le matricule fait exactement 20 caractères
        return substr($matricule, 0, 20);
    }
}

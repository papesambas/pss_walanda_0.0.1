<?php

namespace App\Entity;

use App\Repository\DepartsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartsRepository::class)]
class Departs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $motif = null;

    #[ORM\Column(length: 255)]
    private ?string $ecoleDestination = null;

    #[ORM\ManyToOne(inversedBy: 'departs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etablissements $ecoleDepart = null;

    #[ORM\ManyToOne(inversedBy: 'departs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?eleves $eleve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getEcoleDestination(): ?string
    {
        return $this->ecoleDestination;
    }

    public function setEcoleDestination(string $ecoleDestination): static
    {
        $this->ecoleDestination = $ecoleDestination;

        return $this;
    }

    public function getEcoleDepart(): ?Etablissements
    {
        return $this->ecoleDepart;
    }

    public function setEcoleDepart(?Etablissements $ecoleDepart): static
    {
        $this->ecoleDepart = $ecoleDepart;

        return $this;
    }

    public function getEleve(): ?eleves
    {
        return $this->eleve;
    }

    public function setEleve(?eleves $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }
}

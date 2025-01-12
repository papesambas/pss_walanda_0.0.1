<?php

namespace App\Entity;

use App\Repository\AnneeScolairesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnneeScolairesRepository::class)]
class AnneeScolaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 11, unique:true)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: '/^\d{4}-\d{4}$/',
        message: "Le format de la désignation doit être 'YYYY-YYYY'."
    )]
    private ?string $designation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function __toString(): string
    {
        return $this->designation ?? '';
    }
}

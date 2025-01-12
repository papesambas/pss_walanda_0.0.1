<?php

namespace App\Entity;

use App\Repository\TelephonesRepository;
use Doctrine\ORM\Mapping as ORM;
use symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TelephonesRepository::class)]
class Telephones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 23, nullable: true, unique:true)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\(\d{3}\) \d{2} \d{2} \d{2} \d{2}$/",
        message: "Le numéro de téléphone doit être au format (xxx) xx xx xx xx"
    )]
    private ?string $malitel = null;

    #[ORM\Column(length: 23, nullable: true, unique:true)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\(\d{3}\) \d{2} \d{2} \d{2} \d{2}$/",
        message: "Le numéro de téléphone doit être au format (xxx) xx xx xx xx"
    )]
    private ?string $orange = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMalitel(): ?string
    {
        return $this->malitel;
    }

    public function setMalitel(?string $malitel): static
    {
        $this->malitel = $malitel;

        return $this;
    }

    public function getOrange(): ?string
    {
        return $this->orange;
    }

    public function setOrange(?string $orange): static
    {
        $this->orange = $orange;

        return $this;
    }
}

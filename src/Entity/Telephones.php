<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\TelephonesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TelephonesRepository::class)]
class Telephones
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 23, nullable: true, unique: true)]
    #[Assert\Regex(
        pattern: "/^\(\d{3}\) \d{2} \d{2} \d{2} \d{2}$/",
        message: "Le numéro de téléphone doit être au format (xxx) xx xx xx xx"
    )]
    private ?string $malitel = null;

    #[ORM\Column(length: 23, nullable: true, unique: true)]
    #[Assert\Regex(
        pattern: "/^\(\d{3}\) \d{2} \d{2} \d{2} \d{2}$/",
        message: "Le numéro de téléphone doit être au format (xxx) xx xx xx xx"
    )]
    private ?string $orange = null;

    #[ORM\OneToOne(mappedBy: 'telephone1', cascade: ['persist', 'remove'])]
    private ?Peres $pereTelephone1 = null;

    #[ORM\OneToOne(mappedBy: 'telephone2', cascade: ['persist', 'remove'])]
    private ?Peres $peretelephone2 = null;

    #[ORM\OneToOne(mappedBy: 'telephone1', cascade: ['persist', 'remove'])]
    private ?Meres $mereTelephone1 = null;

    #[ORM\OneToOne(mappedBy: 'telephone2', cascade: ['persist', 'remove'])]
    private ?Meres $mereTelephone2 = null;

    public function __toString(): string
    {
        return $this->malitel ?? $this->orange ?? "Aucun numéro";
    }

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

    public function getPereTelephone1(): ?Peres
    {
        return $this->pereTelephone1;
    }

    public function setPereTelephone1(Peres $pereTelephone1): static
    {
        // set the owning side of the relation if necessary
        if ($pereTelephone1->getTelephone1() !== $this) {
            $pereTelephone1->setTelephone1($this);
        }

        $this->pereTelephone1 = $pereTelephone1;

        return $this;
    }

    public function getPeretelephone2(): ?Peres
    {
        return $this->peretelephone2;
    }

    public function setPeretelephone2(?Peres $peretelephone2): static
    {
        // unset the owning side of the relation if necessary
        if ($peretelephone2 === null && $this->peretelephone2 !== null) {
            $this->peretelephone2->setTelephone2(null);
        }

        // set the owning side of the relation if necessary
        if ($peretelephone2 !== null && $peretelephone2->getTelephone2() !== $this) {
            $peretelephone2->setTelephone2($this);
        }

        $this->peretelephone2 = $peretelephone2;

        return $this;
    }

    public function getMereTelephone1(): ?Meres
    {
        return $this->mereTelephone1;
    }

    public function setMereTelephone1(Meres $mereTelephone1): static
    {
        // set the owning side of the relation if necessary
        if ($mereTelephone1->getTelephone1() !== $this) {
            $mereTelephone1->setTelephone1($this);
        }

        $this->mereTelephone1 = $mereTelephone1;

        return $this;
    }

    public function getMereTelephone2(): ?Meres
    {
        return $this->mereTelephone2;
    }

    public function setMereTelephone2(?Meres $mereTelephone2): static
    {
        // unset the owning side of the relation if necessary
        if ($mereTelephone2 === null && $this->mereTelephone2 !== null) {
            $this->mereTelephone2->setTelephone2(null);
        }

        // set the owning side of the relation if necessary
        if ($mereTelephone2 !== null && $mereTelephone2->getTelephone2() !== $this) {
            $mereTelephone2->setTelephone2($this);
        }

        $this->mereTelephone2 = $mereTelephone2;

        return $this;
    }
}

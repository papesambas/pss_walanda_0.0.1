<?php

namespace App\Entity;

use App\Entity\Etablissements;
use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Repository\EnseignementsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EnseignementsRepository::class)]
#[ORM\Table(
    name: "Enseignements",
    indexes: [
        new ORM\Index(name: "idx_enseignements_designation", columns: ["designation"]),
        new ORM\Index(name: "idx_enseignements_disponibilite", columns: ["disponibilite"])
    ],
    options: ["CHECK" => "disponibilite >= capacite - effectif"]
)]

class Enseignements
{
    public const MAX_DESIGNATION_LENGTH = 130;

    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: self::MAX_DESIGNATION_LENGTH)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Length(
        max: self::MAX_DESIGNATION_LENGTH,
        maxMessage: "La désignation ne peut pas dépasser {{ limit }} caractères."
    )]    private ?string $designation = null;

    /**
     * @var Collection<int, Etablissements>
     */
    #[ORM\OneToMany(targetEntity: Etablissements::class, mappedBy: 'enseignement', cascade: ['persist', 'remove'])]
    private Collection $etablissements;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $capacite = 0;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $effectif = 0;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->designation ?? "Type d'enseignement sans désignation";
    }

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

    /**
     * @return Collection<int, Etablissements>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissements $etablissement): static
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->setEnseignement($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissements $etablissement): static
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getEnseignement() === $this) {
                $etablissement->setEnseignement(null);
            }
        }

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(?int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(?int $effectif): static
    {
        $this->effectif = $effectif;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CyclesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CyclesRepository::class)]
#[ORM\Table(
    name: "cycles",
    indexes: [
        new ORM\Index(name: "idx_cycles_designation", columns: ["designation"]),
        new ORM\Index(name: "idx_cycles_etablissement", columns: ["etablissement_id"]),
        new ORM\Index(name: "idx_cycles_disponibilite", columns: ["disponibilite"])
    ],
    options: ["CHECK" => "disponibilite >= capacite - effectif"]
)]

class Cycles
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
    )]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'cycles', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etablissements $etablissement = null;

    /**
     * @var Collection<int, Niveaux>
     */
    #[ORM\OneToMany(targetEntity: Niveaux::class, mappedBy: 'cycle', cascade: ['persist', 'remove'])]
    private Collection $niveauxes;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $capacite = 0;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $effectif = 0;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $disponibilite = 0;

    public function __construct()
    {
        $this->niveauxes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->designation ?? 'Cycle sans désignation';
    }

    /**
     * Vérifie que la disponibilité est correcte.
     */
    #[Assert\Callback]
    public function validateDisponibilite(ExecutionContextInterface $context): void
    {
        if ($this->disponibilite !== max(0, $this->capacite - $this->effectif)) {
            $context->buildViolation("La disponibilité doit être égale à la capacité moins l'effectif.")
                ->atPath('disponibilite')
                ->addViolation();
        }
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

    public function getEtablissement(): ?Etablissements
    {
        return $this->etablissement;
    }

    public function setEtablissement(?Etablissements $etablissement): static
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * @return Collection<int, Niveaux>
     */
    public function getNiveauxes(): Collection
    {
        return $this->niveauxes;
    }

    public function addNiveaux(Niveaux $niveaux): static
    {
        if (!$this->niveauxes->contains($niveaux)) {
            $this->niveauxes->add($niveaux);
            $niveaux->setCycle($this);
        }

        return $this;
    }

    public function removeNiveaux(Niveaux $niveaux): static
    {
        if ($this->niveauxes->removeElement($niveaux)) {
            // set the owning side to null (unless already changed)
            if ($niveaux->getCycle() === $this) {
                $niveaux->setCycle(null);
            }
        }

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;
        $this->updateDisponibilite();

        return $this;
    }

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): static
    {
        $this->effectif = $effectif;
        $this->updateDisponibilite();

        return $this;

    }

    public function getDisponibilite(): ?int
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(int $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    private function updateDisponibilite(): void
    {
        $nouvelleDisponibilite = max(0, $this->capacite - $this->effectif);
        if ($this->disponibilite !== $nouvelleDisponibilite) {
            $this->disponibilite = $nouvelleDisponibilite;
        }
    }
}

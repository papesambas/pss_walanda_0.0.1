<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\NiveauxRepository;
use App\Entity\Trait\EntityTrackingTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: NiveauxRepository::class)]
#[ORM\Table(
    name: "niveaux",
    indexes: [
        new ORM\Index(name: "idx_niveaux_designation", columns: ["designation"]),
        new ORM\Index(name: "idx_niveaux_cycle", columns: ["cycle_id"]),
        new ORM\Index(name: "idx_niveaux_disponibilite", columns: ["disponibilite"])
    ],
    options: ["CHECK" => "disponibilite >= capacite - effectif"]
)]
class Niveaux
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

    #[ORM\ManyToOne(inversedBy: 'niveauxes', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cycles $cycle = null;

    /**
     * @var Collection<int, Classes>
     */
    #[ORM\OneToMany(targetEntity: Classes::class, mappedBy: 'niveau', cascade: ['persist', 'remove'])]
    private Collection $classes;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private int $capacite = 0;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private int $effectif = 0;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private int $disponibilite = 0;

    /**
     * @var Collection<int, Scolarites1>
     */
    #[ORM\OneToMany(targetEntity: Scolarites1::class, mappedBy: 'niveau', cascade : ['persist'])]
    private Collection $scolarites1s;

    /**
     * @var Collection<int, Scolarites2>
     */
    #[ORM\OneToMany(targetEntity: Scolarites2::class, mappedBy: 'niveau', cascade : ['persist'])]
    private Collection $scolarites2s;

    /**
     * @var Collection<int, StatutEleves>
     */
    #[ORM\ManyToMany(targetEntity: StatutEleves::class, mappedBy: 'niveau')]
    private Collection $statutEleves;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->scolarites1s = new ArrayCollection();
        $this->scolarites2s = new ArrayCollection();
        $this->statutEleves = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->designation ?? 'Niveau sans désignation';
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

    // --- Getters et Setters ---

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

    public function getCycle(): ?Cycles
    {
        return $this->cycle;
    }

    public function setCycle(?Cycles $cycle): static
    {
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * @return Collection<int, Classes>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classes $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->setNiveau($this);
        }

        return $this;
    }

    public function removeClass(Classes $class): static
    {
        if ($this->classes->removeElement($class)) {
            if ($class->getNiveau() === $this) {
                $class->setNiveau(null);
            }
        }

        return $this;
    }

    public function getCapacite(): int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;
        $this->updateDisponibilite();

        return $this;
    }

    public function getEffectif(): int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): static
    {
        $this->effectif = $effectif;
        $this->updateDisponibilite();

        return $this;
    }

    public function getDisponibilite(): int
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

    /**
     * @return Collection<int, Scolarites1>
     */
    public function getScolarites1s(): Collection
    {
        return $this->scolarites1s;
    }

    public function addScolarites1(Scolarites1 $scolarites1): static
    {
        if (!$this->scolarites1s->contains($scolarites1)) {
            $this->scolarites1s->add($scolarites1);
            $scolarites1->setNiveau($this);
        }

        return $this;
    }

    public function removeScolarites1(Scolarites1 $scolarites1): static
    {
        if ($this->scolarites1s->removeElement($scolarites1)) {
            // set the owning side to null (unless already changed)
            if ($scolarites1->getNiveau() === $this) {
                $scolarites1->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Scolarites2>
     */
    public function getScolarites2s(): Collection
    {
        return $this->scolarites2s;
    }

    public function addScolarites2(Scolarites2 $scolarites2): static
    {
        if (!$this->scolarites2s->contains($scolarites2)) {
            $this->scolarites2s->add($scolarites2);
            $scolarites2->setNiveau($this);
        }

        return $this;
    }

    public function removeScolarites2(Scolarites2 $scolarites2): static
    {
        if ($this->scolarites2s->removeElement($scolarites2)) {
            // set the owning side to null (unless already changed)
            if ($scolarites2->getNiveau() === $this) {
                $scolarites2->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StatutEleves>
     */
    public function getStatutEleves(): Collection
    {
        return $this->statutEleves;
    }

    public function addStatutElefe(StatutEleves $statutElefe): static
    {
        if (!$this->statutEleves->contains($statutElefe)) {
            $this->statutEleves->add($statutElefe);
            $statutElefe->addNiveau($this);
        }

        return $this;
    }

    public function removeStatutElefe(StatutEleves $statutElefe): static
    {
        if ($this->statutEleves->removeElement($statutElefe)) {
            $statutElefe->removeNiveau($this);
        }

        return $this;
    }

}

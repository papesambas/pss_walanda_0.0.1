<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\ClassesRepository;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ClassesRepository::class)]
#[ORM\Table(name: "classes", indexes: [
    new ORM\Index(name: "idx_classes_designation", columns: ["designation"]),
    new ORM\Index(name: "idx_classes_niveau", columns: ["niveau_id"]),
    new ORM\Index(name: "idx_classes_disponibilite", columns: ["disponibilite"])],
    options: ["CHECK" => "disponibilite >= capacite - effectif"]
)]
class Classes
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
    #[Assert\Length(max: self::MAX_DESIGNATION_LENGTH, maxMessage: "La désignation ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'classes', fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveaux $niveau = null;

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
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'classe')]
    private Collection $eleves;

    public function __construct()
    {
        $this->capacite = 0;
        $this->effectif = 0;
        $this->disponibilite = 0;
        $this->eleves = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->designation ?? 'Classe sans désignation';
    }

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

    public function getNiveau(): ?Niveaux
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveaux $niveau): static
    {
        $this->niveau = $niveau;

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

private function updateDisponibilite(): void
{
    $nouvelleDisponibilite = max(0, $this->capacite - $this->effectif);
    if ($this->disponibilite !== $nouvelleDisponibilite) {
        $this->disponibilite = $nouvelleDisponibilite;
    }
}

/**
 * @return Collection<int, Eleves>
 */
public function getEleves(): Collection
{
    return $this->eleves;
}

public function addElefe(Eleves $elefe): static
{
    if (!$this->eleves->contains($elefe)) {
        $this->eleves->add($elefe);
        $elefe->setClasse($this);
    }

    return $this;
}

public function removeElefe(Eleves $elefe): static
{
    if ($this->eleves->removeElement($elefe)) {
        // set the owning side to null (unless already changed)
        if ($elefe->getClasse() === $this) {
            $elefe->setClasse(null);
        }
    }

    return $this;
}

}

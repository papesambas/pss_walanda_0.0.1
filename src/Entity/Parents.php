<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\ParentsRepository;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParentsRepository::class)]
#[ORM\Table(name: 'parents', uniqueConstraints: [new ORM\UniqueConstraint(name: 'UNIQ_PERE_MERE', columns: ['pere_id', 'mere_id'])])]
class Parents
{
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'parents')]
    #[ORM\JoinColumn(nullable: false)] // PERE est obligatoire
    #[Assert\NotNull(message: "Le père est obligatoire.")]
    private ?Peres $pere = null;

    #[ORM\ManyToOne(inversedBy: 'parents')]
    #[ORM\JoinColumn(nullable: false)] // MERE est obligatoire
    #[Assert\NotNull(message: "La mère est obligatoire.")]
    private ?Meres $mere = null;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'parent', cascade: ['persist'])]
    private Collection $eleves;

    public function __construct(?Peres $pere = null, ?Meres $mere = null)
    {
        if ($pere && $mere) {
            $this->pere = $pere;
            $this->mere = $mere;
        }
        $this->eleves = new ArrayCollection();
    }
    

    public function __toString(): string
    {
        return "{$this->mere} et {$this->pere}";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPere(): ?Peres
    {
        return $this->pere;
    }

    public function setPere(?Peres $pere): static
    {
        /*if (!$pere || !$this->mere) {
            throw new \InvalidArgumentException("Un parent doit avoir un père et une mère.");
        }*/
        $this->pere = $pere;
        return $this;
    }

    public function getMere(): ?Meres
    {
        return $this->mere;
    }

    public function setMere(?Meres $mere): static
    {
        /*if (!$mere || !$this->pere) {
            throw new \InvalidArgumentException("Un parent doit avoir un père et une mère.");
        }*/
        $this->mere = $mere;
        return $this;
    }

    /**
     * @return Collection<int, Eleves>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addEleve(Eleves $eleve): static
    {
        if (!$this->eleves->contains($eleve)) {
            $this->eleves->add($eleve);
            $eleve->setParent($this);
        }

        return $this;
    }

    public function removeEleve(Eleves $eleve): static
    {
        if ($this->eleves->removeElement($eleve)) {
            if ($eleve->getParent() === $this) {
                $eleve->setParent(null);
            }
        }

        return $this;
    }

    public function equals(Parents $other): bool
    {
        return $this->pere === $other->getPere() && $this->mere === $other->getMere();
    }
}

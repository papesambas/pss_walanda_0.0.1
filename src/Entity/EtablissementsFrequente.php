<?php

namespace App\Entity;

use App\Repository\EtablissementsFrequenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementsFrequenteRepository::class)]
class EtablissementsFrequente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    private ?string $designation = null;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'ecoleInscription')]
    private Collection $eleves;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'ecoleAnDernier')]
    private Collection $ElevesAnDernier;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->ElevesAnDernier = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->designation ?? 'Classe sans désignation';
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
            $elefe->setEcoleInscription($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getEcoleInscription() === $this) {
                $elefe->setEcoleInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Eleves>
     */
    public function getElevesAnDernier(): Collection
    {
        return $this->ElevesAnDernier;
    }

    public function addElevesAnDernier(Eleves $elevesAnDernier): static
    {
        if (!$this->ElevesAnDernier->contains($elevesAnDernier)) {
            $this->ElevesAnDernier->add($elevesAnDernier);
            $elevesAnDernier->setEcoleAnDernier($this);
        }

        return $this;
    }

    public function removeElevesAnDernier(Eleves $elevesAnDernier): static
    {
        if ($this->ElevesAnDernier->removeElement($elevesAnDernier)) {
            // set the owning side to null (unless already changed)
            if ($elevesAnDernier->getEcoleAnDernier() === $this) {
                $elevesAnDernier->setEcoleAnDernier(null);
            }
        }

        return $this;
    }

}

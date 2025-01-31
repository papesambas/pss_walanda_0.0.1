<?php

namespace App\Entity;

use App\Repository\LieuNaissancesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LieuNaissancesRepository::class)]
class LieuNaissances
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Length(max: 150, maxMessage: "La désignation ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'lieuNaissances')]
    #[ORM\JoinColumn(nullable: false, onDelete:'CASCADE')]
    private ?Communes $commune = null;

    /**
     * @var Collection<int, Eleves>
     */
    #[ORM\OneToMany(targetEntity: Eleves::class, mappedBy: 'lieuNaissance')]
    private Collection $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->designation ?? '';
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

    public function getCommune(): ?Communes
    {
        return $this->commune;
    }

    public function setCommune(?Communes $commune): static
    {
        $this->commune = $commune;

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
            $elefe->setLieuNaissance($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getLieuNaissance() === $this) {
                $elefe->setLieuNaissance(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\MeresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MeresRepository::class)]
#[ORM\Table(
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: "unique_nom_prenom_profession_telephone1", fields: ["nom", "prenom", "profession", "telephone1"]),
        new ORM\UniqueConstraint(name: "unique_nom_prenom_profession_nina", fields: ["nom", "prenom", "profession", "nina"]),
        new ORM\UniqueConstraint(name: "unique_nom_prenom_profession_telephone2", fields: ["nom", "prenom", "profession", "telephone2"])
    ]
)]
class Meres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'meres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    private ?Noms $nom = null;

    #[ORM\ManyToOne(inversedBy: 'meres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]

    private ?Prenoms $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'meres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    private ?Professions $profession = null;

    #[ORM\OneToOne(inversedBy: 'meres', cascade: ['persist', 'remove'])]
    #[Assert\Length(
        min: 15,
        max: 15,
        minMessage: "Le NINA doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le NINA ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^\d{15}$/",
        message: "Le NINA doit contenir exactement 15 chiffres."
    )]
    private ?Ninas $nina = null;

    #[ORM\OneToOne(inversedBy: 'mereTelephone1', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]    private ?Telephones $telephone1 = null;

    #[ORM\OneToOne(inversedBy: 'mereTelephone2', cascade: ['persist', 'remove'])]
    private ?Telephones $telephone2 = null;

    /**
     * @var Collection<int, Parents>
     */
    #[ORM\OneToMany(targetEntity: Parents::class, mappedBy: 'mere')]
    private Collection $parents;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
    }

    public function __toString(): string
    {
        return ($this->prenom ?? "") . ' ' . ($this->nom ?? "Pas de Mère désigné");
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?Noms
    {
        return $this->nom;
    }

    public function setNom(?Noms $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?Prenoms
    {
        return $this->prenom;
    }

    public function setPrenom(?Prenoms $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getProfession(): ?Professions
    {
        return $this->profession;
    }

    public function setProfession(?Professions $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getNina(): ?Ninas
    {
        return $this->nina;
    }

    public function setNina(?Ninas $nina): static
    {
        $this->nina = $nina;

        return $this;
    }

    public function getTelephone1(): ?Telephones
    {
        return $this->telephone1;
    }

    public function setTelephone1(Telephones $telephone1): static
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    public function getTelephone2(): ?Telephones
    {
        return $this->telephone2;
    }

    public function setTelephone2(?Telephones $telephone2): static
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * @return Collection<int, Parents>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Parents $parent): static
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
            $parent->setMere($this);
        }

        return $this;
    }

    public function removeParent(Parents $parent): static
    {
        if ($this->parents->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getMere() === $this) {
                $parent->setMere(null);
            }
        }

        return $this;
    }

}

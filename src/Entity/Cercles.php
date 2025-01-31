<?php
namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\CerclesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CerclesRepository::class)]
class Cercles
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, unique:true)]
    #[Assert\NotBlank(message: "La désignation ne peut pas être vide.")]
    #[Assert\Length(max: 150, maxMessage: "La désignation ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $designation = null;

    /**
     * @var Collection<int, Communes>
     */
    #[ORM\OneToMany(targetEntity: Communes::class, mappedBy: 'cercle', cascade: ['persist', 'remove'])]
    private Collection $communes;

    #[ORM\ManyToOne(inversedBy: 'cercles')]
    #[ORM\JoinColumn(nullable: false, onDelete:'CASCADE')]
    private ?Regions $region = null;

    public function __construct()
    {
        $this->communes = new ArrayCollection();
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
     * @return Collection<int, Communes>
     */
    public function getCommunes(): Collection
    {
        return $this->communes;
    }

    public function addCommune(Communes $commune): static
    {
        if (!$this->communes->contains($commune)) {
            $this->communes->add($commune);
            $commune->setCercle($this);
        }

        return $this;
    }

    public function removeCommune(Communes $commune): static
    {
        if ($this->communes->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getCercle() === $this) {
                $commune->setCercle(null);
            }
        }

        return $this;
    }

    public function getRegion(): ?Regions
    {
        return $this->region;
    }

    public function setRegion(?Regions $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function __toString(): string
    {
        return $this->designation ?? '';
    }
}

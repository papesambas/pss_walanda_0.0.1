<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\ElevesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ElevesRepository::class)]
#[ORM\Index(name: 'idx_eleve_nom', columns: ['nom_id'])]
#[ORM\Index(name: 'idx_eleve_prenom', columns: ['prenom_id'])]
#[ORM\Index(name: 'idx_eleve_classe', columns: ['classe_id'])]
#[ORM\Index(name: 'idx_eleve_date_naissance', columns: ['date_naissance'])]
#[Vich\Uploadable]
class Eleves
{
    use CreatedAtTrait;
    use SlugTrait;
    use EntityTrackingTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Noms $nom = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prenoms $prenom = null;

    #[ORM\Column(length: 8)]
    #[Assert\Choice(choices: ['M', 'F'], message: 'Le sexe doit être "M" ou "F".')]
    private ?string $sexe =  "M";

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\Date]
    #[Assert\LessThan(value: "today - 4 years", message: "La date de naissance doit être au moins de 4 ans.")]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LieuNaissances $lieuNaissance = null;

    #[ORM\Column(length: 25)]
    #[Assert\NotBlank(message: 'Le numéro d\'acte est obligatoire.')]
    private ?string $numActe = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\Date]
    private ?\DateTimeImmutable $dateActe = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etablissements $etablissement = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\Date]
    #[Assert\LessThan("today", message: "La date de naissance ne peut pas être dans le futur.")]
    private ?\DateTimeImmutable $dateRecrutement = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\Date]
    private ?\DateTimeImmutable $dateInscription = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtablissementsFrequente $ecoleInscription = null;

    #[ORM\ManyToOne(inversedBy: 'ElevesAnDernier')]
    private ?EtablissementsFrequente $ecoleAnDernier = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Classes $classe = null;

    #[ORM\Column(length: 25, unique: true)]
    private ?string $matricule = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parents $parent = null;

    #[ORM\Column]
    private ?bool $isAdmin = true;

    #[ORM\Column]
    private ?bool $isAllowed = true;

    #[ORM\Column]
    private ?bool $isActif = true;

    #[ORM\Column]
    private ?bool $isHandicap = false;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $natureHandicape = null;

    #[ORM\Column(length: 10)]
    private ?string $statutFinance = "Privé(e)";

    #[ORM\OneToOne(inversedBy: 'eleves', cascade: ['persist', 'remove'])]
    #[Assert\Valid]
    private ?Users $user = null;

    /**
     * @var Collection<int, DossierEleves>
     */
    #[ORM\OneToMany(targetEntity: DossierEleves::class, mappedBy: 'eleve', cascade: ['persist', 'remove'])]
    private Collection $dossierEleves;

    /**
     * @var Collection<int, Departs>
     */
    #[ORM\OneToMany(targetEntity: Departs::class, mappedBy: 'eleve')]
    private Collection $departs;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'eleves_images', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?StatutEleves $statutEleve = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Scolarites1 $scolarite1 = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Scolarites2 $scolarite2 = null;

    public function __construct()
    {
        // Si des valeurs par défaut sont nécessaires, vous pouvez les définir ici
        $this->dossierEleves = new ArrayCollection();
        $this->departs = new ArrayCollection();
    }

    public function __toString(): string
    {
        return ($this->prenom ?? "") . ' ' . ($this->nom ?? "Pas d'élève désigné");
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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeImmutable
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeImmutable $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?LieuNaissances
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?LieuNaissances $lieuNaissance): static
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getNumActe(): ?string
    {
        return $this->numActe;
    }

    public function setNumActe(string $numActe): static
    {
        $this->numActe = $numActe;

        return $this;
    }

    public function getDateActe(): ?\DateTimeImmutable
    {
        return $this->dateActe;
    }

    public function setDateActe(\DateTimeImmutable $dateActe): static
    {
        $this->dateActe = $dateActe;

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

    public function getDateRecrutement(): ?\DateTimeImmutable
    {
        return $this->dateRecrutement;
    }

    public function setDateRecrutement(\DateTimeImmutable $dateRecrutement): static
    {
        $this->dateRecrutement = $dateRecrutement;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeImmutable
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeImmutable $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getEcoleInscription(): ?EtablissementsFrequente
    {
        return $this->ecoleInscription;
    }

    public function setEcoleInscription(?EtablissementsFrequente $ecoleInscription): static
    {
        $this->ecoleInscription = $ecoleInscription;

        return $this;
    }

    public function getEcoleAnDernier(): ?EtablissementsFrequente
    {
        return $this->ecoleAnDernier;
    }

    public function setEcoleAnDernier(?EtablissementsFrequente $ecoleAnDernier): static
    {
        $this->ecoleAnDernier = $ecoleAnDernier;

        return $this;
    }

    public function getClasse(): ?Classes
    {
        return $this->classe;
    }

    public function setClasse(?Classes $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getParent(): ?Parents
    {
        return $this->parent;
    }

    public function setParent(?Parents $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function isAllowed(): ?bool
    {
        return $this->isAllowed;
    }

    public function setAllowed(bool $isAllowed): static
    {
        $this->isAllowed = $isAllowed;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->isActif;
    }

    public function setActif(bool $isActif): static
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function isHandicap(): ?bool
    {
        return $this->isHandicap;
    }

    public function setHandicap(bool $isHandicap): static
    {
        $this->isHandicap = $isHandicap;

        return $this;
    }

    public function getNatureHandicape(): ?string
    {
        return $this->natureHandicape;
    }

    public function setNatureHandicape(?string $natureHandicape): static
    {
        $this->natureHandicape = $natureHandicape;

        return $this;
    }

    public function getStatutFinance(): ?string
    {
        return $this->statutFinance;
    }

    public function setStatutFinance(string $statutFinance): static
    {
        $this->statutFinance = $statutFinance;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, DossierEleves>
     */
    public function getDossierEleves(): Collection
    {
        return $this->dossierEleves;
    }

    public function addDossierElefe(DossierEleves $dossierElefe): static
    {
        if (!$this->dossierEleves->contains($dossierElefe)) {
            $this->dossierEleves->add($dossierElefe);
            $dossierElefe->setEleve($this);
        }

        return $this;
    }

    public function removeDossierElefe(DossierEleves $dossierElefe): static
    {
        if ($this->dossierEleves->removeElement($dossierElefe)) {
            // set the owning side to null (unless already changed)
            if ($dossierElefe->getEleve() === $this) {
                $dossierElefe->setEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Departs>
     */
    public function getDeparts(): Collection
    {
        return $this->departs;
    }

    public function addDepart(Departs $depart): static
    {
        if (!$this->departs->contains($depart)) {
            $this->departs->add($depart);
            $depart->setEleve($this);
        }

        return $this;
    }

    public function removeDepart(Departs $depart): static
    {
        if ($this->departs->removeElement($depart)) {
            // set the owning side to null (unless already changed)
            if ($depart->getEleve() === $this) {
                $depart->setEleve(null);
            }
        }

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getStatutEleve(): ?StatutEleves
    {
        return $this->statutEleve;
    }

    public function setStatutEleve(?StatutEleves $statutEleve): static
    {
        $this->statutEleve = $statutEleve;

        return $this;
    }

    public function getScolarite1(): ?Scolarites1
    {
        return $this->scolarite1;
    }

    public function setScolarite1(?Scolarites1 $scolarite1): static
    {
        $this->scolarite1 = $scolarite1;

        return $this;
    }

    public function getScolarite2(): ?Scolarites2
    {
        return $this->scolarite2;
    }

    public function setScolarite2(?Scolarites2 $scolarite2): static
    {
        $this->scolarite2 = $scolarite2;

        return $this;
    }
}

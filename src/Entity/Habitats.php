<?php

namespace App\Entity;

use App\Repository\HabitatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: HabitatsRepository::class)]
class Habitats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 150,
     * )
     */
    #[ORM\Column(type: 'string', length: 150)]
    private $libelle;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     * )
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $adresse;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 10,
     * )
     * @Assert\Regex("/^\d{2}(?:[-\s]\d{4})?$/")
     */
    #[ORM\Column(type: 'string', length: 10)]
    private $code_postal;

    /**
     * @Assert\NotBlank
     * @Assert\Length(  
     *      min = 1,
     *      max = 80,
     * )
     */
    #[ORM\Column(type: 'string', length: 80)]
    private $ville;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 80,
     * )
     */
    #[ORM\Column(type: 'string', length: 80)]
    private $pays;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     * )
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $description_title;

    /**
     * @Assert\Length(
     *      min = 1
     * )
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private $description;
    
    /**
     * @Assert\PositiveOrZero
     */
    #[ORM\Column(type: 'float')]
    private $prix;
    
    /**
     * @Assert\PositiveOrZero
     */
    #[ORM\Column(type: 'integer')]
    private $nombre_personnes_max;
    
    #[ORM\Column(type: 'json')]
    private $informations_supplementaires = [];

    #[ORM\Column(type: 'json', nullable: true)]
    private $images = [];

    #[ORM\Column(type: 'boolean')]
    private $statut;

    #[ORM\Column(type: 'boolean')]
    private $est_disponible;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'habitats')]
    private $proprietaire;

    #[ORM\OneToMany(mappedBy: 'habitat', targetEntity: Reservations::class)]
    private $Reservations;

    #[ORM\OneToMany(mappedBy: 'habitats', targetEntity: Activites::class)]
    private $Activites;

    #[ORM\ManyToMany(targetEntity: Equipements::class, inversedBy: 'habitats')]
    private $Equipements;

    #[ORM\ManyToOne(targetEntity: TypeHabitats::class, inversedBy: 'habitats')]
    private $TypeHabitat;

    #[ORM\ManyToMany(targetEntity: InformationsPratiques::class, inversedBy: 'habitats')]
    private $informations_pratiques;

    public function __construct()
    {
        $this->Reservations = new ArrayCollection();
        $this->Equipements = new ArrayCollection();
        $this->Activites = new ArrayCollection();
        $this->informations_pratiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getProprietaire(): ?Utilisateurs
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Utilisateurs $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function isEstDisponible(): ?bool
    {
        return $this->est_disponible;
    }

    public function setEstDisponible(bool $est_disponible): self
    {
        $this->est_disponible = $est_disponible;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservations(): Collection
    {
        return $this->Reservations;
    }

    /**
     * @return Collection<int, Equipements>
     */
    public function getEquipements(): Collection
    {
        return $this->Equipements;
    }

    public function addEquipement(Equipements $equipement): self
    {
        if (!$this->Equipements->contains($equipement)) {
            $this->Equipements[] = $equipement;
            $equipement->setHabitats($this);
        }

        return $this;
    }

    public function removeEquipement(Equipements $equipement): self
    {
        if ($this->Equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getHabitats() === $this) {
                $equipement->setHabitats(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Activites>
     */
    public function getActivites(): Collection
    {
        return $this->Activites;
    }

    public function addActivite(Activites $activite): self
    {
        if (!$this->Activites->contains($activite)) {
            $this->Activites[] = $activite;
            $activite->setHabitats($this);
        }

        return $this;
    }

    public function removeActivite(Activites $activite): self
    {
        if ($this->Activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getHabitats() === $this) {
                $activite->setHabitats(null);
            }
        }

        return $this;
    }

    public function getDescriptionTitle(): ?string
    {
        return $this->description_title;
    }

    public function setDescriptionTitle(string $description_title): self
    {
        $this->description_title = $description_title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInformationsSupplementaires(): ?array
    {
        return $this->informations_supplementaires;
    }

    public function setInformationsSupplementaires(array $informations_supplementaires): self
    {
        $this->informations_supplementaires = $informations_supplementaires;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }



    public function getNombrePersonnesMax(): ?int
    {
        return $this->nombre_personnes_max;
    }

    public function setNombrePersonnesMax(int $nombre_personnes_max): self
    {
        $this->nombre_personnes_max = $nombre_personnes_max;

        return $this;
    }

    public function getTypeHabitat(): ?TypeHabitats
    {
        return $this->TypeHabitat;
    }

    public function setTypeHabitat(?TypeHabitats $TypeHabitat): self
    {
        $this->TypeHabitat = $TypeHabitat;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return Collection<int, InformationsPratiques>
     */
    public function getInformationsPratiques(): Collection
    {
        return $this->informations_pratiques;
    }

    public function addInformationsPratique(InformationsPratiques $informationsPratique): self
    {
        if (!$this->informations_pratiques->contains($informationsPratique)) {
            $this->informations_pratiques[] = $informationsPratique;
        }

        return $this;
    }

    public function removeInformationsPratique(InformationsPratiques $informationsPratique): self
    {
        $this->informations_pratiques->removeElement($informationsPratique);

        return $this;
    }
}

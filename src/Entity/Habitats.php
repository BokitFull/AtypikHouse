<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\GetHabitatsController;
use App\Repository\HabitatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HabitatsRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'read:collection'
                ]
            ],
            'list_habitats' => [    
                'pagination_enabled'=>false,
                'method' => 'GET',
                'path' => 'get/habitats',
                'controller' => GetHabitatsController::class,
                'filters' => [],
                'openapi_context' => [
                    'summary' => 'Récupère une liste',
                    'parameters' => [
                        [
                            'in' => 'query',
                            'name' => 'id',
                            'schema' => [
                                'type' => 'integer'
                            ]
    
                        ]
                    ]
                ]
            ]
        ], 
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'comment:item'
                ]
            ],
        // 'list_habitats' => [    
        //     'method' => 'GET',
        //     'path' => 'get/habitats/{id_array}',
        //     'controller' => GetHabitatsController::class,
        //     'filters' => [],
        //     'openapi_context' => [
        //         'summary' => 'Récupère une liste',
        //         'parameters' => [
        //             [
        //                 'in' => 'query',
        //                 'name' => 'habitats',
        //                 'schema' => [
        //                     'type' => 'array'
        //                 ]

        //             ]
        //         ]
        //     ]
        ]
    // ],

)]
class Habitats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([ 'read:collection', 'comment:item', 'list_habitats'])]
    private $id;
    
    #[ORM\Column(type: 'string', length: 150)]
    private $libelle;

    #[ORM\Column(type: 'string', length: 100)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 10)]
    private $code_postal;

    #[ORM\Column(type: 'string', length: 80)]
    private $ville;

    #[ORM\Column(type: 'string', length: 80)]
    private $pays;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'habitats')]
    private $proprietaire;

    #[ORM\Column(type: 'boolean')]
    private $est_disponible;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'habitat', targetEntity: Reservations::class)]
    private $reservations;

    #[ORM\OneToMany(mappedBy: 'habitats', targetEntity: Activites::class)]
    private $activites;

    #[ORM\Column(type: 'json', nullable: true)]
    private $images = [];

    #[ORM\ManyToMany(targetEntity: Equipements::class, inversedBy: 'habitats')]
    private $equipements;

    #[ORM\Column(type: 'string', length: 255)]
    private $description_title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'habitats', targetEntity: InformationsPratiques::class)]
    private $informations_pratiques;

    #[ORM\Column(type: 'json')]
    private $informations_supplementaires = [];

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'integer')]
    private $nombre_personnes_max;

    #[ORM\ManyToOne(targetEntity: TypeHabitats::class, inversedBy: 'habitats')]
    private $TypeHabitat;

    #[ORM\Column(type: 'boolean')]
    private $statut;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->equipements = new ArrayCollection();
        $this->activites = new ArrayCollection();
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
        return $this->reservations;
    }

    // public function addReservation(Reservations $reservation): self
    // {
    // // 
    // //     if (!$this->Reservations->contains($reservation)) {
    // //         $this->Reservations[] = $reservation;
    // //         $reservation->setHabitat($this);
    // //     }

    //     // return $this;
    // }

    // public function removeReservation(Reservations $reservation): self
    // {
    //     // if ($this->Reservations->removeElement($reservation)) {
    //     //     // set the owning side to null (unless already changed)
    //     //     if ($reservation->getHabitat() === $this) {
    //     //         $reservation->setHabitat(null);
    //     //     }
    //     // }

    //     // return $this;
    // }

    /**
     * @return Collection<int, Equipements>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipements $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
            $equipement->addHabitat($this);
        }

        return $this;
    }   

    public function removeEquipement(Equipements $equipement): self
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getHabitats() === $this) {
                $equipement->removeHabitat($this);
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

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

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
            $informationsPratique->setHabitats($this);
        }

        return $this;
    }

    public function removeInformationsPratique(InformationsPratiques $informationsPratique): self
    {
        if ($this->informations_pratiques->removeElement($informationsPratique)) {
            // set the owning side to null (unless already changed)
            if ($informationsPratique->getHabitats() === $this) {
                $informationsPratique->setHabitats(null);
            }
        }

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
}

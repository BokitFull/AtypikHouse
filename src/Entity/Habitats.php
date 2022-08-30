<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\GetHabitatsController;
use App\Repository\HabitatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HabitatsRepository::class)]
#[ApiResource( 
    attributes: ["security" => "is_granted('ROLE_USER')"]
    // collectionOperations: [
    //     'get' => [
    //         'normalization_context' => [
    //             'groups' => 'read:collection'
    //             ]
    //         ],
    //         'list_habitats' => [
    //             'pagination_enabled'=>false,
    //             'method' => 'GET',
    //             'path' => 'get/habitats',
    //             'controller' => GetHabitatsController::class,
    //             'filters' => [],
    //             'openapi_context' => [
    //                 'summary' => 'Récupère une liste',
    //                 'parameters' => [
    //                     [
    //                         'in' => 'query',
    //                         'name' => 'id',
    //                         'schema' => [
    //                             'type' => 'integer'
    //                         ]

    //                     ]
    //                 ]
    //             ]
    //         ]
    //     ], 
    // itemOperations: [
    //     'get' => [
    //         'normalization_context' => [
    //             'groups' => 'comment:item'
    //             ]
    //         ],
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
        // ]
    // ],

)]
class Habitats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([ 'read:collection', 'comment:item', 'list_habitats'])]
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max = 150)
     */
    #[ORM\Column(type: 'string', length: 150)]
    private $titre;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'habitats')]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max = 100)
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $adresse;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^\d{2}(?:[-\s]\d{4})?$/")
     */
    #[ORM\Column(type: 'string', length: 2)]
    private $code_postal;

    #[ORM\Column(type: 'text')]
    private $description;

    /**
     * @Assert\PositiveOrZero
     */
    #[ORM\Column(type: 'integer')]
    private $nb_personnes;

    /**
     * @Assert\PositiveOrZero
     */
    #[ORM\Column(type: 'float')]
    private $prix;

    /**
     * @Assert\NotNull
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private $debut_disponibilite;

    /**
     * @Assert\NotNull
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private $fin_disponibilite;
    
    /**
     * @Assert\NotNull
     */
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;
    
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $deleted_at;

    /**
     * @Assert\NotNull
     */
    #[ORM\Column(type: 'boolean')]
    private $est_valide;

    #[ORM\ManyToOne(targetEntity: TypesHabitat::class, inversedBy: 'habitats')]
    private $type;

    #[ORM\OneToMany(mappedBy: 'habitat', targetEntity: Reservations::class)]
    private $reservations;

    #[ORM\ManyToMany(targetEntity: Prestations::class, inversedBy: 'habitats')]
    private $prestations;

    /**
     * @Assert\NotNull
     */
    #[ORM\Column(type: 'boolean')]
    private $est_actif;

    #[ORM\OneToMany(mappedBy: 'habitat', targetEntity: ImagesHabitat::class)]
    private $imagesHabitats;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'habitats')]
    private $ville;

    #[ORM\OneToMany(mappedBy: 'habitats', targetEntity: CaracteristiquesHabitat::class)]
    private Collection $caracteristiquesHabitat;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->prestations = new ArrayCollection();
        $this->imagesHabitats = new ArrayCollection();
        $this->caracteristiquesHabitat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateurs
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateurs $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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

    public function getNbPersonnes(): ?int
    {
        return $this->nb_personnes;
    }

    public function setNbPersonnes(int $nb_personnes): self
    {
        $this->nb_personnes = $nb_personnes;

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

    public function getDebutDisponibilite(): ?\DateTimeImmutable
    {
        return $this->debut_disponibilite;
    }

    public function setDebutDisponibilite(\DateTimeImmutable $debut_disponibilite): self
    {
        $this->debut_disponibilite = $debut_disponibilite;

        return $this;
    }

    public function getFinDisponibilite(): ?\DateTimeImmutable
    {
        return $this->fin_disponibilite;
    }

    public function setFinDisponibilite(\DateTimeImmutable $fin_disponibilite): self
    {
        $this->fin_disponibilite = $fin_disponibilite;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function isEstValide(): ?bool
    {
        return $this->est_valide;
    }

    public function setEstValide(bool $est_valide): self
    {
        $this->est_valide = $est_valide;

        return $this;
    }

    public function getType(): ?TypesHabitat
    {
        return $this->type;
    }

    public function setType(?TypesHabitat $type): self
    {
        $this->type = $type;

        return $this;
    }


    /**
     * @return Collection<int, Reservations>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setHabitat($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHabitat() === $this) {
                $reservation->setHabitat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prestations>
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestations $prestation): self
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations[] = $prestation;
        }

        return $this;
    }

    public function removePrestation(Prestations $prestation): self
    {
        $this->prestations->removeElement($prestation);

        return $this;
    }

    public function isEstActif(): ?bool
    {
        return $this->est_actif;
    }

    public function setEstActif(bool $est_actif): self
    {
        $this->est_actif = $est_actif;

        return $this;
    }

    /**
     * @return Collection<int, ImagesHabitat>
     */
    public function getImagesHabitats(): Collection
    {
        return $this->imagesHabitats;
    }

    public function addImagesHabitat(ImagesHabitat $imagesHabitat): self
    {
        if (!$this->imagesHabitats->contains($imagesHabitat)) {
            $this->imagesHabitats[] = $imagesHabitat;
            $imagesHabitat->setHabitat($this);
        }

        return $this;
    }

    public function removeImagesHabitat(ImagesHabitat $imagesHabitat): self
    {
        if ($this->imagesHabitats->removeElement($imagesHabitat)) {
            // set the owning side to null (unless already changed)
            if ($imagesHabitat->getHabitat() === $this) {
                $imagesHabitat->setHabitat(null);
            }
        }

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

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
     * @return Collection<int, CaracteristiquesHabitat>
     */
    public function getCaracteristiquesHabitat(): Collection
    {
        return $this->caracteristiquesHabitat;
    }

    public function addCaracteristiquesHabitat(CaracteristiquesHabitat $caracteristiquesHabitat): self
    {
        if (!$this->caracteristiquesHabitat->contains($caracteristiquesHabitat)) {
            $this->caracteristiquesHabitat->add($caracteristiquesHabitat);
            $caracteristiquesHabitat->setHabitats($this);
        }

        return $this;
    }

    public function removeCaracteristiquesHabitat(CaracteristiquesHabitat $caracteristiquesHabitat): self
    {
        if ($this->caracteristiquesHabitat->removeElement($caracteristiquesHabitat)) {
            // set the owning side to null (unless already changed)
            if ($caracteristiquesHabitat->getHabitats() === $this) {
                $caracteristiquesHabitat->setHabitats(null);
            }
        }

        return $this;
    }
}

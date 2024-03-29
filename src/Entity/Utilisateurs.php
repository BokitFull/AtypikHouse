<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

#[Gedmo\Loggable]
#[ORM\Entity(repositoryClass: UtilisateursRepository::class)]
#[ApiResource(
	itemOperations: [ 'get' ],
	collectionOperations: [ ]
)]
class Utilisateurs implements UserInterface, PasswordAuthenticatedUserInterface
{   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Length(
     *      max = 100,
     * )
     */
    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private $email;
    
    /**
     * @Assert\NotNull
     */
    #[Gedmo\Versioned]
    #[ORM\Column(type: 'json')]
    private $roles = [];

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 100,
     * )
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $password;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 50,
     * )
     */
    #[ORM\Column(type: 'string', length: 50)]
    private $nom;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 50,
     * )
     */
    #[ORM\Column(type: 'string', length: 50)]
    private $prenom;

    /**
     * @Assert\Length(
     *      max = 2,
     * )
     */
    #[ORM\Column(type: 'string', length: 2, nullable: true)]
    private $civilite;

    /**
     * @Assert\Length(
     *      max = 20,
     * )
     */
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $telephone;

    /**
     * @Assert\Length(
     *      max = 100,
     * )
     */
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $adresse;

    /**
     * @Assert\Length(
     *      max = 5,
     * )
     */
    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $code_postal;

    /**
     * @Assert\Length(
     *      max = 80,
     * )
     */
    #[ORM\Column(type: 'string', length: 80, nullable: true)]
    private $ville;

    /**
     * @Assert\Length(
     *      max = 80,
     * )
     */
    #[ORM\Column(type: 'string', length: 80, nullable: true)]
    private $pays;

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

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Habitats::class)]
    private $habitats;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Reservations::class)]
    private $reservations;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Commentaires::class)]
    private $commentaires;

    /**
     * @Assert\Length(
     *      max = 255,
     * )
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    public function __construct()
    {
        $this->habitats = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';
        
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(?string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

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

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection<int, Habitats>
     */
    public function getHabitats(): Collection
    {
        return $this->habitats;
    }

    public function addHabitat(Habitats $habitat): self
    {
        if (!$this->habitats->contains($habitat)) {
            $this->habitats[] = $habitat;
            $habitat->setUtilisateur($this);
        }

        return $this;
    }

    public function removeHabitat(Habitats $habitat): self
    {
        if ($this->habitats->removeElement($habitat)) {
            // set the owning side to null (unless already changed)
            if ($habitat->getUtilisateur() === $this) {
                $habitat->setUtilisateur(null);
            }
        }

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
            $reservation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUtilisateur() === $this) {
                $reservation->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}

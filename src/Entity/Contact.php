<?php

namespace App\Entity;
use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max = 100)
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max = 100)
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $prenom;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Length(max = 100)
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $Email;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'text')]
    private $message;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max = 20)
     */
    #[ORM\Column(type: 'string', length: 20)]
    private $telephone;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}

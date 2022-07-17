<?php

namespace App\Entity;

use App\Repository\PaymentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaymentsRepository::class)]
class Payments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\Regex("/^\d*$/")
     */
    #[ORM\Column(type: 'string', length: 16)]
    private $card_number;

    /**
     * @Assert\Regex("/^[0-3]*[0-9]{1}$/")
     */
    #[ORM\Column(type: 'string', length: 2)]
    private $month_validity;

    /**
     * @Assert\Regex("/^[0-9]{2}$/")
     */
    #[ORM\Column(type: 'string', length: 2)]
    private $year_validity;

    /**
     * @Assert\Regex("/^[0-9]{3}$/")
     */
    #[ORM\Column(type: 'string', length: 3)]
    private $cvc;

    #[ORM\OneToOne(targetEntity: Utilisateurs::class, cascade: ['persist', 'remove'])]
    private $utilisateur;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardNumber(): ?string
    {
        return $this->card_number;
    }

    public function setCardNumber(string $card_number): self
    {
        $this->card_number = $card_number;

        return $this;
    }

    public function getMonthValidity(): ?int
    {
        return $this->month_validity;
    }

    public function setMonthValidity(int $month_validity): self
    {
        $this->month_validity = $month_validity;

        return $this;
    }

    public function getYearValidity(): ?int
    {
        return $this->year_validity;
    }

    public function setYearValidity(int $year_validity): self
    {
        $this->year_validity = $year_validity;

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

    public function getCvc(): ?string
    {
        return $this->cvc;
    }

    public function setCvc(string $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }
}

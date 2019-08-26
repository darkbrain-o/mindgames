<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserBankRepository")
 */
class UserBank
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="bank", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nb_card;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_exp;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $cryptogram;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $city;


    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newbank = $user === null ? null : $this;
        if ($newbank !== $user->getbank()) {
            $user->setbank($newbank);
        }

        return $this;
    }

    public function getNbCard(): ?string
    {
        return $this->nb_card;
    }

    public function setNbCard(string $nb_card): self
    {
        $this->nb_card = $nb_card;

        return $this;
    }

    public function getDateExp(): ?\DateTimeInterface
    {
        return $this->date_exp;
    }

    public function setDateExp(\DateTimeInterface $date_exp): self
    {
        $this->date_exp = $date_exp;

        return $this;
    }

    public function getCryptogram(): ?string
    {
        return $this->cryptogram;
    }

    public function setCryptogram(string $cryptogram): self
    {
        $this->cryptogram = $cryptogram;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }



    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthday_date;
    }

    public function setBirthdayDate(\DateTimeInterface $birthday_date): self
    {
        $this->birthday_date = $birthday_date;

        return $this;
    }
}

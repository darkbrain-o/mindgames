<?php

namespace App\Entity;

use App\Validator\StrongString;
use App\Validator\StrongInteger;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @UniqueEntity("name")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Command", inversedBy="game")
     */
    private $command;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $retro_shape;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=120)
     * @StrongString(min = 3, max = 120, allowSpecialChars = false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @StrongInteger(min = 1, max = 100)
     */
    private $stock;

    /**
     * @ORM\Column(type="smallint")
     * @StrongInteger(min = 0, max = 1)
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     * @StrongInteger(min = 1, max = 1000, acceptFloat = true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="string", length=50)
     * @StrongString(min = 2, max = 50, allowSpecialChars = true)
     */
    private $platform;

    /**
     * @ORM\Column(type="integer")
     * @StrongInteger(min = 0, max = 21)
     */
    private $pegi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @Assert\Image()
     * @var File
     */
    private $pictureFile;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function setCommand(?Command $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getRetroShape(): ?int
    {
        return $this->retro_shape;
    }

    public function setRetroShape(?int $retro_shape): self
    {
        $this->retro_shape = $retro_shape;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getPegi(): ?int
    {
        return $this->pegi;
    }

    public function setPegi(int $pegi): self
    {
        $this->pegi = $pegi;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**

     * Get the value of pictureFile
     *
     * @return  File
     */ 
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * Set the value of pictureFile
     *
     * @param  File  $pictureFile
     *
     * @return  self
     */ 
    public function setPictureFile(File $pictureFile)
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }
}

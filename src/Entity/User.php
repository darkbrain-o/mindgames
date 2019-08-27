<?php

namespace App\Entity;


use App\Validator\StrongString;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\StrongPassword;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("bank")
 * @UniqueEntity("pseudo")
 * @UniqueEntity("mail")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserBank", inversedBy="user", cascade={"persist", "remove"})
     */
    private $bank;

    /**
     * @ORM\Column(type="string", length=30)
     * @StrongString(min = 4, max = 30, allowSpecialChars = true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Image(
     *     minWidth = 640,
     *     maxWidth = 1920,
     *     minHeight = 360,
     *     maxHeight = 1080
     * )
     */
    private $picture;

        /**
     * @Assert\Image()
     * @var File
     */
    private $pictureFile;


    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true)
     * @ORM\Column(type="string", length=100)
     * @StrongString(min = 5, max = 100, allowSpecialChars = true)
     */
    private $mail;//7,100,true

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @StrongPassword(min = 5, max = 30)
     */
    private $password;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Command", inversedBy="user")
     */
    private $command;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Command", mappedBy="user")
     */
    private $commands;

    /**
     * @ORM\Column(type="string")
     */
    private $role = '';
    

    public function __construct()
    {
        $this->commands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBank(): ?UserBank
    {
        return $this->bank;
    }

    public function setbank(?UserBank $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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

    /**
     * @see UserInterface
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    /**
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->setUser($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): self
    {
        if ($this->commands->contains($command)) {
            $this->commands->removeElement($command);
            // set the owning side to null (unless already changed)
            if ($command->getUser() === $this) {
                $command->setUser(null);
            }
        }

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->pseudo;
    }

    public function setUsername(?string $username): self
    {
        $this->pseudo = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = explode(',', $this->role);
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}

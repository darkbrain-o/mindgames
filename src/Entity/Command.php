<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandRepository")
 */
class Command
{

    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commands")
     */
    private $user_id;

    private $user_command;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="command")
     */
    private $game;

    /**
     * @ORM\Column(type="datetime")
     */
    private $command_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function __construct()
    {
        $this->game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user_id;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user_id;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
            $game->setCommand($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->game->contains($game)) {
            $this->game->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getCommand() === $this) {
                $game->setCommand(null);
            }
        }

        return $this;
    }

    public function getCommandDate(): ?\DateTimeInterface
    {
        return $this->command_date;
    }

    public function setCommandDate(\DateTimeInterface $command_date): self
    {
        $this->command_date = $command_date;

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

    /**
     * Get the value of user_command
     */ 
    public function getUserCommand()
    {
        return $this->user_command;
    }

    /**
     * Set the value of user_command
     *
     * @return  self
     */ 
    public function setUserCommand($user_command)
    {
        $this->user_command = $user_command;

        return $this;
    }
}

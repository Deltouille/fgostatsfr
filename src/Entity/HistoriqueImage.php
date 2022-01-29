<?php

namespace App\Entity;

use App\Repository\HistoriqueImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueImageRepository::class)
 */
class HistoriqueImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CraftEssence::class, inversedBy="historiqueImages")
     */
    private $craftEssence;

    /**
     * @ORM\ManyToOne(targetEntity=Servant::class, inversedBy="historiqueImages")
     */
    private $Servant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historiqueImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCraftEssence(): ?CraftEssence
    {
        return $this->craftEssence;
    }

    public function setCraftEssence(?CraftEssence $craftEssence): self
    {
        $this->craftEssence = $craftEssence;

        return $this;
    }

    public function getServant(): ?Servant
    {
        return $this->Servant;
    }

    public function setServant(?Servant $Servant): self
    {
        $this->Servant = $Servant;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}

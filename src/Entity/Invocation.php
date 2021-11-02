<?php

namespace App\Entity;

use App\Repository\InvocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvocationRepository::class)
 */
class Invocation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreServant5;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreServant4;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreCraftEssence5;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateInvocation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="invocations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreSQUsed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreServant5(): ?int
    {
        return $this->nombreServant5;
    }

    public function setNombreServant5(int $nombreServant5): self
    {
        $this->nombreServant5 = $nombreServant5;

        return $this;
    }

    public function getNombreServant4(): ?int
    {
        return $this->nombreServant4;
    }

    public function setNombreServant4(int $nombreServant4): self
    {
        $this->nombreServant4 = $nombreServant4;

        return $this;
    }

    public function getNombreCraftEssence5(): ?int
    {
        return $this->nombreCraftEssence5;
    }

    public function setNombreCraftEssence5(int $nombreCraftEssence5): self
    {
        $this->nombreCraftEssence5 = $nombreCraftEssence5;

        return $this;
    }

    public function getDateInvocation(): ?string
    {
        return $this->dateInvocation;
    }

    public function setDateInvocation(string $dateInvocation): self
    {
        $this->dateInvocation = $dateInvocation;

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

    public function getNombreSQUsed(): ?int
    {
        return $this->nombreSQUsed;
    }

    public function setNombreSQUsed(int $nombreSQUsed): self
    {
        $this->nombreSQUsed = $nombreSQUsed;

        return $this;
    }
}

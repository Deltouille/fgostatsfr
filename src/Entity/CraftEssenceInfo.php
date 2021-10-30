<?php

namespace App\Entity;

use App\Repository\CraftEssenceInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CraftEssenceInfoRepository::class)
 */
class CraftEssenceInfo
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
    private $niveauCE;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMaxLimitBreak;

    /**
     * @ORM\ManyToOne(targetEntity=CraftEssence::class, inversedBy="craftEssenceInfos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $craftEssence;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="craftEssenceInfos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauCE(): ?int
    {
        return $this->niveauCE;
    }

    public function setNiveauCE(int $niveauCE): self
    {
        $this->niveauCE = $niveauCE;

        return $this;
    }

    public function getIsMaxLimitBreak(): ?bool
    {
        return $this->isMaxLimitBreak;
    }

    public function setIsMaxLimitBreak(bool $isMaxLimitBreak): self
    {
        $this->isMaxLimitBreak = $isMaxLimitBreak;

        return $this;
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

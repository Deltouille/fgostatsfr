<?php

namespace App\Entity;

use App\Repository\ServantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServantRepository::class)
 */
class Servant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ServantName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Classe;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isObtained;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $rarity;

    /**
     * @ORM\OneToMany(targetEntity=ServantInfo::class, mappedBy="servant")
     */
    private $ServantInfo;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->servantInfos = new ArrayCollection();
        $this->ServantInfo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServantName(): ?string
    {
        return $this->ServantName;
    }

    public function setServantName(string $ServantName): self
    {
        $this->ServantName = $ServantName;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->Classe;
    }

    public function setClasse(string $Classe): self
    {
        $this->Classe = $Classe;

        return $this;
    }

    public function getIsObtained(): ?bool
    {
        return $this->isObtained;
    }

    public function setIsObtained(bool $isObtained): self
    {
        $this->isObtained = $isObtained;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    /**
     * @return Collection|ServantInfo[]
     */
    public function getServantInfo(): Collection
    {
        return $this->ServantInfo;
    }

    public function addServantInfo(ServantInfo $servantInfo): self
    {
        if (!$this->ServantInfo->contains($servantInfo)) {
            $this->ServantInfo[] = $servantInfo;
            $servantInfo->setServant($this);
        }

        return $this;
    }

    public function removeServantInfo(ServantInfo $servantInfo): self
    {
        if ($this->ServantInfo->removeElement($servantInfo)) {
            // set the owning side to null (unless already changed)
            if ($servantInfo->getServant() === $this) {
                $servantInfo->setServant(null);
            }
        }

        return $this;
    }
}

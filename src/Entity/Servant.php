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
     * @ORM\Column(type="string", length=1)
     */
    private $rarity;

    /**
     * @ORM\OneToMany(targetEntity=ServantInfo::class, mappedBy="servant")
     */
    private $ServantInfo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $charaGraph;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $face;

    /**
     * @ORM\OneToMany(targetEntity=MaterialInfo::class, mappedBy="servant")
     */
    private $materialInfos;

    /**
     * @ORM\OneToMany(targetEntity=HistoriqueImage::class, mappedBy="Servant")
     */
    private $historiqueImages;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->servantInfos = new ArrayCollection();
        $this->ServantInfo = new ArrayCollection();
        $this->materialInfos = new ArrayCollection();
        $this->historiqueImages = new ArrayCollection();
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

    public function getCharaGraph(): ?string
    {
        return $this->charaGraph;
    }

    public function setCharaGraph(string $charaGraph): self
    {
        $this->charaGraph = $charaGraph;

        return $this;
    }

    public function getFace(): ?string
    {
        return $this->face;
    }

    public function setFace(string $face): self
    {
        $this->face = $face;

        return $this;
    }

    /**
     * @return Collection|MaterialInfo[]
     */
    public function getMaterialInfos(): Collection
    {
        return $this->materialInfos;
    }

    public function addMaterialInfo(MaterialInfo $materialInfo): self
    {
        if (!$this->materialInfos->contains($materialInfo)) {
            $this->materialInfos[] = $materialInfo;
            $materialInfo->setServant($this);
        }

        return $this;
    }

    public function removeMaterialInfo(MaterialInfo $materialInfo): self
    {
        if ($this->materialInfos->removeElement($materialInfo)) {
            // set the owning side to null (unless already changed)
            if ($materialInfo->getServant() === $this) {
                $materialInfo->setServant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HistoriqueImage[]
     */
    public function getHistoriqueImages(): Collection
    {
        return $this->historiqueImages;
    }

    public function addHistoriqueImage(HistoriqueImage $historiqueImage): self
    {
        if (!$this->historiqueImages->contains($historiqueImage)) {
            $this->historiqueImages[] = $historiqueImage;
            $historiqueImage->setServant($this);
        }

        return $this;
    }

    public function removeHistoriqueImage(HistoriqueImage $historiqueImage): self
    {
        if ($this->historiqueImages->removeElement($historiqueImage)) {
            // set the owning side to null (unless already changed)
            if ($historiqueImage->getServant() === $this) {
                $historiqueImage->setServant(null);
            }
        }

        return $this;
    }
}

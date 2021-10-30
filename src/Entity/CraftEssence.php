<?php

namespace App\Entity;

use App\Repository\CraftEssenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CraftEssenceRepository::class)
 */
class CraftEssence
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
    private $CEName;

    /**
     * @ORM\Column(type="integer")
     */
    private $CERarity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CEType;

    /**
     * @ORM\OneToMany(targetEntity=CraftEssenceInfo::class, mappedBy="craftEssence")
     */
    private $craftEssenceInfos;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlImage;

    public function __construct()
    {
        $this->craftEssenceInfos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCEName(): ?string
    {
        return $this->CEName;
    }

    public function setCEName(string $CEName): self
    {
        $this->CEName = $CEName;

        return $this;
    }

    public function getCERarity(): ?int
    {
        return $this->CERarity;
    }

    public function setCERarity(int $CERarity): self
    {
        $this->CERarity = $CERarity;

        return $this;
    }

    public function getCEType(): ?string
    {
        return $this->CEType;
    }

    public function setCEType(string $CEType): self
    {
        $this->CEType = $CEType;

        return $this;
    }

    /**
     * @return Collection|CraftEssenceInfo[]
     */
    public function getCraftEssenceInfos(): Collection
    {
        return $this->craftEssenceInfos;
    }

    public function addCraftEssenceInfo(CraftEssenceInfo $craftEssenceInfo): self
    {
        if (!$this->craftEssenceInfos->contains($craftEssenceInfo)) {
            $this->craftEssenceInfos[] = $craftEssenceInfo;
            $craftEssenceInfo->setCraftEssence($this);
        }

        return $this;
    }

    public function removeCraftEssenceInfo(CraftEssenceInfo $craftEssenceInfo): self
    {
        if ($this->craftEssenceInfos->removeElement($craftEssenceInfo)) {
            // set the owning side to null (unless already changed)
            if ($craftEssenceInfo->getCraftEssence() === $this) {
                $craftEssenceInfo->setCraftEssence(null);
            }
        }

        return $this;
    }

    public function getUrlImage(): ?string
    {
        return $this->urlImage;
    }

    public function setUrlImage(string $urlImage): self
    {
        $this->urlImage = $urlImage;

        return $this;
    }
}

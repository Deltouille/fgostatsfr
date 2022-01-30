<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialRepository::class)
 */
class Material
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
    private $MaterialId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MaterialName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MatertialType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MaterialIcon;

    /**
     * @ORM\OneToMany(targetEntity=MaterialInfo::class, mappedBy="material")
     */
    private $materialInfos;

    /**
     * @ORM\OneToMany(targetEntity=UserMaterialInfo::class, mappedBy="Material")
     */
    private $userMaterialInfos;


    public function __construct()
    {
        $this->materialInfos = new ArrayCollection();
        $this->userQuantity = new ArrayCollection();
        $this->userMaterialInfos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterialId(): ?int
    {
        return $this->MaterialId;
    }

    public function setMaterialId(int $MaterialId): self
    {
        $this->MaterialId = $MaterialId;

        return $this;
    }

    public function getMaterialName(): ?string
    {
        return $this->MaterialName;
    }

    public function setMaterialName(string $MaterialName): self
    {
        $this->MaterialName = $MaterialName;

        return $this;
    }

    public function getMatertialType(): ?string
    {
        return $this->MatertialType;
    }

    public function setMatertialType(string $MatertialType): self
    {
        $this->MatertialType = $MatertialType;

        return $this;
    }

    public function getMaterialIcon(): ?string
    {
        return $this->MaterialIcon;
    }

    public function setMaterialIcon(string $MaterialIcon): self
    {
        $this->MaterialIcon = $MaterialIcon;

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
            $materialInfo->setMaterial($this);
        }

        return $this;
    }

    public function removeMaterialInfo(MaterialInfo $materialInfo): self
    {
        if ($this->materialInfos->removeElement($materialInfo)) {
            // set the owning side to null (unless already changed)
            if ($materialInfo->getMaterial() === $this) {
                $materialInfo->setMaterial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserMaterialInfo[]
     */
    public function getUserMaterialInfos(): Collection
    {
        return $this->userMaterialInfos;
    }

    public function addUserMaterialInfo(UserMaterialInfo $userMaterialInfo): self
    {
        if (!$this->userMaterialInfos->contains($userMaterialInfo)) {
            $this->userMaterialInfos[] = $userMaterialInfo;
            $userMaterialInfo->setMaterial($this);
        }

        return $this;
    }

    public function removeUserMaterialInfo(UserMaterialInfo $userMaterialInfo): self
    {
        if ($this->userMaterialInfos->removeElement($userMaterialInfo)) {
            // set the owning side to null (unless already changed)
            if ($userMaterialInfo->getMaterial() === $this) {
                $userMaterialInfo->setMaterial(null);
            }
        }

        return $this;
    }

}

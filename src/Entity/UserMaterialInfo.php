<?php

namespace App\Entity;

use App\Repository\UserMaterialInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserMaterialInfoRepository::class)
 */
class UserMaterialInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userMaterialInfos")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Material::class, inversedBy="userMaterialInfos")
     */
    private $Material;

    /**
     * @ORM\Column(type="integer")
     */
    private $userQuantity;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMaterial(): ?Material
    {
        return $this->Material;
    }

    public function setMaterial(?Material $Material): self
    {
        $this->Material = $Material;

        return $this;
    }

    public function getUserQuantity(): ?int
    {
        return $this->userQuantity;
    }

    public function setUserQuantity(int $userQuantity): self
    {
        $this->userQuantity = $userQuantity;

        return $this;
    }
}

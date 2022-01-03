<?php

namespace App\Entity;

use App\Repository\MaterialInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialInfoRepository::class)
 */
class MaterialInfo
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
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Servant::class, inversedBy="materialInfos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $servant;

    /**
     * @ORM\ManyToOne(targetEntity=Material::class, inversedBy="materialInfos")
     */
    private $material;

    /**
     * @ORM\Column(type="integer")
     */
    private $qpCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $skillLvl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getServant(): ?Servant
    {
        return $this->servant;
    }

    public function setServant(?Servant $servant): self
    {
        $this->servant = $servant;

        return $this;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getQpCost(): ?int
    {
        return $this->qpCost;
    }

    public function setQpCost(int $qpCost): self
    {
        $this->qpCost = $qpCost;

        return $this;
    }

    public function getSkillLvl(): ?int
    {
        return $this->skillLvl;
    }

    public function setSkillLvl(int $skillLvl): self
    {
        $this->skillLvl = $skillLvl;

        return $this;
    }
}

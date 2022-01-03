<?php

namespace App\Entity;

use App\Repository\MaterialEventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialEventRepository::class)
 */
class MaterialEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Material::class)
     */
    private $materialId;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="materialEvents")
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterialId(): ?Material
    {
        return $this->materialId;
    }

    public function setMaterialId(?Material $materialId): self
    {
        $this->materialId = $materialId;

        return $this;
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}

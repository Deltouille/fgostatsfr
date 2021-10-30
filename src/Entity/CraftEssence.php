<?php

namespace App\Entity;

use App\Repository\CraftEssenceRepository;
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
}

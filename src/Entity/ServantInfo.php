<?php

namespace App\Entity;

use App\Repository\ServantInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServantInfoRepository::class)
 */
class ServantInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveauServant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveauSkill1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveauSkill2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveauSkill3;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveauBond;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveauNP;

    /**
     * @ORM\ManyToOne(targetEntity=Servant::class, inversedBy="ServantInfo")
     */
    private $servant;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ServantInfo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->servantId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauServant(): ?int
    {
        return $this->niveauServant;
    }

    public function setNiveauServant(?int $niveauServant): self
    {
        $this->niveauServant = $niveauServant;

        return $this;
    }

    public function getNiveauSkill1(): ?int
    {
        return $this->niveauSkill1;
    }

    public function setNiveauSkill1(?int $niveauSkill1): self
    {
        $this->niveauSkill1 = $niveauSkill1;

        return $this;
    }

    public function getNiveauSkill2(): ?int
    {
        return $this->niveauSkill2;
    }

    public function setNiveauSkill2(?int $niveauSkill2): self
    {
        $this->niveauSkill2 = $niveauSkill2;

        return $this;
    }

    public function getNiveauSkill3(): ?int
    {
        return $this->niveauSkill3;
    }

    public function setNiveauSkill3(?int $niveauSkill3): self
    {
        $this->niveauSkill3 = $niveauSkill3;

        return $this;
    }

    public function getNiveauBond(): ?int
    {
        return $this->niveauBond;
    }

    public function setNiveauBond(?int $niveauBond): self
    {
        $this->niveauBond = $niveauBond;

        return $this;
    }

    public function getNiveauNP(): ?int
    {
        return $this->niveauNP;
    }

    public function setNiveauNP(?int $niveauNP): self
    {
        $this->niveauNP = $niveauNP;

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

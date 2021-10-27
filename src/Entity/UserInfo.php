<?php

namespace App\Entity;

use App\Repository\UserInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserInfoRepository::class)
 */
class UserInfo
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
    private $username;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

    /**
     * @ORM\Column(type="integer")
     */
    private $quartz;

    /**
     * @ORM\Column(type="integer")
     */
    private $bronzeApple;

    /**
     * @ORM\Column(type="integer")
     */
    private $silverApple;

    /**
     * @ORM\Column(type="integer")
     */
    private $goldenApple;

    /**
     * @ORM\Column(type="integer")
     */
    private $manaPrism;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerLevel;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $gameVersion;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userInfos")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getQuartz(): ?int
    {
        return $this->quartz;
    }

    public function setQuartz(int $quartz): self
    {
        $this->quartz = $quartz;

        return $this;
    }

    public function getBronzeApple(): ?int
    {
        return $this->bronzeApple;
    }

    public function setBronzeApple(int $bronzeApple): self
    {
        $this->bronzeApple = $bronzeApple;

        return $this;
    }

    public function getSilverApple(): ?int
    {
        return $this->silverApple;
    }

    public function setSilverApple(int $silverApple): self
    {
        $this->silverApple = $silverApple;

        return $this;
    }

    public function getGoldenApple(): ?int
    {
        return $this->goldenApple;
    }

    public function setGoldenApple(int $goldenApple): self
    {
        $this->goldenApple = $goldenApple;

        return $this;
    }

    public function getManaPrism(): ?int
    {
        return $this->manaPrism;
    }

    public function setManaPrism(int $manaPrism): self
    {
        $this->manaPrism = $manaPrism;

        return $this;
    }

    public function getPlayerLevel(): ?int
    {
        return $this->playerLevel;
    }

    public function setPlayerLevel(int $playerLevel): self
    {
        $this->playerLevel = $playerLevel;

        return $this;
    }

    public function getGameVersion(): ?string
    {
        return $this->gameVersion;
    }

    public function setGameVersion(string $gameVersion): self
    {
        $this->gameVersion = $gameVersion;

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

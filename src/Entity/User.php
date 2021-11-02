<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=UserInfo::class, mappedBy="user")
     */
    private $userInfos;

    /**
     * @ORM\OneToMany(targetEntity=ServantInfo::class, mappedBy="user")
     */
    private $ServantInfo;

    /**
     * @ORM\OneToMany(targetEntity=CraftEssenceInfo::class, mappedBy="user")
     */
    private $craftEssenceInfos;

    /**
     * @ORM\OneToMany(targetEntity=Invocation::class, mappedBy="user")
     */
    private $invocations;


    public function __construct()
    {
        $this->userInfos = new ArrayCollection();
        $this->servants = new ArrayCollection();
        $this->servantId = new ArrayCollection();
        $this->servantInfos = new ArrayCollection();
        $this->ServantInfo = new ArrayCollection();
        $this->craftEssenceInfos = new ArrayCollection();
        $this->invocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|UserInfo[]
     */
    public function getUserInfos(): Collection
    {
        return $this->userInfos;
    }

    public function addUserInfo(UserInfo $userInfo): self
    {
        if (!$this->userInfos->contains($userInfo)) {
            $this->userInfos[] = $userInfo;
            $userInfo->setUser($this);
        }

        return $this;
    }

    public function removeUserInfo(UserInfo $userInfo): self
    {
        if ($this->userInfos->removeElement($userInfo)) {
            // set the owning side to null (unless already changed)
            if ($userInfo->getUser() === $this) {
                $userInfo->setUser(null);
            }
        }
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
            $servantInfo->setUser($this);
        }

        return $this;
    }

    public function removeServantInfo(ServantInfo $servantInfo): self
    {
        if ($this->ServantInfo->removeElement($servantInfo)) {
            // set the owning side to null (unless already changed)
            if ($servantInfo->getUser() === $this) {
                $servantInfo->setUser(null);
            }
        }

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
            $craftEssenceInfo->setUser($this);
        }

        return $this;
    }

    public function removeCraftEssenceInfo(CraftEssenceInfo $craftEssenceInfo): self
    {
        if ($this->craftEssenceInfos->removeElement($craftEssenceInfo)) {
            // set the owning side to null (unless already changed)
            if ($craftEssenceInfo->getUser() === $this) {
                $craftEssenceInfo->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invocation[]
     */
    public function getInvocations(): Collection
    {
        return $this->invocations;
    }

    public function addInvocation(Invocation $invocation): self
    {
        if (!$this->invocations->contains($invocation)) {
            $this->invocations[] = $invocation;
            $invocation->setUser($this);
        }

        return $this;
    }

    public function removeInvocation(Invocation $invocation): self
    {
        if ($this->invocations->removeElement($invocation)) {
            // set the owning side to null (unless already changed)
            if ($invocation->getUser() === $this) {
                $invocation->setUser(null);
            }
        }

        return $this;
    }
}

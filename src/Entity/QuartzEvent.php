<?php

namespace App\Entity;

use App\Repository\QuartzEventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuartzEventRepository::class)
 */
class QuartzEvent
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
    private $quartzQuantity;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="quartzEvents")
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuartzQuantity(): ?int
    {
        return $this->quartzQuantity;
    }

    public function setQuartzQuantity(int $quartzQuantity): self
    {
        $this->quartzQuantity = $quartzQuantity;

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

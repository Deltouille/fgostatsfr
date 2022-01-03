<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $eventId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventStart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventEnd;

    /**
     * @ORM\OneToMany(targetEntity=MaterialEvent::class, mappedBy="event")
     */
    private $materialEvents;

    /**
     * @ORM\OneToMany(targetEntity=QuartzEvent::class, mappedBy="event")
     */
    private $quartzEvents;

    public function __construct()
    {
        $this->materialEvents = new ArrayCollection();
        $this->quartzEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?int
    {
        return $this->eventId;
    }

    public function setEventId(int $eventId): self
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getEventStart(): ?string
    {
        return $this->eventStart;
    }

    public function setEventStart(string $eventStart): self
    {
        $this->eventStart = $eventStart;

        return $this;
    }

    public function getEventEnd(): ?string
    {
        return $this->eventEnd;
    }

    public function setEventEnd(string $eventEnd): self
    {
        $this->eventEnd = $eventEnd;

        return $this;
    }

    /**
     * @return Collection|MaterialEvent[]
     */
    public function getMaterialEvents(): Collection
    {
        return $this->materialEvents;
    }

    public function addMaterialEvent(MaterialEvent $materialEvent): self
    {
        if (!$this->materialEvents->contains($materialEvent)) {
            $this->materialEvents[] = $materialEvent;
            $materialEvent->setEvent($this);
        }

        return $this;
    }

    public function removeMaterialEvent(MaterialEvent $materialEvent): self
    {
        if ($this->materialEvents->removeElement($materialEvent)) {
            // set the owning side to null (unless already changed)
            if ($materialEvent->getEvent() === $this) {
                $materialEvent->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QuartzEvent[]
     */
    public function getQuartzEvents(): Collection
    {
        return $this->quartzEvents;
    }

    public function addQuartzEvent(QuartzEvent $quartzEvent): self
    {
        if (!$this->quartzEvents->contains($quartzEvent)) {
            $this->quartzEvents[] = $quartzEvent;
            $quartzEvent->setEvent($this);
        }

        return $this;
    }

    public function removeQuartzEvent(QuartzEvent $quartzEvent): self
    {
        if ($this->quartzEvents->removeElement($quartzEvent)) {
            // set the owning side to null (unless already changed)
            if ($quartzEvent->getEvent() === $this) {
                $quartzEvent->setEvent(null);
            }
        }

        return $this;
    }
}

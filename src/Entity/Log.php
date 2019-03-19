<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 */
class Log
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Log", inversedBy="logs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $device;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Log", mappedBy="device", orphanRemoval=true)
     */
    private $logs;

    public function __construct()
    {
        $this->logs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDevice(): ?self
    {
        return $this->device;
    }

    public function setDevice(?self $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(self $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setDevice($this);
        }

        return $this;
    }

    public function removeLog(self $log): self
    {
        if ($this->logs->contains($log)) {
            $this->logs->removeElement($log);
            // set the owning side to null (unless already changed)
            if ($log->getDevice() === $this) {
                $log->setDevice(null);
            }
        }

        return $this;
    }
}

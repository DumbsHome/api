<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ElectricLogRepository")
 */
class ElectricLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime Date et heure de création de l'enregistrement
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var string Le numéro d'identification du compteur
     * @ORM\Column(type="string", length=12)
     */
    private $adco;

    /**
     * @var string Option tarifaire (type d'abonnement)
     * @ORM\Column(type="string", length=4)
     */
    private $optarif;

    /**
     * @var int Intensité souscrite
     * @ORM\Column(type="smallint")
     */
    private $isousc;

    /**
     * @var int Index heures creuses (Wh)
     * @ORM\Column(type="bigint")
     */
    private $hchc;

    /**
     * @var int Index heures pleines (Wh)
     * @ORM\Column(type="bigint")
     */
    private $hchp;

    /**
     * @var string Période tarifaire en cours
     * @ORM\Column(type="string", length=4)
     */
    private $ptec;

    /**
     * @var int Intensité instantanée (A)
     * @ORM\Column(type="smallint")
     */
    private $iinst;

    /**
     * @var int Intensité maximale (A)
     * @ORM\Column(type="smallint")
     */
    private $imax;

    /**
     * @var int Avertissement de dépassement de puissance souscritre (A)
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $adps;

    /**
     * @var int Puissance apparente (W)
     * @ORM\Column(type="smallint")
     */
    private $papp;

    /**
     * @var string Groupe horaire (heure creuse ou tempo)
     * @ORM\Column(type="string", length=1)
     */
    private $hhphc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getAdco(): ?string
    {
        return $this->adco;
    }

    public function setAdco(string $adco): self
    {
        $this->adco = $adco;

        return $this;
    }

    public function getOptarif(): ?string
    {
        return $this->optarif;
    }

    public function setOptarif(string $optarif): self
    {
        $this->optarif = $optarif;

        return $this;
    }

    public function getIsousc(): ?int
    {
        return $this->isousc;
    }

    public function setIsousc(int $isousc): self
    {
        $this->isousc = $isousc;

        return $this;
    }

    public function getHchc(): ?int
    {
        return $this->hchc;
    }

    public function setHchc(int $hchc): self
    {
        $this->hchc = $hchc;

        return $this;
    }

    public function getHchp(): ?int
    {
        return $this->hchp;
    }

    public function setHchp(int $hchp): self
    {
        $this->hchp = $hchp;

        return $this;
    }

    public function getPtec(): ?string
    {
        return $this->ptec;
    }

    public function setPtec(string $ptec): self
    {
        $this->ptec = $ptec;

        return $this;
    }

    public function getIinst(): ?int
    {
        return $this->iinst;
    }

    public function setIinst(int $iinst): self
    {
        $this->iinst = $iinst;

        return $this;
    }

    public function getImax(): ?int
    {
        return $this->imax;
    }

    public function setImax(int $imax): self
    {
        $this->imax = $imax;

        return $this;
    }

    public function getAdps(): ?int
    {
        return $this->adps;
    }

    public function setAdps(int $adps): self
    {
        $this->adps = $adps;

        return $this;
    }

    public function getPapp(): ?int
    {
        return $this->papp;
    }

    public function setPapp(int $papp): self
    {
        $this->papp = $papp;

        return $this;
    }

    public function getHhphc(): ?string
    {
        return $this->hhphc;
    }

    public function setHhphc(string $hhphc): self
    {
        $this->hhphc = $hhphc;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TicketLocationRepository;
use Doctrine\ORM\Mapping as ORM;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;

/**
 * @ORM\Entity(repositoryClass=TicketLocationRepository::class)
 */
class TicketLocation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $sex;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class)
     */
    private $nationalite;

    /**
     * @ORM\ManyToOne(targetEntity=StatusUser::class)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Handicap::class)
     */
    private $handicap;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $village;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $quartier;

    /**
     * @ORM\OneToOne(targetEntity=Ticket::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="ticketLocations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getVillage(): ?string
    {
        return $this->village;
    }

    public function setVillage(?string $village): self
    {
        $this->village = $village;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(?string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNationalite(): ?Country
    {
        return $this->nationalite;
    }

    public function setNationalite(?Country $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getHandicap(): ?Handicap
    {
        return $this->handicap;
    }

    public function setHandicap(?Handicap $handicap): self
    {
        $this->handicap = $handicap;

        return $this;
    }

    public function getStatus(): ?StatusUser
    {
        return $this->status;
    }

    public function setStatus(?StatusUser $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }
}

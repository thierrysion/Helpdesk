<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 * @UniqueEntity("code")
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="subDivisions")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="parent")
     */
    private $subDivisions;

    /**
     * @ORM\ManyToOne(targetEntity=TypeLocation::class, inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeLocation;

    /**
     * @ORM\OneToMany(targetEntity=TicketLocation::class, mappedBy="location")
     */
    private $ticketLocations;

    public function __construct()
    {
        $this->subDivisions = new ArrayCollection();
        $this->ticketLocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubDivisions(): Collection
    {
        return $this->subDivisions;
    }

    public function addSubDivision(self $subDivision): self
    {
        if (!$this->subDivisions->contains($subDivision)) {
            $this->subDivisions[] = $subDivision;
            $subDivision->setParent($this);
        }

        return $this;
    }

    public function removeSubDivision(self $subDivision): self
    {
        if ($this->subDivisions->removeElement($subDivision)) {
            // set the owning side to null (unless already changed)
            if ($subDivision->getParent() === $this) {
                $subDivision->setParent(null);
            }
        }

        return $this;
    }

    public function getTypeLocation(): ?TypeLocation
    {
        return $this->typeLocation;
    }

    public function setTypeLocation(?TypeLocation $typeLocation): self
    {
        $this->typeLocation = $typeLocation;

        return $this;
    }

    /**
     * @return Collection<int, TicketLocation>
     */
    public function getTicketLocations(): Collection
    {
        return $this->ticketLocations;
    }

    public function addTicketLocation(TicketLocation $ticketLocation): self
    {
        if (!$this->ticketLocations->contains($ticketLocation)) {
            $this->ticketLocations[] = $ticketLocation;
            $ticketLocation->setLocation($this);
        }

        return $this;
    }

    public function removeTicketLocation(TicketLocation $ticketLocation): self
    {
        if ($this->ticketLocations->removeElement($ticketLocation)) {
            // set the owning side to null (unless already changed)
            if ($ticketLocation->getLocation() === $this) {
                $ticketLocation->setLocation(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\UserInfosRepository;
use Doctrine\ORM\Mapping as ORM;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass=UserInfosRepository::class)
 */
class UserInfos
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
     * @ORM\ManyToOne(targetEntity=Location::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $commune;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $village;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $quartier;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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

    public function getCommune(): ?Location
    {
        return $this->commune;
    }

    public function setCommune(?Location $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

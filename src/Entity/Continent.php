<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContinentRepository")
 */
class Continent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $continent_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Country", mappedBy="id")
     */
    private $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->continent_name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContinentName(): ?string
    {
        return $this->continent_name;
    }

    public function setContinentName(string $continent_name): self
    {
        $this->continent_name = $continent_name;

        return $this;
    }

    /**
     * @return Collection|Country[]
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->countries->contains($country)) {
            $this->countries[] = $country;
            $country->setContinentName($this);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->countries->contains($country)) {
            $this->countries->removeElement($country);
            // set the owning side to null (unless already changed)
            if ($country->getContinentName() === $this) {
                $country->setContinentName(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
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
    private $countryName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Continent", inversedBy="countries")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\NotBlank(message="Merci de selectionner le continent de votre aventure")
     */
    private $continentName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="countryid")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->countryName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    public function getContinentName(): ?Continent
    {
        return $this->continentName;
    }

    public function setContinentName(?Continent $continentName): self
    {
        $this->continentName = $continentName;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCountryid($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getCountryid() === $this) {
                $article->setCountryid(null);
            }
        }

        return $this;
    }
}

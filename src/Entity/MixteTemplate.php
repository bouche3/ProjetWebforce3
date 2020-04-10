<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MixteTemplateRepository")
 */
class MixteTemplate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $banner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introduction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carouselImg1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carouselImg2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carouselImg3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carouselImg4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carouselImg5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carouselContent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $conclusion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="templateMixedid")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(?string $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getImg1(): ?string
    {
        return $this->img1;
    }

    public function setImg1(?string $img1): self
    {
        $this->img1 = $img1;

        return $this;
    }

    public function getImg2(): ?string
    {
        return $this->img2;
    }

    public function setImg2(?string $img2): self
    {
        $this->img2 = $img2;

        return $this;
    }

    public function getCarouselImg1(): ?string
    {
        return $this->carouselImg1;
    }

    public function setCarouselImg1(?string $carouselImg1): self
    {
        $this->carouselImg1 = $carouselImg1;

        return $this;
    }

    public function getCarouselImg2(): ?string
    {
        return $this->carouselImg2;
    }

    public function setCarouselImg2(?string $carouselImg2): self
    {
        $this->carouselImg2 = $carouselImg2;

        return $this;
    }

    public function getCarouselImg3(): ?string
    {
        return $this->carouselImg3;
    }

    public function setCarouselImg3(?string $carouselImg3): self
    {
        $this->carouselImg3 = $carouselImg3;

        return $this;
    }

    public function getCarouselImg4(): ?string
    {
        return $this->carouselImg4;
    }

    public function setCarouselImg4(?string $carouselImg4): self
    {
        $this->carouselImg4 = $carouselImg4;

        return $this;
    }

    public function getCarouselImg5(): ?string
    {
        return $this->carouselImg5;
    }

    public function setCarouselImg5(?string $carouselImg5): self
    {
        $this->carouselImg5 = $carouselImg5;

        return $this;
    }

    public function getCarouselContent(): ?string
    {
        return $this->carouselContent;
    }

    public function setCarouselContent(?string $carouselContent): self
    {
        $this->carouselContent = $carouselContent;

        return $this;
    }

    public function getContent1(): ?string
    {
        return $this->content1;
    }

    public function setContent1(?string $content1): self
    {
        $this->content1 = $content1;

        return $this;
    }

    public function getContent2(): ?string
    {
        return $this->content2;
    }

    public function setContent2(?string $content2): self
    {
        $this->content2 = $content2;

        return $this;
    }

    public function getConclusion(): ?string
    {
        return $this->conclusion;
    }

    public function setConclusion(?string $conclusion): self
    {
        $this->conclusion = $conclusion;

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
            $article->setTemplateMixedid($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getTemplateMixedid() === $this) {
                $article->setTemplateMixedid(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}

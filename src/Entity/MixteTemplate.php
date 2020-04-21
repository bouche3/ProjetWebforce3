<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="La bannière est obligatoire", groups={"create"})
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="1000k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $banner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introduction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $carouselImg1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $carouselImg2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $carouselImg3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $carouselImg4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
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

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBanner()
    {
        return $this->banner;
    }

    public function setBanner($banner): self
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

    public function getImg1()
    {
        return $this->img1;
    }

    public function setImg1($img1): self
    {
        $this->img1 = $img1;

        return $this;
    }

    public function getImg2()
    {
        return $this->img2;
    }

    public function setImg2($img2): self
    {
        $this->img2 = $img2;

        return $this;
    }

    public function getCarouselImg1()
    {
        return $this->carouselImg1;
    }

    public function setCarouselImg1($carouselImg1): self
    {
        $this->carouselImg1 = $carouselImg1;

        return $this;
    }

    public function getCarouselImg2()
    {
        return $this->carouselImg2;
    }

    public function setCarouselImg2($carouselImg2): self
    {
        $this->carouselImg2 = $carouselImg2;

        return $this;
    }

    public function getCarouselImg3()
    {
        return $this->carouselImg3;
    }

    public function setCarouselImg3($carouselImg3): self
    {
        $this->carouselImg3 = $carouselImg3;

        return $this;
    }

    public function getCarouselImg4()
    {
        return $this->carouselImg4;
    }

    public function setCarouselImg4($carouselImg4): self
    {
        $this->carouselImg4 = $carouselImg4;

        return $this;
    }

    public function getCarouselImg5()
    {
        return $this->carouselImg5;
    }

    public function setCarouselImg5($carouselImg5): self
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

}

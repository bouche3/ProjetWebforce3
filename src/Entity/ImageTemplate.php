<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageTemplateRepository")
 */
class ImageTemplate
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
    private $img3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img8;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img9;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img10;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img11;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     */
    private $img12;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content8;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content9;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content10;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content11;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content12;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $conclusion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="templateImageid")
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

    public function getImg3()
    {
        return $this->img3;
    }

    public function setImg3($img3): self
    {
        $this->img3 = $img3;

        return $this;
    }

    public function getImg4()
    {
        return $this->img4;
    }

    public function setImg4($img4): self
    {
        $this->img4 = $img4;

        return $this;
    }

    public function getImg5()
    {
        return $this->img5;
    }

    public function setImg5($img5): self
    {
        $this->img5 = $img5;

        return $this;
    }

    public function getImg6()
    {
        return $this->img6;
    }

    public function setImg6($img6): self
    {
        $this->img6 = $img6;

        return $this;
    }

    public function getImg7()
    {
        return $this->img7;
    }

    public function setImg7($img7): self
    {
        $this->img7 = $img7;

        return $this;
    }

    public function getImg8()
    {
        return $this->img8;
    }

    public function setImg8($img8): self
    {
        $this->img8 = $img8;

        return $this;
    }

    public function getImg9()
    {
        return $this->img9;
    }

    public function setImg9($img9): self
    {
        $this->img9 = $img9;

        return $this;
    }

    public function getImg10()
    {
        return $this->img10;
    }

    public function setImg10($img10): self
    {
        $this->img10 = $img10;

        return $this;
    }

    public function getImg11()
    {
        return $this->img11;
    }

    public function setImg11($img11): self
    {
        $this->img11 = $img11;

        return $this;
    }

    public function getImg12()
    {
        return $this->img12;
    }

    public function setImg12($img12): self
    {
        $this->img12 = $img12;

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

    public function getContent3(): ?string
    {
        return $this->content3;
    }

    public function setContent3(?string $content3): self
    {
        $this->content3 = $content3;

        return $this;
    }

    public function getContent4(): ?string
    {
        return $this->content4;
    }

    public function setContent4(?string $content4): self
    {
        $this->content4 = $content4;

        return $this;
    }

    public function getContent5(): ?string
    {
        return $this->content5;
    }

    public function setContent5(?string $content5): self
    {
        $this->content5 = $content5;

        return $this;
    }

    public function getContent6(): ?string
    {
        return $this->content6;
    }

    public function setContent6(?string $content6): self
    {
        $this->content6 = $content6;

        return $this;
    }

    public function getContent7(): ?string
    {
        return $this->content7;
    }

    public function setContent7(?string $content7): self
    {
        $this->content7 = $content7;

        return $this;
    }

    public function getContent8(): ?string
    {
        return $this->content8;
    }

    public function setContent8(?string $content8): self
    {
        $this->content8 = $content8;

        return $this;
    }

    public function getContent9(): ?string
    {
        return $this->content9;
    }

    public function setContent9(?string $content9): self
    {
        $this->content9 = $content9;

        return $this;
    }

    public function getContent10(): ?string
    {
        return $this->content10;
    }

    public function setContent10(?string $content10): self
    {
        $this->content10 = $content10;

        return $this;
    }

    public function getContent11(): ?string
    {
        return $this->content11;
    }

    public function setContent11(?string $content11): self
    {
        $this->content11 = $content11;

        return $this;
    }

    public function getContent12(): ?string
    {
        return $this->content12;
    }

    public function setContent12(?string $content12): self
    {
        $this->content12 = $content12;

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
            $article->setTemplateImageid($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getTemplateImageid() === $this) {
                $article->setTemplateImageid(null);
            }
        }

        return $this;
    }

}

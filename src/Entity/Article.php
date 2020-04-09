<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $countryid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TravelCategory", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ImageTemplate", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $templateImageid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MixteTemplate", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $templateMixedid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TextTemplate", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $templateTextid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="articleid")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getCountryid(): ?Country
    {
        return $this->countryid;
    }

    public function setCountryid(?Country $countryid): self
    {
        $this->countryid = $countryid;

        return $this;
    }

    public function getCategoryid(): ?TravelCategory
    {
        return $this->categoryid;
    }

    public function setCategoryid(?TravelCategory $categoryid): self
    {
        $this->categoryid = $categoryid;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getTemplateImageid(): ?ImageTemplate
    {
        return $this->templateImageid;
    }

    public function setTemplateImageid(?ImageTemplate $templateImageid): self
    {
        $this->templateImageid = $templateImageid;

        return $this;
    }

    public function getTemplateMixedid(): ?MixteTemplate
    {
        return $this->templateMixedid;
    }

    public function setTemplateMixedid(?MixteTemplate $templateMixedid): self
    {
        $this->templateMixedid = $templateMixedid;

        return $this;
    }

    public function getTemplateTextid(): ?TextTemplate
    {
        return $this->templateTextid;
    }

    public function setTemplateTextid(?TextTemplate $templateTextid): self
    {
        $this->templateTextid = $templateTextid;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticleid($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticleid() === $this) {
                $comment->setArticleid(null);
            }
        }

        return $this;
    }
}

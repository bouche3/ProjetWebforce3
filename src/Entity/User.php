<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"pseudo"}, message="Ce pseudo est déjà utilisé")
 * @UniqueEntity(fields={"email"}, message="Cet email est déjà utilisé")
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Le pseudo est obligatoire")
     * @Assert\Length(min="2", minMessage="Le pseudo doit avoir au moins {{ limit }} caractères")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     */
    private $firstname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="L'email est obligatoire")
     * @Assert\Email(message="L'email n'est pas valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     * @Assert\Regex("/^[a-zA-Z0-9\W]{6,10}$/", message="Mot de passe non conforme")
     *
     */
    private $plainpassword;

    /**
     * @return string|null
     */
    public function getPlainpassword(): ?string
    {
        return $this->plainpassword;
    }

    /**
     * @param string|null $plainpassword
     * @return User
     */
    public function setPlainpassword(?string $plainpassword): User
    {
        $this->plainpassword = $plainpassword;
        return $this;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(
     *     mimeTypes={"image/png", "image/jpeg", "image"},
     *     mimeTypesMessage="Le fichier doit être une image JPG ou PNG",
     *     maxSize="600k",
     *     maxSizeMessage="L'image ne doit pas dépasser {{ limit }}{{ suffix }}")
     * * @Assert\Image(
     *     minWidth = 10,
     *     minWidthMessage="L'image ne doit pas faire moins de {{ min_width }}px de largeur",
     *     maxWidth = 400,
     *     maxWidthMessage="L'image ne doit pas dépasser {{ max_width }}px de largeur",
     *     minHeight = 10,
     *     minHeightMessage="L'image ne doit pas faire moins de {{ min_height }}px de hauteur",
     *     maxHeight = 400,
     *     maxHeightMessage="L'image ne doit pas dépasser {{ max_height }}px de hauteur")
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = 'ROLE_USER';

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="userid")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="userid")
     */
    private $comments;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->registrationDate = new \DateTime();
    }

    public function __toString()
    {
        return $this->pseudo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [$this->status];
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // inutile ici car l'algo de cryptage utilisé en contient déjà un
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        //L'authentifiant est le pseudo
        return $this->pseudo;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // N'est utile que lorsqu'il y a des données sensibles dans les objets User
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
            $article->setUserid($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getUserid() === $this) {
                $article->setUserid(null);
            }
        }

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
            $comment->setUserid($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUserid() === $this) {
                $comment->setUserid(null);
            }
        }

        return $this;
    }

}

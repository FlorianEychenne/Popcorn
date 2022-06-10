<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 80)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 80)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 80)]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    private $gender;

    #[ORM\Column(type: 'array')]
    private $preferences = [];

    #[ORM\Column(type: 'datetime')]
    private $register_at;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reviews::class)]
    private $reviews;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Post::class)]
    private $posts;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comments::class)]
    private $comments;

    #[ORM\Column(type: 'date')]
    private $birthday;

    #[ORM\Column(type: 'object')]
    private $profile_picture;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'favorites')]
    private $favposts;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'abonnes')]
    #[ORM\JoinTable(name: "user_user")]
	#[ORM\JoinColumn(name: "user_source", referencedColumnName: "id")]
	#[ORM\InverseJoinColumn(name: "user_target", referencedColumnName: "id")]
    private $abonnes;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'abonnements')]
    private $abonnements;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->favposts = new ArrayCollection();
        $this->abonnes = new ArrayCollection();    
        $this->abonnements = new ArrayCollection();    
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified)
    {
        $this->isVerified = $isVerified;

    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }


    public function getPreferences(): ?array
    {
        return $this->preferences;
    }

    public function setPreferences(array $preferences): self
    {
        $this->preferences = $preferences;

        return $this;
    }

    public function getRegisterAt(): ?\DateTimeInterface
    {
        return $this->register_at;
    }

    public function setRegisterAt(\DateTimeInterface $register_at): self
    {
        $this->register_at = $register_at;

        return $this;
    }

    /**
     * @return Collection|Reviews[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }
    
    
    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    
    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getProfilePicture()
    {
        return $this->profile_picture;
    }

    public function setProfilePicture($profile_picture): self
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    /**
     * @return Collection|Post[]
     * $this->getUser()->getFavposts() // $post->getTitle()
     */
    public function getFavposts(): Collection
    {
        return $this->favposts;
    }

    public function addFavpost(Post $favpost): self
    {
        if (!$this->favposts->contains($favpost)) {
            $this->favposts[] = $favpost;
            $favpost->addFavorite($this);
        }

        return $this;
    }

    public function removeFavpost(Post $favpost): self
    {
        if ($this->favposts->removeElement($favpost)) {
            $favpost->removeFavorite($this);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getAbonnes(): Collection
    {
        return $this->abonnes;
    }

    public function addAbonne(self $abonne): self
    {
        if (!$this->abonnes->contains($abonne)) {
            $this->abonnes[] = $abonne;
        }

        return $this;
    }

    public function removeAbonne(self $abonne): self
    {
        $this->abonnes->removeElement($abonne);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getAbonnements(): Collection
    {
        return $this->abonnements;
    }

    public function addAbonnement(self $abonnement): self
    {
        if (!$this->abonnements->contains($abonnement)) {
            $this->abonnements[] = $abonnement;
        }

        return $this;
    }

    public function removeAbonnement(self $abonnement): self
    {
        $this->abonnements->removeElement($abonnement);

        return $this;
    }
}



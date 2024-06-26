<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['Email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email "{{ value }}" is not a valid email.',
        mode: "strict"
    )]
    private string $Email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: "The password cannot be blank.")]
    #[Assert\Length(
        min: 8,
        max: 64,
        minMessage: "Your password must be at least {{ limit }} characters long",
        maxMessage: "Your password cannot be longer than {{ limit }} characters"
    )]
    #[Assert\Regex(
        pattern: '/(?=.*[a-z])/',
        message: "Your password must include at least one lowercase letter."
    )]
    #[Assert\Regex(
        pattern: '/(?=.*[A-Z])/',
        message: "Your password must include at least one uppercase letter."
    )]
    #[Assert\Regex(
        pattern: '/(?=.*\d)/',
        message: "Your password must include at least one number."
    )]
    #[Assert\Regex(
        pattern: '/(?=.*[\W])/',
        message: "Your password must include at least one special character."
    )]
    private string $password;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 50,
        maxMessage: "Your first name cannot be longer than {{ limit }} characters"
    )]
    private string $Firstname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 50,
        maxMessage: "Your last name cannot be longer than {{ limit }} characters"
    )]
    private string $Lastname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 30,
        maxMessage: "Your username cannot be longer than {{ limit }} characters"
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9_\-\.]+$/',
        message: 'Your username must only contain letters, numbers, dots, hyphens, and underscores.'
    )]
    private string $Username;

    #[ORM\Column]
    #[Assert\Type("\DateTimeImmutable")]
    private \DateTimeImmutable $CreatedAt;

    #[ORM\Column(nullable: true)]
    #[Assert\Type("\DateTimeImmutable")]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Comment $Comment = null;

    #[ORM\ManyToMany(targetEntity: Gallery::class, mappedBy: 'users')]
    private Collection $galleries;

    public function __construct()
    {
        $this->CreatedAt = new \DateTimeImmutable();
        $this->galleries = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->Email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): static
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): static
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): static
    {
        $this->Username = $Username;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->Comment;
    }

    public function setComment(?Comment $Comment): static
    {
        $this->Comment = $Comment;

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Gallery $gallery): static
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries->add($gallery);
            $gallery->addUser($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): static
    {
        if ($this->galleries->removeElement($gallery)) {
            $gallery->removeUser($this);
        }

        return $this;
    }
}

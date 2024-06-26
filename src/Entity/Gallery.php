<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The gallery name is required.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "The gallery name cannot be longer than {{ limit }} characters."
    )]
    private string $name;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The slug is required.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "The slug cannot be longer than {{ limit }} characters."
    )]
    #[Assert\Regex(
        pattern: '/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
        message: "The slug must be lowercase and may contain hyphens and numbers only."
    )]
    private string $slug;

    #[ORM\Column]
    #[Assert\Type(type: \DateTimeImmutable::class)]
    private \DateTimeImmutable $publishedAt;

    #[ORM\OneToMany(targetEntity: Photo::class, mappedBy: 'gallery')]
    private Collection $photos;

    #[ORM\ManyToMany(targetEntity: Service::class, inversedBy: 'galleries')]
    private Collection $services;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'galleries')]
    private Collection $users;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->name = $slug;

        return $this;
    }

    public function getPublishedAt(): \DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setGallery($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getGallery() === $this) {
                $photo->setGallery(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        $this->services->removeElement($service);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

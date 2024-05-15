<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The title of the service is required.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "The title cannot be longer than {{ limit }} characters."
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "A photo URL/path is required.")]
    private string $photo;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Information about the service is required.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9 .,!?\\-()\"\'\r\n]+$/",
        message: "The information contains invalid characters."
    )]
    private ?string $information = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank(message: "The price of the service is required.")]
    #[Assert\Regex(
        pattern: '/^\d+(\.\d{1,2})?$/',
        message: "The price must be a valid number with up to two decimal places."
    )]
    private ?string $price = null;

    #[ORM\ManyToMany(targetEntity: Gallery::class, mappedBy: 'services')]
    private Collection $galleries;

    #[ORM\Column]
    #[Assert\NotNull(message: "The duration of the service is required.")]
    #[Assert\Range(
        min: 1,
        max: 24,
        notInRangeMessage: "The duration must be between {{ min }} and {{ max }}."
    )]
    private ?int $duration = null;

    public function __construct()
    {
        $this->galleries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): static
    {
        $this->information = $information;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

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
            $gallery->addService($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): static
    {
        if ($this->galleries->removeElement($gallery)) {
            $gallery->removeService($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title; // Retournez le nom du service ou toute autre propriété appropriée.
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}

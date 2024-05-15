<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhotoRepository;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "A photo URL/path is required.")]
    private string $photo;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The title of the photo is required.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "The title cannot be longer than {{ limit }} characters."
    )]
    private string $title;

    #[ORM\Column]
    #[Assert\NotBlank(message: "The placement of the photo is required.")]
    #[Assert\Range(
        min: 1,
        max: 3,
        notInRangeMessage: "The placement must be between {{ min }} and {{ max }}."
    )]
    #[Assert\Type(
        type: "integer",
        message: "The placement must be an integer."
    )]
    private int $placement;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private Gallery $gallery;



    public function getId(): int
    {
        return $this->id;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPlacement(): int
    {
        return $this->placement;
    }

    public function setPlacement(int $placement): static
    {
        $this->placement = $placement;

        return $this;
    }

    public function getGallery(): Gallery
    {
        return $this->gallery;
    }

    public function setGallery(?Gallery $Gallery): static
    {
        $this->gallery = $Gallery;

        return $this;
    }
}

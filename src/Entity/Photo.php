<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhotoRepository;


#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $photo;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column]
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

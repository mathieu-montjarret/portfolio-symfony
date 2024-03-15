<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Photo = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $Extension = null;

    #[ORM\Column]
    private ?int $Placement = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?Gallery $Gallery = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(string $Photo): static
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->Extension;
    }

    public function setExtension(string $Extension): static
    {
        $this->Extension = $Extension;

        return $this;
    }

    public function getPlacement(): ?int
    {
        return $this->Placement;
    }

    public function setPlacement(int $Placement): static
    {
        $this->Placement = $Placement;

        return $this;
    }

    public function getGallery(): ?Gallery
    {
        return $this->Gallery;
    }

    public function setGallery(?Gallery $Gallery): static
    {
        $this->Gallery = $Gallery;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The last name is required.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "The first name cannot be longer than {{ limit }} characters."
    )]
    private string $Firstname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The last name is required.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "The last name cannot be longer than {{ limit }} characters."
    )]
    private string $Lastname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The email address is required.")]
    #[Assert\Email(
        message: "The email '{{ value }}' is not a valid email."
    )]
    private string $Email;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 20,
        maxMessage: "The phone number cannot be longer than {{ limit }} characters."
    )]
    #[Assert\Regex(
        pattern: "/^\+?\d{1,15}$/",
        message: "The phone number is invalid."
    )]
    private ?string $Phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The subject is required.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "The subject cannot be longer than {{ limit }} characters."
    )]
    private string $Subject;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "The message cannot be empty.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9 .,!?\\-()\"\'\r\n]+$/",
        message: "The message contains invalid characters."
    )]
    private string $Message;

    public function getId(): int
    {
        return $this->id;
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

    public function getEmail(): string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(?string $Phone): static
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->Subject;
    }

    public function setSubject(string $Subject): static
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): static
    {
        $this->Message = $Message;

        return $this;
    }
}

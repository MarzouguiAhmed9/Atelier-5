<?php

namespace App\Entity;
use Doctrine\ORM\QueryBuilder;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    
    #[ORM\Column]
    private ?int $ref = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Auther $Auther = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    public function getRef(): ?int
    {
        return $this->ref;
    }
    public function setRef(string $ref): static
    {
        $this->ref = $ref;

        return $this;
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

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getAuther(): ?Auther
    {
        return $this->Auther;
    }

    public function setAuther(?Auther $Auther): static
    {
        $this->Auther = $Auther;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }
}

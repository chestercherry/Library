<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $descriprion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $time;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="books")
     */
    private $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescriprion(): ?string
    {
        return $this->descriprion;
    }

    /**
     * @param string $descriprion
     * @return $this
     */
    public function setDescriprion(string $descriprion): self
    {
        $this->descriprion = $descriprion;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param string $time
     * @return $this
     */
    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    /**
     * @param Author $author
     * @return $this
     */
    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    /**
     * @param Author $author
     * @return $this
     */
    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }
}

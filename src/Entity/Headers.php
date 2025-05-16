<?php

/**
* This file defines the Headers entity class for the La Boot'ique e-commerce platform. 
* 
* It represents website header sections that can be displayed throughout the site, typically as hero banners or promotional sections. 
* 
* The entity stores a title, descriptive content, call-to-action button details (both text and URL), and an associated image. 
* 
* The class uses Doctrine ORM annotations to map to the database and provides standard getter and setter methods for all properties. This entity enables the dynamic management of header content through the application's admin interface.
*/

namespace App\Entity;

use App\Repository\HeadersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeadersRepository::class)]
class Headers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'string', length: 255)]
    private $btnTitle;

    #[ORM\Column(type: 'string', length: 255)]
    private $btnUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getBtnTitle(): ?string
    {
        return $this->btnTitle;
    }

    public function setBtnTitle(string $btnTitle): self
    {
        $this->btnTitle = $btnTitle;

        return $this;
    }

    public function getBtnUrl(): ?string
    {
        return $this->btnUrl;
    }

    public function setBtnUrl(string $btnUrl): self
    {
        $this->btnUrl = $btnUrl;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}

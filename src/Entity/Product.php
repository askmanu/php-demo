<?php

/**
* The Product entity class defines the data structure for products in the La Boot'ique e-commerce platform. 
* 
* It maps to a database table through Doctrine ORM annotations and includes essential product attributes such as name, price, description, and image path. 
* The entity maintains a relationship with the Category entity, allowing products to be organized by category. 
* It also features a boolean flag to determine whether a product should appear on the homepage. 
* 
* Each property is accompanied by getter and setter methods that facilitate data access and modification while maintaining proper encapsulation.
*/

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    /**
    * Primary identifier property for the entity. This integer field serves as the auto-generated primary key in the database.
    * 
    */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $subtitle;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'float')]
    private $price;

    /**
    * Defines a many-to-one relationship between the Product entity and the Category entity, indicating that each product belongs to exactly one category.
    */
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\Column(type: 'boolean')]
    private $isInHome;

    /**
    * Gets the ID of the entity.
    * 
    * @return The ID of the entity as an integer, or null if no ID is set.
    */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
    * Gets the name value of the entity.
    * 
    * @return The name as a string or null if no name is set.
    */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
    * Sets the name property of the entity and returns the current instance.
    * 
    * @param string $name The name to be assigned to the entity
    * 
    * @return The current instance of the object for method chaining
    */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getIsInHome(): ?bool
    {
        return $this->isInHome;
    }

    public function setIsInHome(bool $isInHome): self
    {
        $this->isInHome = $isInHome;

        return $this;
    }
}

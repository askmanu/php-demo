<?php

/**
* This file defines the Category entity class for the La Boot'ique e-commerce platform. 
* 
* It represents product categories in the system and establishes a one-to-many relationship with products. 
* The entity includes properties for an ID and name, along with methods to manage the collection of associated products. 
* 
* The class uses Doctrine ORM annotations to map to the database and includes proper relationship management to maintain data integrity between categories and products. 
* 
* The implementation of the __toString() method enables easy representation of category objects as strings in forms and other UI components.
*/

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private $products;

    /**
    * Initializes a new instance of the class with an empty products collection.
    */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
    * Sets the name property of the entity and returns the current instance for method chaining.
    * 
    * @param string name The name to be assigned to the entity
    * 
    * @return The current instance of the object for method chaining
    */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
    * Retrieves the collection of products associated with this entity.
    * 
    * @return Collection object containing the products associated with this entity.
    */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
    * Adds a product to this category and establishes the bidirectional relationship by setting this category on the product. If the product is already in this category, no action is taken.
    * 
    * @param Product product The product to add to this category
    * 
    * @return The current Category instance for method chaining
    */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    /**
    * Removes a product from this category and updates the bidirectional relationship by setting the product's category to null if it was previously assigned to this category.
    * 
    * @param Product product The product to remove from this category
    * 
    * @return Returns the current Category instance to allow for method chaining
    */
    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    /**
    * Returns a string representation of this object by using its name property. This method is automatically called when the object is used in a string context.
    * 
    * @return string The name property of this object
    */
    public function __toString(): string
    {
        return $this->name;
    }

}

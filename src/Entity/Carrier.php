<?php

/**
* This file defines the Carrier entity class for the e-commerce platform, representing shipping options available to customers. 
* 
* The entity stores essential carrier information including a name, description, and price. 
* It includes standard getter and setter methods for all properties, plus a specialized method that formats carrier information for display purposes, converting the price from cents to a decimal format with currency symbol. 
* 
* The class is mapped to a database table using Doctrine ORM annotations, enabling persistent storage and retrieval of shipping carrier options throughout the application.
*/

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrierRepository::class)]
class Carrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'float')]
    private $price;

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
    * Sets the name property of the entity and returns the current instance for method chaining.
    * 
    * @param string $name The name to be assigned to the entity
    * 
    * @return self - Returns the current instance to allow method chaining
    */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
    * Retrieves the description value of the current object.
    * 
    * @return The description as a string or null if no description is set.
    */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
    * Sets the description for this entity.
    * 
    * @param string description The description text to set for this entity
    * 
    * @return The current instance of this class for method chaining
    */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
    * Gets the price value of the current object.
    * 
    * @return The price as a float value, or null if no price is set.
    */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
    * Sets the price value for this entity and enables method chaining.
    * 
    * @param float price The price value to set
    * 
    * @return self - Returns the current instance to enable method chaining
    */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCarrierLabel(): ?string
    {
        $price = number_format($this->price/100, 2);
        return "{$this->name}: [br]{$this->description}[br] $price € ";
    }
}

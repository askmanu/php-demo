<?php

/**
* The Address entity class defines the data structure for storing shipping and billing addresses in the La Boot'ique e-commerce platform. 
* 
* It maintains a relationship with the User entity, allowing each user to have multiple addresses associated with their account. 
* 
* The entity captures comprehensive address information including recipient details (name, first name, last name), optional company name, full address (street address, postal code, city, country), and contact phone number. 
* Each address instance can be uniquely identified and retrieved through its ID. The class provides a formatted address label method for display purposes. 
* 
* This entity supports the platform's checkout process by enabling users to select from their saved addresses when placing orders.
*/

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    /**
    * Primary key identifier for the entity. 
    * This integer value is automatically generated by the database.
    */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
    * A many-to-one relationship to the User entity, representing the owner of this address. 
    * Each address must be associated with exactly one user, while a user can have multiple addresses.
    * 
    */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'addresses')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $company;

    #[ORM\Column(type: 'string', length: 255)]
    private $address;

    #[ORM\Column(type: 'string', length: 255)]
    private $postal;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'string', length: 255)]
    private $country;

    #[ORM\Column(type: 'string', length: 255)]
    private $phone;

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
    * Returns the User object associated with this instance. May return null if no user is associated.
    * 
    * @return A User object if one is associated with this instance, or null if no user is associated.
    */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
    * Sets the user associated with this entity.
    * 
    * @param ?User user The User object to associate with this entity, or null to remove the association
    * 
    * @return Returns the current instance to allow method chaining
    */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
    * Gets the name value of the current object.
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
    * Retrieves the first name of the user.
    * 
    * @return The user's first name as a string, or null if no first name is set.
    */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
    * Sets the first name property of the user and returns the current instance to allow method chaining.
    * 
    * @param string firstname The first name to be set for the user
    * 
    * @return The current instance of the class for method chaining
    */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
    * Retrieves the last name of the user.
    * 
    * @return The user's last name as a string, or null if no last name is set.
    */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
    * Sets the last name of the user and returns the current instance for method chaining.
    * 
    * @param string lastname The last name to be set for the user
    * 
    * @return The current instance of the object for method chaining
    */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
    * Gets the company name associated with this entity.
    * 
    * @return The company name as a string, or null if no company is set.
    */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
    * Sets the company name and returns the current object instance to allow method chaining.
    * 
    * @param ?string company The company name to set, can be null
    * 
    * @return self - Returns the current instance to enable method chaining
    */
    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
    * Gets the address associated with this object.
    * 
    * @return The address as a string, or null if no address is set.
    */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
    * Sets the address for this entity and returns the current instance for method chaining.
    * 
    * @param string address The address to be set for this entity
    * 
    * @return The current instance of the class for method chaining
    */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
    * Retrieves the city value associated with this entity.
    * 
    * @return The city as a string, or null if no city is set.
    */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
    * Sets the city value for this entity and returns the current instance.
    * 
    * @param string $city The city name to set
    * 
    * @return self - Returns the current instance to enable method chaining
    */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
    * Retrieves the country value associated with this object.
    * 
    * @return The country as a string, or null if no country is set.
    */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
    * Sets the country value for this entity and returns the instance for method chaining.
    * 
    * @param string country The country name or code to be set
    * 
    * @return Returns the current instance to allow method chaining
    */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
    * Gets the phone number associated with this entity.
    * 
    * @return The phone number as a string, or null if no phone number is set.
    */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
    * Sets the phone number for this entity and enables method chaining.
    * 
    * @param string phone The phone number to be set
    * 
    * @return Returns the current instance of the object to enable method chaining
    */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
    * Retrieves the postal code associated with this object.
    * 
    * @return The postal code as a string, or null if no postal code is set.
    */
    public function getPostal(): ?string
    {
        return $this->postal;
    }

    /**
    * Sets the postal code value and returns the current instance.
    * 
    * @param string postal The postal code to be set
    * 
    * @return self - Returns the current instance to allow method chaining
    */
    public function setPostal(string $postal): self
    {
        $this->postal = $postal;

        return $this;
    }


    public function getAddressLabel(): string
    {
        return "{$this->name}: [br]{$this->address}[br]{$this->city}... ";
    }
}

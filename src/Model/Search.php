<?php

/**
* The Search class is a data model that encapsulates search criteria for the La Boot'ique e-commerce platform. 
* 
* It stores two types of search parameters: a text string for keyword searches and an array of categories for filtering products by category. 
* The class provides getter and setter methods for both properties, with setters implementing a fluent interface pattern that allows for method chaining. 
* 
* This model works in conjunction with a SearchType form to collect and structure user search inputs, which can then be passed to the application's search functionality to retrieve and display relevant products.
*/

namespace App\Model;

/**
 * Permet de créer un formulaire de recherche grace à un SearchType
 */
class Search
{
    /**
     * @var string
     */
    private $string = '';

    /**
     * @var array
     */
    private $categories = [];

    /**
    * Returns the string value stored in this object.
    * 
    * @return The string value stored in the object's `string` property.
    */
    public function getString()
    {
        return $this->string;
    }

    /**
    * Sets the string value for this object and returns the object instance to allow method chaining.
    * 
    * @param mixed string The string value to be set
    * 
    * @return The current object instance for method chaining
    */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
    * Returns the collection of categories associated with this object.
    * 
    * @return A collection of category objects or an array of categories.
    */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
    * Sets the categories for this entity.
    * 
    * @param mixed categories The categories to associate with this entity, typically an array or collection of Category objects.
    * 
    * @return The current instance for method chaining.
    */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }
}
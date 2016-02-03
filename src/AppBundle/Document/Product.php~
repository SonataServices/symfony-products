<?php
// src/AppBundle/Document/Product.php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\Float
     */
    protected $price;
    
    /**
    *@MongoDB\ReferenceOne(targetDocument="Store", inversedBy="products")
    */
    protected $store;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set store
     *
     * @param AppBundle\Document\Store $store
     * @return self
     */
    public function setStore(\AppBundle\Document\Store $store)
    {
        $this->store = $store;
        return $this;
    }

    /**
     * Get store
     *
     * @return AppBundle\Document\Store $store
     */
    public function getStore()
    {
        return $this->store;
    }
}

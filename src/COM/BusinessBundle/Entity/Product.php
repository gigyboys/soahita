<?php

namespace COM\BusinessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="bs_product")
 * @ORM\Entity(repositoryClass="COM\BusinessBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
    /**
    * @ORM\ManyToOne(targetEntity="COM\BusinessBundle\Entity\Category")
    * @ORM\JoinColumn(nullable=false)
    */
    private $category;
	
    /**
    * @ORM\ManyToOne(targetEntity="COM\BusinessBundle\Entity\Brand")
    * @ORM\JoinColumn(nullable=true)
    */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var int
     *
     * @ORM\Column(name="quantityalert", type="integer")
     */
    private $quantityalert;

    /**
     * @var string
     *
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set quantityalert
     *
     * @param integer $quantityalert
     *
     * @return Stock
     */
    public function setQuantityalert($quantityalert)
    {
        $this->quantityalert = $quantityalert;

        return $this;
    }

    /**
     * Get quantityalert
     *
     * @return int
     */
    public function getQuantityalert()
    {
        return $this->quantityalert;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Stock
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Product
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set category
     *
     * @param \COM\BusinessBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\COM\BusinessBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \COM\BusinessBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set brand
     *
     * @param \COM\BusinessBundle\Entity\Brand $brand
     *
     * @return Product
     */
    public function setBrand(\COM\BusinessBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \COM\BusinessBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }
}

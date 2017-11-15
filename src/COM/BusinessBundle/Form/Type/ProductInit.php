<?php

namespace COM\BusinessBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class ProductInit
{
    private $name;
    private $description;
    private $reference;
    private $categoryId;
    private $brandId;
    private $quantityalert;
	
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
	
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
	
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }
	
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }
	
    public function setBrandId($brandId)
    {
        $this->brandId = $brandId;

        return $this;
    }

    public function getBrandId()
    {
        return $this->brandId;
    }
	
    public function setQuantityalert($quantityalert)
    {
        $this->quantityalert = $quantityalert;

        return $this;
    }

    public function getQuantityalert()
    {
        return $this->quantityalert;
    }
}

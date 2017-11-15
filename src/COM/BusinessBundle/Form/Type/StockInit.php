<?php

namespace COM\BusinessBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class StockInit
{
    private $productId;
    private $date;
    private $price;
    private $quantity;
    private $description;
	
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }
	
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }
	
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }
	
    public function setSellingprice($sellingprice)
    {
        $this->sellingprice = $sellingprice;

        return $this;
    }

    public function getSellingprice()
    {
        return $this->sellingprice;
    }
	
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
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
}

<?php

class Category
{
    public $id;
    public $name;
    public $createdAt;
    public $updatedAt;

    public function __construct($name)
    {
        $this->name = $name;
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');
    }
}



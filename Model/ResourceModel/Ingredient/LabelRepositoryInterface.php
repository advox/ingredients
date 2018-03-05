<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Model\ResourceModel\Ingredient;

interface LabelRepositoryInterface
{
    
    public function get(int $id) : \Powerbody\Ingredients\Model\Ingredient\Label;
    
    public function getByProductId(int $productId) : \Powerbody\Ingredients\Model\Ingredient\Label;
    
}

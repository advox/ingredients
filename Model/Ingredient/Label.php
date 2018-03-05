<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Model\Ingredient;

class Label extends \Magento\Framework\Model\AbstractModel
{
    
    public function _construct()
    {
        $this->_init(\Powerbody\Ingredients\Model\ResourceModel\Ingredient\Label::class);
    }
    
}

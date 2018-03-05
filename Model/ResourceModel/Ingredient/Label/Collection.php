<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Model\ResourceModel\Ingredient\Label;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    protected function _construct()
    {
        $this->_init(
            \Powerbody\Ingredients\Model\Ingredient\Label::class,
            \Powerbody\Ingredients\Model\ResourceModel\Ingredient\Label::class
        );
    }
    
}

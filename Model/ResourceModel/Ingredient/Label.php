<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Model\ResourceModel\Ingredient;

class Label extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    protected $_mainTable = 'ingredient_label';
    protected $_idFieldName = 'label_id';
    
    protected function _construct()
    {
        $this->_init($this->_mainTable, $this->_idFieldName);
    }
    
    public function getIdByProductId(int $productId) : int
    {
        $select = $this->getConnection()
            ->select()
            ->from(['main_table' => $this->_mainTable])
            ->where('product_id=?', $productId);
    
        return (int) $select->getConnection()->fetchOne($select);
    }
    
}

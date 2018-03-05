<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Model\ResourceModel\Ingredient;

class LabelRepository implements LabelRepositoryInterface
{
    
    /** @var \Powerbody\Ingredients\Model\ResourceModel\Ingredient\Label */
    private $labelResource;
    
    /** @var \Powerbody\Ingredients\Model\Ingredient\LabelFactory */
    private $labelModelFactory;
    
    public function __construct(
        \Powerbody\Ingredients\Model\ResourceModel\Ingredient\Label $labelResource,
        \Powerbody\Ingredients\Model\Ingredient\LabelFactory $labelModelFactory
    ) {
        $this->labelResource = $labelResource;
        $this->labelModelFactory = $labelModelFactory;
    }
    
    public function get(int $id) : \Powerbody\Ingredients\Model\Ingredient\Label
    {
        /** @var \Powerbody\Ingredients\Model\Ingredient\Label $model */
        $model = $this->labelModelFactory->create();
    
        $this->labelResource->load($model, $id);
        if (true === empty($model->getId())) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested label does not exist'));
        }
        
        return $model;
    }
    
    public function getByProductId(int $productId) : \Powerbody\Ingredients\Model\Ingredient\Label
    {
        $labelId = $this->labelResource->getIdByProductId($productId);
        if (true === empty($labelId)) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested label does not exist'));
        }
        
        return $this->get($labelId);
    }
    
}

<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Block\Product\View;

use Powerbody\Ingredients\Model\ResourceModel\Ingredient\LabelRepositoryInterface;
use Powerbody\Ingredients\Service\Ingredient\LabelInterface;

class Label extends \Magento\Framework\View\Element\Template
{
    
    /** @var \Magento\Framework\Registry */
    private $coreRegistry = null;
    
    /** @var LabelRepositoryInterface */
    private $labelRepository = null;
    
    /** @var \Powerbody\Ingredients\Service\Ingredient\LabelInterface */
    private $labelService;
    
    /** @var \Powerbody\Ingredients\Model\Ingredient\Label */
    private $product = null;
    
    /** @var \Magento\Catalog\Model\Product */
    private $label = null;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        LabelRepositoryInterface $labelRepository,
        LabelInterface $labelService,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->labelRepository = $labelRepository;
        $this->labelService = $labelService;
        
        parent::__construct($context, $data);
    }
    
    public function getProduct() : \Magento\Catalog\Model\Product
    {
        if (null === $this->product) {
            $this->product = $this->coreRegistry->registry('product');
        }
        
        return $this->product;
    }
    
    /**
     * @return \Powerbody\Ingredients\Model\Ingredient\Label|null
     */
    public function getLabel()
    {
        if (null !== $this->label) {
            return $this->label;
        }
        
        $product = $this->getProduct();
        if (null === $product || null === $product->getId()) {
            return null;
        }
    
        $productId = (int) $product->getId();
        
        try {
            $this->label = $this->labelRepository->getByProductId($productId);
        } catch (\Exception $e) {
        }
        
        return $this->label;
    }
    
    public function getLabelService() : LabelInterface
    {
        return $this->labelService;
    }
    
}

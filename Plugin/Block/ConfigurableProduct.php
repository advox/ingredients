<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Plugin\Block;

use Magento\ConfigurableProduct\Block\Product\View\Type\Configurable;

class ConfigurableProduct
{
    
    /** @var \Powerbody\Ingredients\Model\ResourceModel\Ingredient\LabelRepositoryInterface */
    private $labelRepository;
    
    /** @var \Powerbody\Ingredients\Service\Ingredient\LabelInterface */
    private $labelService;
    
    public function __construct(
        \Powerbody\Ingredients\Model\ResourceModel\Ingredient\LabelRepositoryInterface $labelRepository,
        \Powerbody\Ingredients\Service\Ingredient\LabelInterface $labelService
    ) {
        $this->labelRepository = $labelRepository;
        $this->labelService = $labelService;
    }
    
    /**
     * @param Configurable $subject
     * @param mixed $result
     *
     * @return string
     */
    public function afterGetJsonConfig(Configurable $subject, $result) : string
    {
        $jsonResult = json_decode($result, true);
        
        $jsonResult['ingredientsLabels'] = [];
        foreach ($subject->getAllowProducts() as $simpleProduct) {
            /** @var \Powerbody\Ingredients\Model\Ingredient\Label $label */
            $label = null;
            
            try {
                $productId = (int) $simpleProduct->getId();
                $label = $this->labelRepository->getByProductId($productId);
            } catch (\Exception $e) {
            }
            
            $jsonResult['ingredientsLabels'][$simpleProduct->getId()] = ($label && null !== $label->getId())
                ? $this->labelService->getUrl($label)
                : null;
        }
        
        return json_encode($jsonResult);
    }
    
}

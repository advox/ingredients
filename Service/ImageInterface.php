<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Service;

interface ImageInterface
{
    
    public function generateImage(\Powerbody\Ingredients\Model\Ingredient\Label $label, array $labelData);
    
}

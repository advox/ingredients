<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Service\Ingredient;

use Powerbody\Ingredients\Model\Ingredient\Label as LabelModel;

interface LabelInterface
{
    
    public function getFilePath(LabelModel $label) : string;
    
    public function getUrl(LabelModel $label) : string;
    
}

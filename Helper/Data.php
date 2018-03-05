<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    const WATERMARK_DIR = 'ingredients/watermark/';
    
    /** @var \Magento\Framework\App\Filesystem\DirectoryList */
    private $directoryList;
    
    public function __construct(
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        $this->directoryList = $directoryList;
    }
    
    public function getWatermarkPath(string $name) : string
    {
        return self::WATERMARK_DIR . $name;
    }
    
    public function getWatermarkFullPath(string $name) : string
    {
        return $destinationFile = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)
            . DIRECTORY_SEPARATOR
            . $this->getWatermarkPath($name);
    }
    
}

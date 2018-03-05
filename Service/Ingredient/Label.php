<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Service\Ingredient;

use Powerbody\Ingredients\Model\Ingredient\Label as LabelModel;

class Label implements LabelInterface
{
    
    const IMAGE_DIR = 'ingredients/labels/';
    const IMAGE_EXT = '.png';
    
    /** @var \Magento\Framework\Filesystem\Directory\WriteInterface */
    private $mediaDirectory;
    
    /** @var \Magento\Store\Model\StoreManagerInterface */
    private $storeManager;
    
    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
    }
    
    public function getFilePath(LabelModel $label) : string
    {
        return $this->mediaDirectory->getAbsolutePath(self::IMAGE_DIR)
            . $label->getId()
            . self::IMAGE_EXT;
    }
    
    public function getUrl(LabelModel $label) : string
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
            . $this->mediaDirectory->getRelativePath(self::IMAGE_DIR)
            . $label->getId()
            . self::IMAGE_EXT;
    }
    
}

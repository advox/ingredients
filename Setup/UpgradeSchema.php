<?php

namespace Powerbody\Ingredients\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    
    /** @var \Magento\Framework\Filesystem\Directory\WriteInterface */
    private $mediaDirectory;
    
    public function __construct(
        \Magento\Framework\Filesystem $filesystem
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }
    
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $labelsDirPath = $this->mediaDirectory->getAbsolutePath(\Powerbody\Ingredients\Service\Ingredient\Label::IMAGE_DIR);
            if (false === file_exists($labelsDirPath)) {
                mkdir($labelsDirPath, 0777, true);
            }
            
            $watermarkDirPath = $this->mediaDirectory->getAbsolutePath(\Powerbody\Ingredients\Helper\Data::WATERMARK_DIR);
            if (false === file_exists($watermarkDirPath)) {
                mkdir($watermarkDirPath, 0777, true);
            }
        }
    }
    
}

<?php

declare(strict_types=1);

namespace Powerbody\Ingredients\Service;

class Image implements ImageInterface
{
    const WATERMARK_WIDTH = 300;
    const WATERMARK_HEIGHT = 300;
    const WATERMARK_OPACITY = 10;
    
    const TMP_FILE = 'ingredient_label';
    
    /** @var \Powerbody\Bridge\System\Configuration\ConfigurationReaderInterface */
    private $configurationReader;
    
    /** @var \Powerbody\Ingredients\Helper\Data */
    private $ingredientsHelper;
    
    /** @var \Powerbody\Ingredients\Service\Ingredient\LabelInterface */
    private $labelService;
    
    /** @var \Magento\Framework\App\Filesystem\DirectoryList */
    private $directoryList;
    
    /** @var \Magento\Framework\ImageFactory */
    private $imageFactory;
    
    public function __construct(
        \Powerbody\Bridge\System\Configuration\ConfigurationReaderInterface $configurationReader,
        \Powerbody\Ingredients\Helper\Data $ingredientsHelper,
        \Powerbody\Ingredients\Service\Ingredient\LabelInterface $labelService,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\ImageFactory $imageFactory
    ) {
        $this->configurationReader = $configurationReader;
        $this->ingredientsHelper = $ingredientsHelper;
        $this->labelService = $labelService;
        $this->directoryList = $directoryList;
        $this->imageFactory = $imageFactory;
    }
    
    public function generateImage(
        \Powerbody\Ingredients\Model\Ingredient\Label $label,
        array $labelData
    ) {
        $tmpLabelPath = $this->downloadOriginalImage($labelData);
        
        $watermarkImageName = $this->configurationReader->getIngredientLabelWatermarkImage();
        
        if (false === empty($watermarkImageName)) {
            $watermarkImagePath = $this->ingredientsHelper->getWatermarkFullPath($watermarkImageName);
            $this->generateImageWithWatermark($tmpLabelPath, $watermarkImagePath, $tmpLabelPath);
            $this->bindImageToLabel($label, $tmpLabelPath);
        }
        
    }
    
    public function bindImageToLabel(\Powerbody\Ingredients\Model\Ingredient\Label $label, string $path)
    {
        if (false === file_exists($path)) {
            throw new \Exception('Image file not exists.');
        }
    
        $destPath = $this->labelService->getFilePath($label);
        $destDirPath = dirname($destPath);
    
        if (false === file_exists($destDirPath)) {
            $result = @mkdir($destDirPath, 0777, true);
            if (null === $result) {
                throw new \Exception('Unable to create directory.');
            }
        }
        
        if (true === file_exists($destPath)) {
            $result = @unlink($destPath);
            if (null === $result) {
                throw new \Exception('Unable to unlink old file.');
            }
        }
        
        $result = @rename($path, $destPath);
        if (null === $result) {
            throw new \Exception('Unable to copy image file.');
        }
    }
    
    private function downloadOriginalImage(array $labelData) : string
    {
        $downloadFile = $labelData['image_url'];
    
        $destinationFile = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::TMP)
            . DIRECTORY_SEPARATOR
            . self::TMP_FILE;
        
        $curlHandler = curl_init($downloadFile);
        curl_setopt($curlHandler, CURLOPT_NOBODY, true);
        curl_exec($curlHandler);
        $statusCode = (int) curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);
        curl_close($curlHandler);
        
        if ($statusCode == 200) {
            $result = @copy($downloadFile, $destinationFile);
            if (null === $result) {
                throw new \Exception('Unable to copy downloaded file.');
            }
        } else {
            throw new \Exception('Can not copy image: ' . $labelData['image_url']);
        }
        
        return $destinationFile;
    }
    
    private function generateImageWithWatermark(string $sourcePath, string $watermarkPath, string $destinationPath)
    {
        /** @var \Magento\Framework\Image $image */
        $image = $this->imageFactory->create([
            'fileName' => $sourcePath,
        ]);
        $image->setWatermarkWidth(self::WATERMARK_WIDTH);
        $image->setWatermarkHeight(self::WATERMARK_HEIGHT);
        $image->keepAspectRatio(true);
        $image->setWatermarkImageOpacity(self::WATERMARK_OPACITY);
        $image->setWatermarkPosition(\Magento\Framework\Image\Adapter\AbstractAdapter::POSITION_CENTER);
        $image->watermark($watermarkPath);
        $image->quality(100);
        
        $image->save($destinationPath);
    }
    
}

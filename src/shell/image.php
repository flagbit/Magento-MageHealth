<?php
require 'abstract.php';

class Mage_Shell_Image extends Mage_Shell_Abstract
{
    private $_db_images = array();

    private $_file_images = array();

    private $_files_to_delete = array();

    public function run()
    {
        if ($this->getArg('clean')) {
            $this->cleanImages();
        } elseif ($this->getArg('check')) {
            $this->checkImages();
        }
        else {
            echo $this->usageHelp();
        }
    }

    /**
     * Deletes all the unnecessary images from the system
     */
    public function cleanImages()
    {
        $path = $this->getMediaPath();
        foreach ($this->getDeletableMediaFiles() as $file) {
            unlink($path . $file);
            echo $path . $file.PHP_EOL;
        }
    }

    /**
     * print out all the unnecessary images from the system
     */
    public function checkImages()
    {
        foreach ($this->getDeletableMediaFiles() as $file) {
            echo $file . PHP_EOL;
        }

    }

    /**
     * Returns an array containing unnecessary images.
     *
     * @return array
     */
    protected function getDeletableMediaFiles()
    {
        if (empty($this->_files_to_delete)) {
            foreach ($this->getMediaDirImages() as $file) {
                if (!in_array($file, $this->getMediaImages())) {
                    $this->_files_to_delete[] = $file;
                }
            }
        }
        return $this->_files_to_delete;
    }

    /**
     * get all Images which are attached to a product
     *
     * @return array
     */
    protected function getMediaImages()
    {
        if (empty($this->_db_images)) {
            /** @var $con Varien_Db_Adapter_Interface */
            $con = Mage::getSingleton('core/resource')->getConnection('core_read');
            $this->_db_images = $con->fetchCol('SELECT value FROM catalog_product_entity_media_gallery');
        }
        return $this->_db_images;
    }

    /**
     * @return array
     */
    protected function getMediaDirImages()
    {
        if (empty($this->_file_images)) {
            $path = $this->getMediaPath();
            $it = new RecursiveDirectoryIterator($path);
            $filtered = new ImageRecursiveFilterIterator($it);
            /** @var $file SplFileInfo */
            foreach (new RecursiveIteratorIterator($filtered, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
                if ($file->isFile()) {
                    $this->_file_images[] = str_replace($path, '', $file->getPathname());
                }
            }
        }
        return $this->_file_images;
    }

    /**
     * path to product images
     *
     * @return string
     */
    protected function getMediaPath()
    {
        return Mage::getBaseDir('media') . DS . 'catalog' . DS . 'product';
    }

    /**
     * @return string
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f image.php -- [options]

  --clean                start cleaning up lost images
  --check                 print out all lost images in media folder
  help                   This help

USAGE;
    }
}

$shell = new Mage_Shell_Image();
$shell->run();

class ImageRecursiveFilterIterator extends RecursiveFilterIterator
{

    public static $FILTERS
        = array(
            'cache',
        );

    public function accept()
    {
        return !in_array(
            $this->current()->getFilename(),
            self::$FILTERS,
            true
        );
    }

}

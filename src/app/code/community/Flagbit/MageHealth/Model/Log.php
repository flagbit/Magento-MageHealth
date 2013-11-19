<?php

class Flagbit_MageHealth_Model_Log
{

    const XML_PATH_LOG_ROTATE_CLEAN_AFTER_DAY            = 'magehealth/log/clean_after_day';

    /**
     * rotate logfiles
     *
     * @return int
     */
    public function rotate()
    {
        $logdir = Mage::getBaseDir('log');
        $dirObject = new DirectoryIterator($logdir);
        $fileCounter = 0;

        /* @var $fileObject DirectoryIterator */
        foreach($dirObject as $fileObject){
            if(!$fileObject->isFile() || !$fileObject->isWritable()){
                continue;
            }
            switch(pathinfo($fileObject->getFilename(), PATHINFO_EXTENSION)){

                case 'log':
                    rename($fileObject->getPathname(), $fileObject->getPathname().'.tmp');
                    if($this->gzCompressFile($fileObject->getPathname().'.tmp', $logdir.DS.$fileObject->getFilename().'-'.date('Ymd').'.gz')){
                        unlink($fileObject->getPathname().'.tmp');
                    }
                    $fileCounter++;
                    break;

                case 'gz':
                    if(preg_match('/^(.*)\.log-([0-9]{8})\.gz$/', $fileObject->getFilename(), $match)){
                        if(strtotime($match[2]) < time() - Mage::getStoreConfig(self::XML_PATH_LOG_ROTATE_CLEAN_AFTER_DAY) * 86400){
                            unlink($fileObject->getPathname());
                        }
                    }
                    $fileCounter++;
                    break;
            }
        }
        return $fileCounter;
    }


    /**
     * gzip file
     *
     * @param $source
     * @param $destination
     * @param int $level
     * @return bool
     */
    function gzCompressFile($source, $destination, $level=9)
    {
        $successfully=true;

        if($fp_out=gzopen($destination, 'wb'.$level)){
            if($fp_in=fopen($source,'rb')){
                while(!feof($fp_in)) {
                    gzwrite($fp_out,fread($fp_in,1024*512));
                }
                fclose($fp_in);
            }else{
                $successfully = false;
            }
            gzclose($fp_out);
        }else {
            $successfully = false;
        }
        return $successfully;
    }



}
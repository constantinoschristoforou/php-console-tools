<?php

namespace Con\Tools\Lib;

class ImageOptimizer
{
    const OPTIMIZE_IMAGE_DIR = 'MyOptImages';

    protected $path;
    protected $recursive;
    protected $overwriteImages;
    protected $quality;

    function __construct()
    {
        $this->recursive = false;
        $this->overwriteImages = false;

        //default
        $this->quality=80;

    }

    public function setRecursive( $recursive )
    {

        $this->recursive = $recursive;
    }

    public function setQuality($value){
        $this->quality=$value;
    }

    public function setPath( $path )
    {
        $this->path = $path;
    }

    public function getOptimizeDirPath($path){

        $newPath=str_replace(basename($this->path),self::OPTIMIZE_IMAGE_DIR,$path);

        return $newPath;
    }

    public function optimize()
    {

        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path), \RecursiveIteratorIterator::SELF_FIRST);
        foreach ( $objects as $name => $object ) {

            if ( $this->isValidImage($object) ) {
                $this->optimizeImage($name);
            }
        }

    }


    private function getSupportedImageFileExtensions()
    {
        return ['jpg', 'png'];
    }

    public function isImage( $path )
    {
        $ext =$path->getExtension();

        if ( in_array($ext, $this->getSupportedImageFileExtensions()) ) {

            return true;
        }

        return false;
    }


    public function isValidImage( $path )
    {
        if ( is_file($path) && $this->isImage($path) ) {
            return true;
        }

        return false;
    }


    public function optimizeImage( $image )
    {
        $imageDir= dirname($image);
        $optimizedDir=$this->getOptimizeDirPath($imageDir);

        if (!file_exists($optimizedDir)) {
            mkdir($optimizedDir, 0777, true);
        }

        $imageName=basename($image);

        shell_exec ( 'convert '.$image.' -quality  '.$this->quality .' ' .  $optimizedDir.DIRECTORY_SEPARATOR.$imageName );

    }

}
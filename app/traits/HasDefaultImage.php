<?php


namespace app\traits;


trait HasDefaultImage
{
    public function getImage($altText) {
        if(!$this->fileName){
            return "https://ui-avatars.com/api/?name=$altText&size=160";
        }
        return $this->fileName;
    }
}
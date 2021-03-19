<?php
namespace app\controllers;

use \Twig_Loader_Filesystem;
use Laminas\Diactoros\Response\HtmlResponse;

class baseController{
    protected $templateEngine;

    public function __construct(){

        $loader = new \Twig\Loader\FilesystemLoader('../views');
        $this->templateEngine = new \Twig\Environment($loader, array(
            'debug' => true,
            'cache' => false,
        ));

    }

    public function renderHTML($fileName, $data = []){
        return new HtmlResponse($this->templateEngine->render($fileName, $data));
    }
}
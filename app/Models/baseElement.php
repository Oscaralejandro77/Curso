<?php

namespace app\Models;
require_once 'printable.php';

class baseElement implements printable{
    //private $title; solo para la calse baseElement
    protected $title; //privada el cual solo tienen acceso las clases hijos
    public $description;
    public $visible = true;
    public $months;

    public function __construct($title, $description){
      $this->setTitle($title);
      $this->description = $description;
    }

    public function setTitle($t){
      if($t == ''){
        $this->title = 'N/A';
      } else{
        $this->title = $t;
      }
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDurationAsString(){
      $years = floor($this->months / 12);
      $extraMonths = $this->months % 12;
      
    
      if($years < 1){
        return "$extraMonths months";
      } else if($extraMonths < 1){
        return "$years years";
      } else {
        return "$years years $extraMonths months";
      }
    }

    public function getDescription(){
      return $this->description;
    }

}